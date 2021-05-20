<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $fillable = ['body','user_Id','post_Id'];


    public function theUser(){
        return $this->belongsTo(User::class);
    }

    public function thePost(){
        return $this->belongsTo(Post::class);
    }
}
