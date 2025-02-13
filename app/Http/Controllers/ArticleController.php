<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\User;
use App\Models\Article;
use App\Policies\ArticlePolicy;
use App\Rules\MaxWords;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{



    public function geDoctorArticles(Request $request){

        $d_id = $request->user('sanctum')->id;
        $articles = Article::with('doctor')->where("user_id" , $d_id)->paginate(50);
        return ArticleResource::collection($articles);
    }

    public function getUserArticles(Request $request){
        $user_id = $request->user('sanctum')->id;
        $doctors_id = User::find($user_id)->paientDoctors()->get()->pluck('id')->toArray();
        // dd($doctors_id);
        $articles = Article::with('doctor')->whereIn("user_id"  ,  $doctors_id)->paginate(50);
        return ArticleResource::collection($articles);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Article::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    {

        if(!$request->user('sanctum')->is_doctor){
            return response()->json([
                "message" => "You can not add Article"
            ],403);
        }

        $request->validate([
            'title'=> 'required',
            "subject" => ['required' , new MaxWords(250)],
            "img"=>['extensions:jpeg,png,jpg,gif' , File::image()->max(5 * 1024)]
        ]
    );

        $id = $request->user('sanctum')->id;
        $doctor = User::where('id' , $id)->first();


        $imageUrl=null;

        if($request->hasFile('img')){
            $image = $request->file('img');
            $imageName = "article_". Str::random(10) ."_". time() .'.'. $image->extension();
            $path = $image->storePubliclyAs('article', $imageName, 'public');

            $imageUrl = Storage::url($path);

        }

        $article =  $doctor->articles()->create(array_merge(
                                                        $request->only('title' , 'subject') ,
                                                         [ "img"=>$imageUrl]
                                                                ));

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $article = Article::findOrFail($id);

        if($request->user('sanctum')->id !== $article->user_id){
            return response()->json([
                "message" => "You can not modify this Article"
            ],403);
        }

        $request->validate([
            'title'=> 'required',
            "subject" => ['required' , new MaxWords(250)],
            "img"=>['extensions:jpeg,png,jpg,gif' , File::image()->max(5 * 1024)]
        ]);





        $imageUrl=null;

        if($request->hasFile('img')){
            $image = $request->file('img');
            $imageName = "article_". Str::random(10) ."_". time() .'.'. $image->extension();
            $path = $image->storePubliclyAs('article', $imageName, 'public');

            $imageUrl = Storage::url($path);

        }

        $updated = $article->update([
            'title' => $request->title,
            'subject' => $request->subject,
            'img' => $imageUrl?$imageUrl:$article->img
        ]);

        return response()->json("updated successfully");
    }


    public function updateImg(Request $request , $id){

        $request->validate([
            "img"=>[ 'required' , 'extensions:jpeg,png,jpg,gif' , File::image()->max(5 * 1024)]
        ]);
        $article = Article::findOrFail($id);

        if($request->user('sanctum')->id !== $article->user_id){
            return response()->json([
                "message" => "You can not modify this Article"
            ],403);
        }

        $imageUrl=null;

        if($request->hasFile('img')){
            $image = $request->file('img');
            $imageName = "article_". Str::random(10) ."_". time() .'.'. $image->extension();
            $path = $image->storePubliclyAs('article', $imageName, 'public');

            $imageUrl = Storage::url($path);

        }

        $updated = $article->update([
            'img' => $imageUrl?$imageUrl:$article->img
        ]);

        return response()->json("Image updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , $id)
    {

        $article = Article::findOrFail($id);

        if($request->user('sanctum')->id !== $article->user_id){
            return response()->json([
                "message" => "You can not modify this Article"
            ],403);
        }

        $deleted = $article->delete();
        return response()->json($deleted?"Deleted successfully":"failed delete");

    }


    public function likeArticle(Request $request , $id){

        $article = Article::find($id);
        $user_id = $request->user('sanctum')->id;
        // dd($user_id);
        $saved = $article->toggleArticleLike($user_id);
        return $saved;

    }


    public function saveArticle(Request $request , $id){

        $article = Article::find($id);
        $user_id = $request->user('sanctum')->id;

        $saved = $article->toggleArticleSave($user_id);
        return $saved;

    }


    public function getSavedArticles(Request $request){
        $user_id = $request->user('sanctum')->id;
        $articles = User::find($user_id)->savedArticles()->paginate(50);

       return ArticleResource::collection($articles);
    }



}
