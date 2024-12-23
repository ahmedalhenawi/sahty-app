<?php

namespace App\Http\Controllers\Doctor;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Rules\MaxWords;

class DoctorController extends Controller
{
    public function my(Request $request) {

        $d_id = $request->user('sanctum')->id;
        $doctor = User::whereId($d_id)->with("specialty")->get();
        return $doctor;
    }

    // public function articles(Request $request){
    //     $d_id = $request->user('sanctum')->id;
    //     $articles = Article::where("user_id" , $d_id)->get();
    //     return $articles;
    // }



    public function updateBio(Request $request){
        $d_id = $request->user('sanctum')->id;
        $request->validate([
            'bio' => ['required' , new MaxWords(25)]
        ]);

        $updated = User::where("id" ,$d_id)->update(["bio"=>$request['bio']]);


        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Bio updated successfully.',
                'data' => [
                    'user_id' => $d_id,
                    'bio' => $request['bio']
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update bio.',
            ], 500);
        }
    }
}
