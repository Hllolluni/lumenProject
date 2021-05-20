<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $fillable = ['title','body','user_Id'];


    public function theUser(){
        return $this->belongsTo(User::class);
    }

    public function theComments(){
        return $this->hasMany(Comment::class);
    }
}
