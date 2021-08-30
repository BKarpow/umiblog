<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function article()
    {
        return $this->belongsTo('App\Models\Article', 'article_id', 'id');
    }

    public function date():string
    {
        if ($this->created_at) {
            return $this->created_at->format('d-m-Y H:i');
        } else {
            return '';
        }
    }

}
