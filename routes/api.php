<?php

use App\Http\Controllers\AdviceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\UserController;
use App\Models\Advice;
use App\Models\Article;
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



Route::apiResource('article' , ArticleController::class)->middleware('auth:sanctum');


Route::prefix('doctor')->group(function () {

    Route::get("my" , [DoctorController::class , 'my']);
    Route::put("update-bio" , [DoctorController::class , 'updateBio']);


    Route::get("articles" , [ArticleController::class , 'geDoctorArticles']);
    Route::post("article/store" , [ArticleController::class , 'store']);
    Route::post('article/{id}/update',[ArticleController::class , 'update']);
    Route::delete("article/delete/{id}" , [ArticleController::class , "destroy"]);


    Route::get('get-today-advice' , [AdviceController::class , 'doctorTodayAdvice']);
    Route::post('advice/store', [AdviceController::class , 'store']);
    Route::post('advice/{id}/update', [AdviceController::class , 'update']);
    Route::delete('advice/{id}/destroy', [AdviceController::class , 'destroy']);

})->middleware('auth:sanctum');


Route::get('articles' , [ArticleController::class , 'getUserArticles']);
Route::get('articles/saved' , [ArticleController::class , 'getSavedArticles']);

Route::get("article/{id}/comments" , [CommentController::class , 'getArticleComments']);
Route::post("article/{id}/comment/store" , [CommentController::class , 'store']);
Route::delete("comment/{id}/destroy" , [CommentController::class , 'destroy']);

Route::post('article/{id}/save' , [ArticleController::class , 'saveArticle']);
Route::post('article/{id}/like' , [ArticleController::class , 'likeArticle']);



Route::prefix('user')->group(function () {

Route::get('get-today-advices' , [AdviceController::class , 'todayAdvice']);

})->middleware('auth:sanctum');
