<?php

namespace App\Http\Controllers\Doctor;

use App\Models\User;
use App\Models\Article;
use App\Rules\MaxWords;
use App\Models\Specialty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SpecialtyResource;


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


    public function UpdateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'img' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // 5MB
            'bio' => [Rule::requiredIf(fn () => $request->user()->is_doctor), new MaxWords(50)],
            'jop_specialty_number' => [Rule::requiredIf(fn () => $request->user()->is_doctor), 'string', 'max:6'],
        ]);

        // Handle image upload if present
        if ($request->hasFile('img')) {

            $imageName = "user_". Str::random(10) ."_". time() .'.'. $request->file('img')->extension();

            $imagePath = $request->file('img')->storePubliclyAs('users'  , $imageName , 'public' );
            $validated['img'] = $imagePath;
        }

        // Update the user profile
        $updated = $request->user()->update($validated);

        // Return appropriate response
        if ($updated) {
            return response()->json([
                'message' => 'Profile updated successfully!',
                'user' => $request->user()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed to update profile.',
            ], 500);
        }
    }
}
