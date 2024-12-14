<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {

    // $request->user()->sendEmailVerificationNotification();

    return $request->user();
})->middleware('auth:sanctum');


Route::post("register" , [AuthController::class , "register"]);
Route::post("login" , [AuthController::class , "login"]);

Route::post("logout" , [AuthController::class , "logout"])->middleware("auth:sanctum");

Route::post("forget-password" , [AuthController::class , 'forgetPassword']);

Route::post('reset-password' , [AuthController::class , 'resetPassword'])->name("reset.password");


Route::get('/reset-password/{token}', function (string $token) {
    return response()->json( ['token' => $token]);
})->middleware('guest')->name('password.reset');





Route::get("doctor_paients" , [UserController::class , 'doctorPaients'])->middleware("auth:sanctum");
Route::get("paient_doctors" , [UserController::class , 'paientDoctors'])->middleware("auth:sanctum");
