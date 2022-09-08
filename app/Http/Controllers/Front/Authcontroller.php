<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Utility\CommonUtils;
use App\Models\User;

class Authcontroller extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'              => ['required', 'unique:users,username'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'phone_number'          => ['required', 'unique:users,phone_number'],
            'password'              => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
            'user_type'             => ['required']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return CommonUtils::sendError($validator->errors(), __('common.validationErr'), null);
        }

        $username    = $request->input('username', null);
        $email       = $request->input('email', null);
        $phoneNumber = $request->input('phone_number', null);
        $userType    = $request->input('user_type', null);
        $password    = $request->input('password', null);

        $user = new User();

        $user->username     = $username;
        $user->email        = $email;
        $user->phone_number = $phoneNumber;
        $user->user_type    = $userType;
        $user->password     = Hash::make($password);
        $res = $user->save();
        if ($res) {
            return CommonUtils::sendResponse($user, __('user.rSuccess'), null);
        } else {
            return CommonUtils::sendError(null, __('user.rFailed'), null);
        }
    }

   public function login(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'email'    => ['required'],
            'password' => ['required'],
       ],
        [
            'email.required' => 'please enter username or email or phone number'
        ]
    );

        if ($validator->stopOnFirstFailure()->fails()) {
            return CommonUtils::sendError($validator->errors(), __('common.validationErr'), null);
        }

        $email    = $request->input('email', null);
        $password = $request->input('password', null);

        $checkUser = User::where('email', $email)->orWhere('username', $email)
        ->orWhere('phone_number', $email)->first();

        if($checkUser && Hash::check($password, $checkUser->password)) {
            $token = $checkUser->createToken($checkUser->username, ['user_type:'.$checkUser->user_type])->accessToken;
            return CommonUtils::sendResponse($checkUser, __('user.lSuccess'), $token);
        } else {
            return CommonUtils::sendError(null, __('user.lFailed'), null);
        }
    }
}
