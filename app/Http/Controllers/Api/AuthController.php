<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

use App\Http\Controllers\Api\BaseController as ApiBaseController;

class AuthController extends ApiBaseController
{
    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            // 'device_name'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Unauthorized.', $validator->errors(), 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $token = $request->device_name ?? 'edustore_token';
            $success['token'] =  $authUser->createToken($token)->plainTextToken;
            $success['user'] =  $authUser;

            return $this->sendSuccess('User signed in', $success);
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorized. The user needs to be authenticated.'], 401);
        }
    }

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'first_name' => 'nullable|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            // 'device_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->assignRole('student');
        $token = $request->device_name ?? 'edustore_token';
        $success['token'] = $user->createToken($token)->plainTextToken;
        $success['user'] = $user;

        return $this->sendSuccess('User created successfully.', $success);
    }

    public function signOut(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $success['user'] = $user->only('id', 'full_name', 'email');
        return $this->sendSuccess('User signed out', $success);
    }


    public function profile(Request $request)
    {
        $user = $request->user();
        if (!is_null($user)) {
            return $this->sendSuccess('Own profile data', ['user' => $user]);
        }
        return $this->sendError('User not found');
    }
}
