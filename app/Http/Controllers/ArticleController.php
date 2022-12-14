<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use PhpParser\Node\Arg;

class ArticleController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(5);

        return response()->json(new ArticleCollection($articles) , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateArticle($request);

        Article::create([
            'user_id' => auth('api')->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $this->uploadImage($request)
        ]);

        return response()->json([
            'message' => 'Created'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return response()->json([
            'data' => new ArticleResource($article)
        ] , 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $article->update($request->all());

        return response()->json([
            'message' => 'updated '
        ] , 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Article::findOrFail($id)->delete();

        return response()->json([
            'message' => 'deleted '
        ] , 200);
    }

    private function validateArticle($request)
    {
        $request->validate([
            'title'=> ['required'],
            'image'=> ['required'],
        ]);
    }

    private function uploadImage($request)
    {
        return $request->hasFile('image')
        ? $request->image->store('public')
        : null;
    }
}
