<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdviceResource;
use App\Models\User;
use App\Models\Advice;
use App\Rules\MaxWords;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    public function todayAdvice(Request $request){
        $id = $request->user('sanctum')->id;
        $followingDoctor = User::where('id' , $id)->first()->paientDoctors()->get();
        $advice = Advice::whereIn('doctor_id' , $followingDoctor->pluck('id')->toArray())->postedToday()->orderBy('created_at', 'desc')->paginate(50);
        return AdviceResource::collection($advice);

    }

    public function doctorTodayAdvice(Request $request){
        $d_id = $request->user('sanctum')->id;
        $advice = Advice::where('doctor_id' , $d_id)->postedToday()->orderBy('created_at', 'desc')->paginate(50);
        return AdviceResource::collection($advice);
    }

    public function store(Request $request){

        if(!$request->user('sanctum')->is_doctor){
            return response()->json([
                "message" => "You can not add Article"
            ],403);
        }

        $request->validate([
            'advice'=> ['required' , new MaxWords(50)]
        ]);

        $id = $request->user('sanctum')->id;
        $doctor = User::find($id);
        $advice = $doctor->advice()->create(['advice'=>$request['advice']]);
        return new AdviceResource($advice);
    }

    public function update(Request $request , $id){


        $advice = Advice::findOrFail($id);
        if($request->user('sanctum')->id !== $advice->doctor_id){
            return response()->json([
                "message" => "You can not modify this Article"
            ],403);
        }

        $request->validate([
            'advice' =>'required',
        ]);

        $advice = Advice::find($id);
        $advice->update([
            "advice" => $request->advice
        ]);


        return new AdviceResource($advice);


    }

    public function destroy(Request $request , $id){

        $advice = Advice::findOrFail($id);
        if($request->user('sanctum')->id !== $advice->doctor_id){
            return response()->json([
                "message" => "You can not modify this Article"
            ],403);
        }

        $deleted = $advice->delete();

        return response()->json($deleted?"Deleted successfully":"failed delete");


    }

}
