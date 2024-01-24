<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return $this->eResponse($validator->errors()->first(), 401);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        if ($user) {
            $token = $user->createToken('myWeb')->accessToken;
        } else {
            return $this->eResponse('cant create the user', 400);
        }
        return $this->sResponse([
            'user' => $user,
            'token' => $token
        ], 'success', 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);
        if ($validator->fails()) {
            return $this->eResponse($validator->errors(), 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->eResponse('UnRegistered', 200);
        } else if (!Hash::check($request->password, $user->password)) {
            return $this->eResponse('password is incorrect', 400);
        }
        $token = $user->createToken('myWeb')->accessToken;
        return $this->sResponse(['token' => $token], 'successfuly loged in', 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return $this->sResponse($user, 'log out done', 200);
    }
}
