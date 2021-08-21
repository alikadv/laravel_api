<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $table='comments';

    protected $fillable=[
        'content'
    ];



    public function Articles()
    {
        return $this->belongsToMany('App\Models\Articles', 'article_comment',  'comment_id', 'article_id');
    }
}
