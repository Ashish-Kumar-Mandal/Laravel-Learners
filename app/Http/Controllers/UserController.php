<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken(uniqid('Learners_', true))->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response([
                'message' => 'User Not Found :)'
            ]);
        }else{
            if(!Hash::check($request->password, $user->password)){
                return response([
                    'message' => 'Password Not Matched :)'
                ]);
            }else{
                $token = $user->createToken(uniqid('Learners_', true))->plainTextToken;
                return response([
                    'user' => $user,
                    'message' => 'Loged in Successfully :)',
                    'token' => $token
                ], 201);
            }
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Successfully Logout :)'
        ]);
    }
}
