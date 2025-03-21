<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;
use App\Rules\MaxWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{

    public function getArticleComments(Request $reqest , $id){

        $comments = Article::find($id)->comments()->with("user")->get();

        return response()->json(CommentResource::collection($comments));

    }

    public function store(Request $request , $id){

        $request->validate([
            "comment"=> ["required" , new MaxWords(50)],
        ]);

        $user_id = $request->user("sanctum")->id;

        $created= User::find($user_id)->comments()->create([
            "comment" => $request->comment,
            "article_id" => intval($id)
        ]);

        $article = Article::with('doctor')->find($id);
        Notification::send($article->doctor , new NewCommentNotification($request->user("sanctum")->name , $article->title));

        return new CommentResource($created);
    }

    public function destroy(Request $reqest , $id){
        $user_id = $reqest->user('sanctum')->id;

        $deleted = Comment::where('user_id' , $user_id)->where("id" , $id)->delete();
        return response()->json($deleted?"deleted successfully":"failed delete");
    }

}
