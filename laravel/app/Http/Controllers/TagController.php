<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function show(string $name)
    {
        $tag = Tag::where('name', $name)->first();

        if (empty($tag)) {
            // TODO: tagがなかったら
            dump($tags);
            exit;
        }

        return view('tags.show', ['tag' => $tag]);
    }

}
