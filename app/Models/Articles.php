<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    //use HasFactory;

    protected $table='articles';

    protected $fillable=[
        'title',
        'content'

    ];

    public function comments()
    {
        return $this->belongsToMany('App\Models\comments', 'article_comment', 'article_id', 'comment_id' );
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\tags', 'article_tag', 'article_id', 'tag_id' );
    }

}
