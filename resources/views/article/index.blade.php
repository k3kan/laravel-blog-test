@extends('layouts.app')
<h1>{{Session::get('create')}}</h1>
<h1>{{Session::get('update')}}</h1>
<h1>{{Session::get('delete')}}</h1>

@section('content')
    <h1>Список статей</h1>
    @foreach ($articles as $article)
        <h2>
            {{$article->name}}
            <a href="{{ route('articles.destroy', $article) }}"
               data-method="delete"
               rel="nofollow"
               data-confirm="Вы уверены?">Удалить</a>
        </h2>
        <div>{{Str::limit($article->body, 200)}}</div>
    @endforeach
@endsection
