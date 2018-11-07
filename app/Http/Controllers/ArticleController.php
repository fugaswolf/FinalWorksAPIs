<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get articles
        $articles = Article::paginate(15);
    
        //Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($title, $author, $department)
    {
        $article = new Article($title, $author, $department);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
            $article = (new Article)->fill([
            'title'      => $request->input('title'),
            'author'     => $request->input('author'),
            'department' => $request->input('department')
        ]);
        
        $article->save();

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get article
        $article = Article::findorFail($id);

        // Return single article as a resource
        return new ArticleResource($article);
    }

    public function showByTitle($title)
    {
        // Get article
        $article = Article::where('title', '=', $title)->firstOrFail(); // vervangen door ->first();

        // en dan hier bijv. if (! isset($article)) { return 'Not found'; } // of iets dergelijks

        // Return single article as a resource
        return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //dump($request->all());
        $article = Article::findOrFail($id);

        $article->update([
            'title'      => $request->input('title'),
            'author'     => $request->input('author'),
            'department' => $request->input('department')
        ]);

        return new ArticleResource($article);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['message' => Article::findorFail($id)->delete() ? 'Success.' : 'Failed.']);
    }
}
