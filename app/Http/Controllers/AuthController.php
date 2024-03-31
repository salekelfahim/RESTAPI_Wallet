<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|string|max:255',
        ]);

        try {
            $user = User::create([
                'fistname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $user_id = $user->id;

            Wallet::create ([
                'id' => Str::uuid(), 
                'type' => $request->input('type'),
                'user_id' => $user_id,
            ]);

            return response()->json([
                'message' => 'Account Created Successfully',
                'data'=>$user,
                'token' => $user->createToken("API Token")->plainTextToken,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'message' => 'Wrong Email or Password',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'wallets' => $user->wallets
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

}
