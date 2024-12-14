<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }


    public function login(LoginRequest $request)
{


       $request->authenticate();


        $user = User::where('email' , $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'You have been logged out successfully.',
        ], 200);

    }

    public function forgetPassword(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);


        Password::sendResetLink(['email'=>$request['email']]);


        // $user = User::query()->where('email' , $request['email'])->first();
        // $token = $user->createToken(name:'auth_token' , abilities:["*"], expiresAt: now()->addHours(3))->plainTextToken;



        // Mail::to("ahmed@gmail.com")->send(new ResetPasswordMail($user , $token));

        // return response()->json([
        //     'message' => 'A password reset link has been sent to your email.',
        //     'email' => $user->email,
        //     'token_expiration' => now()->addHours(3)->toDateTimeString(),
        // ], 200);


    }

    public function ViewResetPassword(Request $request){

        $request->validate([
            'token' => 'required'
        ]);

        $personalAccessToken = PersonalAccessToken::findToken($request['token']);
        $user = $personalAccessToken->tokenable;
        dd($user->name);

    }




    public function resetPassword(Request $request)
{
    $request->validate([
        'token' => "required",
        'password' => 'required|confirmed|min:6',
    ]);

    $personalAccessToken = PersonalAccessToken::findToken($request['token']);

    if (!$personalAccessToken) {
        return response()->json([
            'error' => 'Invalid token.',
        ], 401);
    }

    $user = $personalAccessToken->tokenable;

    if (Hash::check($request['password'], $user->password)) {
        return response()->json([
            'error' => 'The new password cannot be the same as the existing password.',
        ], 422);
    }

    // Update the user's password
    $user->password = $request['password'];
    $user->save();

    return response()->json([
        'message' => 'Your password has been reset successfully.',
    ], 200);
}
}
