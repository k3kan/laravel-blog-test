<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate();

        return view('article.index', compact('articles'));
    }

    public function create()
    {
        $article = new Article();
        return view('article.create', compact('article'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $article = new Article();
        $article->fill($data);
        $article->save();

        $request->session()->flash('create', 'Article was created!');

        return redirect()->route('articles.index');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $this->validate($request, [
            'name' => 'required|unique:articles,name,' . $article->id,
            'body' => 'required|min:1',
        ]);

        $article->fill($data);
        $article->save();

        $request->session()->flash('update', 'Task was successful!');

        return redirect()->route('articles.index');
    }
}
