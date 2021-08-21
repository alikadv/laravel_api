<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tags extends Model
{
    public function Articles()
    {
        return $this->belongsToMany('App\Models\Articles', 'article_tag', 'tag_id', 'article_id' );
    }
}
