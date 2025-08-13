<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController as BaseController;
use App\Models\Operator;
use App\Models\SmsToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Pishran\IpPanel\Client;

class AuthController extends BaseController
{
    public function checkMobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^09(0|1|2|3|9)-?[0-9]{4}-?[0-9]{4}$/']
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        if (User::whereMobile($request->mobile)->exists()) {
            $user = User::whereMobile($request->mobile)->first();

            if ($user->is_ban) {
                $ban_reason = $user->ban_reason;
                return $this->sendError('User has been banned!', $ban_reason, 403);
            }

            $this->sendSms($user->id, $request->mobile);
            $success['exist'] = true;
            return $this->sendResponse($success, 'User exist.');
        }
        else {
            $user_data['mobile'] = $request->mobile;
            $user_data['operator_id'] = $this->mobileOperator($request->mobile);

            try {
                $user = User::create($user_data);
                $this->sendSms($user->id, $request->mobile);
                $success['exist'] = false;
                return $this->sendResponse($success, 'User created.', 201);
            }
            catch (QueryException $exception)
            {
                $message = $exception->getMessage();
                return $this->sendError('Database error', 'Unable to create user', 500);
                //return $this->sendError($message, $exception->getCode());
            }
        }
    }
    public function sendSms($userid, $mobile)
    {
        try {
            $ranCode = random_int(10000, 99999);
            SmsToken::create([
                'user_id' => $userid,
                'code' => Hash::make($ranCode)
            ]);

            $client = new Client(config('services.ippanel.api_key'));
            $patternCode = config('services.ippanel.pattern_code'); // شناسه الگو
            $originator = config('services.ippanel.originator'); // شماره فرستنده
            $recipient = $mobile; // شماره گیرنده
            $values = ['verification-code' => $ranCode]; // متغیرهای الگو

            $client->sendPattern($patternCode, $originator, $recipient, $values);
            \Log::info('SMS sent to mobile: ' . $mobile . ' for user: ' . $userid);
        } catch (\Exception $e) {
            \Log::error('Failed to send SMS: ' . $e->getMessage());
            throw new \Exception('Unable to send SMS', 500);
        }
    }

    public function mobileOperator($mobile)
    {
        $threemobiledigits = substr($mobile, 0, 3);
        $fourmobiledigits = substr($mobile, 0, 4);
        if($threemobiledigits == "090" || $threemobiledigits == "093")
        {
            $brand = "MTN";
            $operator = Operator::where('brand', '=', $brand)->first();
            $operatorId = $operator->id;
        }
        else if($threemobiledigits == "091" || $fourmobiledigits == "0990" || $fourmobiledigits == "0991" || $fourmobiledigits == "0992")
        {
            $brand = "MCI";
            $operator = Operator::where('brand', '=', $brand)->first();
            $operatorId = $operator->id;
        }
        else if($fourmobiledigits == "0921" || $fourmobiledigits == "0922")
        {
            $brand = "RTL";
            $operator = Operator::where('brand', '=', $brand)->first();
            $operatorId = $operator->id;
        }
        else
        {
            $operatorId = Null;
        }
        return $operatorId;
    }
    public function checkSms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'regex:/^09(0|1|2|3|9)-?[0-9]{4}-?[0-9]{4}$/'],
            'sms' => 'required|integer|min_digits:5'
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        if (User::whereMobile($request->mobile)->exists()) {
            $user = User::whereMobile($request->mobile)->first();
            $userid = $user->id;
            $smsToken = SmsToken::where('user_id', $userid)->first();
            if($smsToken == NULL || !Hash::check($request->sms, $smsToken->code)) {
                return $this->sendError('smsCode', 'این کد تائیدیه صحیح نیست');
            }
            elseif($smsToken->is_used == true) {
                return $this->sendError('smsCode', 'این کد تائیدیه استفاده شده است');
            }
            elseif(Carbon::parse($smsToken->created_at)->addSeconds(120)->lt(now())) {
                return $this->sendError('smsCode', 'این کد تائیدیه منقضی شده است');
            }
            else {
                $smsToken->update([
                    'is_used' => true
                ]);
                if ($user->mobile_verified_at == null) {
                    $user->update([
                        'mobile_verified_at' => now()
                    ]);
                }
                foreach ($user->tokens as $token) {
                    $token->delete();
                }
                $success['token'] = $user->createToken('app-token')->plainTextToken;
                $success['name'] =  $user->name;
                $success['surname'] =  $user->surname;
                $success['credit'] =  $user->credit;

                return $this->sendResponse($success, 'User signed in');
            }
        }
        else {
            return $this->sendError('Unauthorised.', 'Unauthorised', 401);
        }
    }
}
