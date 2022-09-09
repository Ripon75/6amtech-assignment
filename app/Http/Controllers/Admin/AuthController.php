<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Utility\CommonUtils;
use App\Models\User;
use Auth;

class Authcontroller extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'              => ['required', 'unique:users,username'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'phone_number'          => ['required', 'unique:users,phone_number'],
            'password'              => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return CommonUtils::sendError($validator->errors(), __('common.validationErr'), null);
        }

        $username    = $request->input('username', null);
        $email       = $request->input('email', null);
        $phoneNumber = $request->input('phone_number', null);
        $roleID      = $request->input('role_id', null);
        $password    = $request->input('password', null);

        $user = new User();

        $user->username     = $username;
        $user->email        = $email;
        $user->phone_number = $phoneNumber;
        $user->role_id      = $roleID;
        $user->password     = Hash::make($password);
        $res = $user->save();
        if ($res) {
            $user->syncRoles([$roleID]);
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
            $token = $checkUser->createToken('user-token')->accessToken;
            return CommonUtils::sendResponse($checkUser, __('user.lSuccess'), $token);
        } else {
            return CommonUtils::sendError(null, __('user.lFailed'), null);
        }
    }

    public function userDetail(Request $request)
    {
        if (!$request->user()->isAbleTo('products-delete')) {
            return CommonUtils::sendError(null, __('No permission'));
        }

        $user = Auth::user();

        if ($user) {
            return CommonUtils::sendResponse($user, __('Auth user detail information'));
        }
    }
}
