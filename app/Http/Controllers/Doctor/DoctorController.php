<?php

namespace App\Http\Controllers\Doctor;

use App\Models\User;
use App\Models\Article;
use App\Rules\MaxWords;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;


class DoctorController extends Controller
{

    public function my(Request $request) {

        $d_id = $request->user('sanctum')->id;
        $doctor = User::whereId($d_id)->where("is_doctor" , true)->with("specialty")->first();

        if ($doctor) {
            return response()->json(['doctor' => $doctor]);
        } else {
            return response()->json(['message' => 'Doctor not found'], 404);
        }
    }



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

    public function updateImg(Request $request){

        $request->validate([
                 "img"=> ['required', 'extensions:jpeg,png,jpg,gif' , File::image()->max(5 * 1024)]
        ]);


        $image = $request->file('img');
        $imageName = "user_". Str::random(10) ."_". time() .'.'. $image->extension();
        $path = $image->storePubliclyAs('users', $imageName, 'public');

        $imageUrl = Storage::url($path);
        $request->user('sanctum')->img = $imageUrl;
        $request->user('sanctum')->save();
        return response()->json([
            "message" => "Profile image uploaded Successfully" ,
            "image_url" => $imageUrl
        ]);
    }

    public function specialties(Request $request){
        $specialtes = Specialty::get();
        return SpecialtyResource::collection($specialtes);
    }

    public function info(Request $request)
    {
        $doctor_id = $request->user('sanctum')->id;

        $doctor = User::where('id', $doctor_id)
                      ->where('is_doctor', true)
                      ->first();

        if (!$doctor) {
            return response()->json([
                'message' => 'الطبيب غير موجود.',
            ], 404); // 404 Not Found
        }

        $numberOfFollowers = $doctor->doctorPaients()->count();
        $numberOfArticles = $doctor->articles()->count();
        $numberOfAdvice = $doctor->advice()->count();

        return response()->json([
            'doctor_name' => $doctor->name,
            'doctor_img' => $doctor->img,
            'number_of_followers' => $numberOfFollowers,
            'number_of_articles' => $numberOfArticles,
            'number_of_advice' => $numberOfAdvice,
        ], 200); // 200 OK
    }
}
