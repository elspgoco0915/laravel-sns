<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Tag;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }



    //
    public function index()
    {
        // ダミーデータ
        // $articles = [
        //     (object) [
        //         'id' => 1,
        //         'title' => 'タイトル1',
        //         'body' => '本文1',
        //         'created_at' => now(),
        //         'user' => (object) [
        //             'id' => 1,
        //             'name' => 'ユーザー名1',
        //         ],
        //     ],
        //     (object) [
        //         'id' => 2,
        //         'title' => 'タイトル2',
        //         'body' => '本文2',
        //         'created_at' => now(),
        //         'user' => (object) [
        //             'id' => 2,
        //             'name' => 'ユーザー名2',
        //         ],
        //     ],
        //     (object) [
        //         'id' => 3,
        //         'title' => 'タイトル3',
        //         'body' => '本文3',
        //         'created_at' => now(),
        //         'user' => (object) [
        //             'id' => 3,
        //             'name' => 'ユーザー名3',
        //         ],
        //     ],
        // ];


        $articles = Article::all()->sortByDesc('created_at');

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $allTagNames = Tag::all()->map(function ($tag){
            return ['text' => $tag->name];
        });


        return view('articles.create', [
            'allTagNames' => $allTagNames,
        ]);
        // return view('articles.create');
    }

    public function store(ArticleRequest $request, Article $article)
    {
        // $article = new Artcile();

        // $article->title = $request->title;
        // $article->body = $request->body;

        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();

        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        $tagNames = $article->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        // return view('articles.edit', ['article' => $article]);
        return view('articles.edit', [
            'article'  => $article,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();

        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }    

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    public function like(Request $request, Article $article)
    {
        // 一度削除ししてから登録する
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id'            => $article->id,
            'countLikes'    => $article->count_likes,
        ];
        
    }

}
