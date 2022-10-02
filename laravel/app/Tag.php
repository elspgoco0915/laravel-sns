<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{

    protected $fillable = [
        'name',
    ];

    // アクセサ = 呼び出すときは $tag->hashtagで呼べる
    // getとAttributeの部分は除く
    // 残った部分をスネークケースにする(全て小文字で、単語と単語の間は_で繋ぐ書き方)
    // メソッドの呼び出し時に通常必要な()は記述しない
    public function getHashtagAttribute (): string
    {
        return '#' . $this->name;
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Article')->withTimeStamps();
    }


}
