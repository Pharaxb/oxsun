<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseController as BaseController;
use App\Http\Resources\v1\AdCollection;
use App\Http\Resources\v1\AdResource;
use App\Models\Ad;
use App\Models\AdLocation;
use App\Models\Age;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserLocation;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Ramsey\Uuid\Uuid;

class AdController extends BaseController
{
    /*public function test(Request $request)
    {
        $text = '';
        foreach ($request->except('_token') as $key => $part) {
            if ($part != null)
            {
                $text .= $key.'--'.$part;
            }
        }
        Storage::put('requestAll.txt',$text);
    }*/

    /**
     * Show Ad.
     *
     * Show the given ad.
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required'
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        $user = Auth::user();
        $userId =  $user->id;
        $uuid = $request->uuid;

        try {
            $ad = Ad::where('uuid', $uuid)
                ->whereRaw('circulation > viewed')
                ->where('status_id', 4)
                ->where(function ($query) {
                    $query->whereRaw('start_date <= NOW()')
                        ->orWhereNull('start_date');
                })
                ->where(function ($query) {
                    $query->whereRaw('end_date > NOW()')
                        ->orWhereNull('end_date');
                })
                ->whereNotIn('id',function($query) use ($userId) {
                    $query->select('ad_id')->from('ad_user')
                        ->where('user_id', $userId)
                        ->where('status', '!=', 'U');
                })
                ->firstOrFail();

            if(!$ad) {
                return $this->sendError('Not Found!', 'Not Found!');
            }

            $ad->adUser()->attach($userId, ['status' => 'U']);

            return $this->sendResponse(new AdResource($ad), 'Ad fetched.');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->sendError('Not Found!', $e->getCode());
        }
    }


    /**
     * Verify Seen Ad.
     *
     * Verify that the user has seen the ad.
     */
    public function seen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required'
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        $user = Auth::user();
        $userId = $user->id;
        $uuid = $request->uuid;

        try {
            $ad = Ad::where('uuid', $uuid)
                ->whereIn('id',function($query) use ($userId) {
                    $query->select('ad_id')->from('ad_user')
                        ->where('user_id', $userId)
                        ->where('status', 'U');
                })
                ->firstOrFail();

            $cost = $ad->cost;

            if ($ad->circulation <= $ad->viewed)
            {
                return $this->sendError('View Limit', "Maximum view has been reached!");
            }

            $created_at = $ad->adUser->first()->pivot['created_at'];
            if(Carbon::parse($created_at)->addSeconds(15)->lt(now()))
            {
                $ad->adUser()->updateExistingPivot($userId, [
                    'status' => 'S',
                ]);
                $user->increment('credit',$cost);
                $ad->increment('viewed', 1);

                $user->wallets()->create([
                    'amount' => $cost,
                    'description' => 'مشاهده آگهی'
                ]);

                return $this->sendResponse("", "Congratulation");
            }
            else
            {
                return $this->sendError('Time is not over!', "Time is not over!", 425);
            }
        }
        catch(ModelNotFoundException $e)
        {
            return $this->sendError('Not Found!', $e->getCode(), 400);
        }
    }

    /*
     * Get List of Ads.
     *
     * @response array{success: bool, data: array{rows: AdResource[], pagination: array{total: int, count: int, per_page: int, current_page: int, total_pages: int}}, message: string, code: int}
     */


    /**
     * List of Ads.
     *
     * List of all ads based on the user's location.
     */

    public function getAds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'page' => 'nullable|integer|min:1',
        ]);

        if($validator->fails()){
            $validatorError = $validator->errors()->all();
            return $this->sendError('Error validation', $validatorError[0], 400);
        }

        $user = Auth::user();
        $userId =  $user->id;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $userGeo = $this->getUserLocation($userId, $latitude, $longitude);
        if(isset($userGeo['province_id'])) {
            $province = $userGeo['province_id'];
        }
        $city = $userGeo['city_id'];
        $district = $userGeo['district_id'];
        $gender = $user->gender;
        $userAge = Carbon::parse($user->birthday)->diffInYears(Carbon::now());
        $userAgeCeil = 5 * ceil($userAge / 5);
        $userAgeRange = Age::where('group', '=', $userAgeCeil)->pluck('id')->first();
        $operator = $user->operator_id;

        try
        {
            $ads = Ad::with('adLocations')
                ->withExists('adUser')
                ->where('status_id', 4)
                ->where('is_verify', 1)
                ->whereRaw('circulation > viewed')
                ->where(function ($query) {
                    $query->whereRaw('start_date <= NOW()')
                        ->orWhereNull('start_date');
                })
                ->where(function ($query) {
                    $query->whereRaw('end_date > NOW()')
                        ->orWhereNull('end_date');
                })
                ->WhereHas('adLocations', function($query) use ($province){
                    $query->where('province_id', $province)
                        ->orWhereNull('province_id');
                })
                ->WhereHas('adLocations', function($query) use ($city){
                    $query->where('city_id', $city)
                        ->orWhereNull('city_id');
                })
                ->WhereHas('adLocations', function($query) use ($district){
                    $query->where('district_id', $district)
                        ->orWhereNull('district_id');
                })
                ->where(function ($query) use ($gender) {
                    $query->where('gender', $gender)
                        ->orWhereNull('gender');
                })
                ->where(function ($query) use ($operator) {
                    $query->where('operator_id', $operator)
                        ->orWhereNull('operator_id');
                })
                ->where(function ($query) use ($userAgeRange) {
                    $query->when($userAgeRange != NULL, function($query2) use ($userAgeRange) {
                        $query2->where('min_age_id', '<=', $userAgeRange)
                            ->orWhereNull('min_age_id');
                    })
                    ->when($userAgeRange == NULL, function($query2) use ($userAgeRange) {
                        $query2->whereNull('min_age_id');
                    });
                })
                ->where(function ($query) use ($userAgeRange) {
                    $query->when($userAgeRange != NULL, function($query2) use ($userAgeRange) {
                        $query2->where('max_age_id', '>=', $userAgeRange)
                            ->orWhereNull('max_age_id');
                    })
                    ->when($userAgeRange == NULL, function($query2) use ($userAgeRange) {
                        $query2->whereNull('max_age_id');
                    });
                })
                /*->when($userAgeRange != NULL, function($query) use ($userAgeRange) {
                    $query->where('min_age_id', '<=', $userAgeRange)
                        ->orWhereNull('min_age_id');
                })
                ->when($userAgeRange != NULL, function($query) use ($userAgeRange) {
                    $query->where('max_age_id', '>', $userAgeRange)
                        ->orWhereNull('max_age_id');
                })
                ->where(function ($query) use ($userAgeRange) {
                    $query->where('min_age_id', '<=', $userAgeRange)
                        ->orWhereNull('min_age_id');
                })
                ->where(function ($query) use ($userAgeRange) {
                    $query->where('max_age_id', '>', $userAgeRange)
                        ->orWhereNull('max_age_id');
                })*/
                ->whereNotIn('id',function($query) {
                    $query->select('ad_id')->from('ad_user')
                        ->where('status', '!=', 'U');
                })
                ->orderBy('cost', 'desc')
                ->orderBy('id', 'asc')
                //->toSql();
                ->paginate(10);
        }
        catch (\Exception $e) {
            return $this->sendError('Not Found!', $e->getMessage(), 400);
        }

        return $this->sendResponse(new AdCollection($ads), 'Ads fetched.');
    }

    private function getUserLocation($userId, $latitude, $longitude)
    {
        if (UserLocation::where('user_id', $userId)->exists()) {
            $userLocation = UserLocation::where('user_id', $userId)->orderBy('id', 'desc')->first();
            if (Carbon::parse($userLocation->created_at)->addMinutes(30)->gte(now())) {
                $userGeo['province_id'] = $userLocation->province_id;
                $userGeo['city_id'] = $userLocation->city_id;
                $userGeo['district_id'] = $userLocation->district_id;
            }
            else
            {
                $userGeo = $this->reverseGps($latitude, $longitude);
                UserLocation::create([
                    'user_id' => $userId,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'province_id' => $userGeo['province_id'],
                    'city_id' => $userGeo['city_id'],
                    'district_id' => $userGeo['district_id'],
                ]);
            }
        }
        else
        {
            $userGeo = $this->reverseGps($latitude, $longitude);
            UserLocation::create([
                'user_id' => $userId,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'province_id' => $userGeo['province_id'],
                'city_id' => $userGeo['city_id'],
                'district_id' => $userGeo['district_id'],
            ]);
        }

        return $userGeo;
    }

    private function reverseGps($latitude, $longitude)
    {
        //$neshanToken = "service.ke7PhuGY1PyrlxuczC9g3cF4ZejscapJIyE7cUP6";
        $url = "https://api.neshan.org/v5/reverse?lat=".$latitude."&lng=".$longitude;

        $client = new Client();
        $headers = [
            'Api-Key' => config('services.neshan.api_key')
        ];
        $request = new GuzzleRequest('GET', $url, $headers);
        $res = $client->sendAsync($request)->wait();
        $response = $res->getBody();
        $responseArr = json_decode($response);

        $provine_id = Province::whereName(str_replace("استان ", "", $responseArr->state))->pluck('id')->first();
        $city_id = City::where('province_id', $provine_id)->whereName($responseArr->city)->pluck('id')->first();
        $district_id = District::where('city_id', $city_id)->whereName($responseArr->neighbourhood)->pluck('id')->first();

        $userGeo['province_id'] = $provine_id;
        $userGeo['city_id'] = $city_id;
        $userGeo['district_id'] = $district_id;

        return $userGeo;
    }

    /*private function uploadmedia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media' => [
                'required',
                function ($attribute, $value, $fail) {
                    $is_image = Validator::make(
                        ['upload' => $value],
                        ['upload' => 'image']
                    )->passes();

                    $is_video = Validator::make(
                        ['upload' => $value],
                        ['upload' => 'mimes:mp4,ogx,oga,ogv,ogg,webm']
                    )->passes();

                    if (!$is_video && !$is_image) {
                        $fail(':attribute must be image or video.');
                    }

                    if ($is_video) {
                        $validator = Validator::make(
                            ['video' => $value],
                            ['video' => "max:1048576"]
                        );
                        if ($validator->fails()) {
                            $fail(":attribute must be 1 gigabytes or less.");
                        }
                    }

                    if ($is_image) {
                        $validator = Validator::make(
                            ['image' => $value],
                            ['image' => "max:5120"]
                        );
                        if ($validator->fails()) {
                            $fail(":attribute must be 5 megabyte or less.");
                        }
                    }
                },
            ],
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());
        }
    }*/


    /**
     * Create Ad.
     *
     * Create an ad with multiple filters.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|between:10,1000',
            'file' => [
                'required', 'file',
                function ($attribute, $value, $fail) {
                    $is_image = Validator::make(
                        ['upload' => $value],
                        ['upload' => 'image']
                    )->passes();

                    $is_video = Validator::make(
                        ['upload' => $value],
                        ['upload' => 'mimes:mp4,ogg,qt']
                    )->passes();

                    if (!$is_video && !$is_image) {
                        $fail(':attribute must be image or video.');
                    }

                    if ($is_video) {
                        $validator = Validator::make(
                            ['video' => $value],
                            ['video' => "max:102400"]
                        );
                        if ($validator->fails()) {
                            $fail(":attribute must be 100 megabyte or less.");
                        }
                    }

                    if ($is_image) {
                        $validator = Validator::make(
                            ['image' => $value],
                            ['image' => "max:10240"]
                        );
                        if ($validator->fails()) {
                            $fail(":attribute must be 10 megabyte or less.");
                        }
                    }
                },
            ],
            'circulation' => 'required|integer|min:100',
            'cost' => 'required|integer|min:10000',
            'min_age' => 'nullable|integer|between:1,19',
            'max_age' => 'nullable|integer|between:1,19',
            /**
             * Format: {"provinces":[],"cities":[],"districts":[]}
             */
            'locations' => 'required|json',
            /**
             * Format: Y-m-d
             */
            'start_date' => 'nullable|date_format:"Y-m-d"',
            /**
             * Format: Y-m-d
             */
            'end_date' => 'nullable|date_format:"Y-m-d"'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());
        }

        $commission = Setting::where('key', 'commission')->value('value');
        $vat = Setting::where('key', 'vat')->value('value');


        $ad_data['uuid'] = Uuid::uuid4()->toString();
        $ad_data['title'] = $request->title;
        $ad_data['description'] = $request->description;
        $file = $request->file('file');
        $ad_data['circulation'] = $request->circulation;
        $ad_data['commission'] = intval($commission);
        $ad_data['cost'] = $request->cost;
        $ad_data['gender'] = $request->gender;
        $ad_data['operator_id'] = $request->operator_id;
        $ad_data['min_age_id'] = $request->min_age;
        $ad_data['max_age_id'] = $request->max_age;
        $ad_data['status_id'] = 1;
        if($request->start_date == null)
        {
            $ad_data['start_date'] = Carbon::now()->format('Y-m-d');
        }
        else
        {
            $ad_data['start_date'] = $request->start_date;
        }
        if($request->end_date == null)
        {
            $ad_data['end_date'] = Carbon::now()->addDay(30)->format('Y-m-d');
        }
        else
        {
            $ad_data['end_date'] = $request->end_date;
        }

        $mime = $file->getMimeType();

        if ($mime == "video/mp4" or $mime == "video/ogg" or $mime == "video/quicktime")
        {
            $ad_data['file_type'] = "V";
            $result = $this->uploadVideo($file);
            if($result['success'] == true)
            {
                $ad_data['file'] = $result['message'];
            }
            else
            {
                return $this->sendError('Upload problem', $result['message']);
            }
        }
        else
        {
            $ad_data['file_type'] = "P";
            $result = $this->uploadImage($file);
            if($result['success'] == true)
            {
                $ad_data['file'] = $result['message'];
            }
            else
            {
                return $this->sendError('Upload problem', $result['message']);
            }
        }

        $user = Auth::user();
        $totalPrice = $request->circulation * $request->cost;
        $totalPrice = $totalPrice + (intval($commission) * $totalPrice / 100);
        $totalPrice = $totalPrice + ($totalPrice * intval($vat) / 100);

        if ($user->credit < $totalPrice)
        {
            return $this->sendError('Insufficient Credit', 'Insufficient Credit');
        }

        try{
            $ad = auth()->user()->ads()->create($ad_data);
            $adId = $ad->id;
            $this->ad_locations($adId, $request->locations);
            $user->decrement('credit', $totalPrice);

            $user->transactions()->create([
                'amount' => $totalPrice*(-1),
                'description' => 'درج آگهی'
            ]);

            return $this->sendResponse($request->all(), "Ad data has been sent");
        }
        catch(QueryException $exception)
        {
            return $this->sendError('Unknown Error!', $exception->getCode());
        }
    }

    private function uploadVideo($file)
    {
        $user = Auth::user();
        $userId = $user->id;
        $path = '/media/ads/'.$userId.'/video/';
        $uuid = Uuid::uuid4()->toString();
        $filename = $uuid.".mp4";
        $fullPath = $path.$filename;
        try {
            FFMpeg::open($file)
                ->export()
                ->inFormat(new \FFMpeg\Format\Video\X264)
                ->resize(1080, 1350, 'inset')
                ->toDisk('public')
                ->save($fullPath);
        } catch (EncodingException $exception) {
            $command = $exception->getCommand();
            $errorLog = $exception->getErrorOutput();

            $result = ['success' => false, 'message' => $errorLog];
            return $result;
        }

        $result = ['success' => true, 'message' => $filename];
        return $result;
    }

    private function uploadImage($file)
    {
        $user = Auth::user();
        $userId = $user->id;
        $path = '/media/ads/'.$userId.'/image/';
        $uuid = Uuid::uuid4()->toString();
        $fileExt = strtolower($file->getClientOriginalExtension());
        $filename = $uuid.".".$fileExt;
        $fullPath = $path.$filename;
        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }
        try {
            $image = ImageManager::gd()->read($file)
                ->cover(1080, 1350)->encode(new AutoEncoder(quality: 85));
            Storage::disk('public')->put($fullPath, (string) $image);
        }
        catch (\Exception $e) {
            $result = ['success' => false, 'message' => $e->getMessage()];
            return $result;
        }
        $result = ['success' => true, 'message' => $filename];
        return $result;
    }

    private function ad_locations($adId, $locations)
    {
        $locationsArr = json_decode($locations);
        if(isset($locationsArr->provinces)) {
            $provinces = $locationsArr->provinces;
            $provincesCount = count($provinces);
            if($provincesCount == 1) {
                $provinceId = $locationsArr->provinces[0];
                $cities = $locationsArr->cities;
                $citiesCount = count($cities);
                if ($citiesCount == 1) {
                    $cityId = $locationsArr->cities[0];
                    $districts = $locationsArr->districts;
                    $districtsCount = count($districts);
                    if ($districtsCount > 0) {
                        foreach ($districts as $district) {
                            AdLocation::create([
                                'ad_id' => $adId,
                                'province_id' => $provinceId,
                                'city_id' => $cityId,
                                'district_id' => $district
                            ]);
                        }
                    }
                    else {
                        foreach ($cities as $city) {
                            AdLocation::create([
                                'ad_id' => $adId,
                                'province_id' => $provinceId,
                                'city_id' => $city
                            ]);
                        }
                    }
                }
                elseif ($citiesCount > 1) {
                    foreach ($cities as $city) {
                        AdLocation::create([
                            'ad_id' => $adId,
                            'province_id' => $provinceId,
                            'city_id' => $city
                        ]);
                    }
                }
                else {
                    AdLocation::create([
                        'ad_id' => $adId,
                        'province_id' => $provinceId
                    ]);
                }

            }
            elseif ($provincesCount > 1) {
                foreach ($provinces as $province) {
                    AdLocation::create([
                        'ad_id' => $adId,
                        'province_id' => $province,
                    ]);
                }
            }
            else {
                AdLocation::create([
                    'ad_id' => $adId
                ]);
            }
        }
        else {
            AdLocation::create([
                'ad_id' => $adId
            ]);
        }
    }

    /*public function bookmark(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());
        }

        $user = Auth::user();
        $uuid = $request->uuid;

        $ad = Ad::where('uuid', $uuid)->firstOrFail();

        if(!$ad) {
            return $this->sendError('Not Found!', "");
        }

        $user->bookmarks()->create([
            'ad_id' => $ad->id
        ]);

        return $this->sendResponse('Bookmarked', 'The ad has been bookmarked!');
    }*/
}
