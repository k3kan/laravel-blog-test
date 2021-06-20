<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate();

        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new Article();
        return view('article.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $article = new Article();
        $article->fill($data);
        $article->save();

        $request->session()->flash('create', 'Article was created!');

        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $data = $this->validate($request, [
                'name' => 'required|unique:articles,name,' . $article->id,
                'body' => 'required|min:1',
            ]);

        $article->fill($data);
        $article->save();

        $request->session()->flash('update', 'Task was successful!');

        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Article $article)
    {
        $article->delete();

        $request->session()->flash('delete', 'Article delete successful!');
        return redirect()->route('articles.index');
    }
}
