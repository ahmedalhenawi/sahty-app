<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\NewFollowerNotifiacation;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function doctors(){
        $doctors = User::query()->where("is_doctor" , true)->with('specialty')->paginate(10);
        return response()->json($doctors);
    }

    public function paients(){
        $paients = User::query()->where("is_doctor" , false)->paginate(10);
        return response()->json($paients);
    }

    public function doctorPaients(Request $request){

        $paients = $request->user("sanctum")->doctorPaients()->paginate(10);

        return response()->json(UserResource::collection($paients));
    }

    public function paientDoctors(Request $request){

        $doctors = $request->user('sanctum')->paientDoctors()->paginate(10);
        return response()->json(DoctorResource::collection($doctors));
    }


    public function followDoctor(Request $request, $id)
    {
        $doctor = User::whereId($id)->where('is_doctor' , true)->first();

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $following = $request->user('sanctum')->toggleFollowDoctor($id);

        if($following){
            $doctor->notify(new NewFollowerNotifiacation($request->user('sanctum')->name));
        }

        return response()->json([
            'message' => $following ? 'Doctor followed successfully' : 'Doctor unfollowed successfully',
            'following' => $following, // Indicate whether the user is now following the doctor
        ]);
    }

}
