<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function doctors(){
        $doctors = User::query()->where("is_doctor" , true)->paginate(10);
        return response()->json($doctors);
    }

    public function paients(){
        $paients = User::query()->where("is_doctor" , false)->paginate(10);
        return response()->json($paients);
    }

    public function doctorPaients(Request $request){

        $paients = $request->user()->doctorPaients()->paginate(10);
        return response()->json($paients);
    }

    public function paientDoctors(Request $request){

        $doctors = $request->user()->paientDoctors()->paginate(10);
        return response()->json($doctors);
    }



}
