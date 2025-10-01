<?php

namespace App\Http\Controllers\Api\v1;

use App\Enum\gender;
use App\Http\Controllers\Api\v1\BaseController as BaseController;
use App\Http\Resources\v1\AdResource;
use App\Http\Resources\v1\UserResource;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    /**
     * Show User.
     *
     * Show the User.
     */
    public function show()
    {
        try {
            $user = Auth::user();
            return $this->sendResponse(new UserResource($user), 'User fetched.');
        }
        catch(ModelNotFoundException $e)
        {
            return $this->sendError('Not Found!', $e->getCode());
        }
    }

    /**
     * Update User.
     *
     * Update user information.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'gender' => ['nullable', Rule::enum(gender::class)],
            'birthday' => 'nullable|date_format:"Y-m-d',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);
        }

        $user = Auth::user();

        try{
            $update = $user->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
            ]);

            return $this->sendResponse($request->all(), "User information has been updated");
        }
        catch(QueryException $exception)
        {
            $message = $exception->getMessage();
            return $this->sendError('Unable to update user profile', $message, 500);
        }
    }
}
