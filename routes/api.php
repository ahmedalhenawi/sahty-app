<?php

use App\Http\Controllers\AdviceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {


    return $request->user();
})->middleware('auth:sanctum');


Route::post("register" , [AuthController::class , "register"]);
Route::get('specialties' , [DoctorController::class , 'specialties']);


Route::post("login" , [AuthController::class , "login"]);

Route::post("logout" , [AuthController::class , "logout"])->middleware("auth:sanctum");

Route::post("forget-password" , [AuthController::class , 'forgetPassword']);

Route::post('check-code' , [AuthController::class , 'checkCode']);
Route::post('reset-password' , [AuthController::class , 'resetPassword'])->middleware(['auth:sanctum']);

Route::post('change-password' , [AuthController::class , 'changePassword'])->middleware(['auth:sanctum']);





// Route::get("doctor_paients" , [UserController::class , 'doctorPaients'])->middleware("auth:sanctum");
Route::get("paient_doctors" , [UserController::class , 'paientDoctors'])->middleware("auth:sanctum");





Route::prefix('doctor')->middleware('auth:sanctum')->group(function () {

    Route::get("my" , [DoctorController::class , 'my']);
//    Route::put("update-bio" , [DoctorController::class , 'updateBio']);
    Route::get("followers" ,  [UserController::class , 'doctorPaients']);
    Route::get("info" ,  [DoctorController::class , 'info']);
    Route::post('update-img' , [DoctorController::class , 'updateImg']);
    Route::post('update-profile' , [DoctorController::class , 'updateProfile']) ; ;

    Route::get('notifications' ,[DoctorController::class , 'notifications']);

    Route::get("articles" , [ArticleController::class , 'geDoctorArticles']);
    Route::post("article/store" , [ArticleController::class , 'store']);
    Route::post('article/{id}/update',[ArticleController::class , 'update']);
    Route::post('article/{id}/update-img',[ArticleController::class , 'updateImg']);
    Route::delete("article/delete/{id}" , [ArticleController::class , "destroy"]);


    Route::get('get-today-advice' , [AdviceController::class , 'doctorTodayAdvice']);
    Route::post('advice/store', [AdviceController::class , 'store']);
    Route::post('advice/{id}/update', [AdviceController::class , 'update']);
    Route::delete('advice/{id}/destroy', [AdviceController::class , 'destroy']);

});



Route::middleware('auth:sanctum')->group(function(){


    Route::get('articles' , [ArticleController::class , 'getUserArticles']);
    Route::get('doctors-articles' , [ArticleController::class , 'getDoctorsArticles']);
    Route::get('articles/saved' , [ArticleController::class , 'getSavedArticles']);

    Route::get("article/{id}/comments" , [CommentController::class , 'getArticleComments']);
    Route::post("article/{id}/comment/store" , [CommentController::class , 'store']);
    Route::delete("comment/{id}/destroy" , [CommentController::class , 'destroy']);

    Route::post('article/{id}/save' , [ArticleController::class , 'saveArticle']);
    Route::post('article/{id}/like' , [ArticleController::class , 'likeArticle']);

    Route::get('speciaty/{specialty}/doctors' , [DoctorController::class , 'specialtyDoctors'])->whereNumber('specialty');

});



Route::prefix('user')->middleware('auth:sanctum')->group(function () {


Route::post('update-img' , [DoctorController::class, 'updateImg']);

Route::post('update-profile' , [DoctorController::class , 'updateProfile']) ; ;

Route::post('follow-doctor/{id}'  , [UserController::class , "followDoctor"]);
Route::get("doctors" , [UserController::class , 'paientDoctors']);

Route::get('get-today-advice' , [AdviceController::class , 'todayAdvice']);

Route::get('notifications' ,[DoctorController::class , 'notifications']);

});
