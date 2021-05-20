<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_details extends Model
{
    protected $table = "user_details";
    protected $fillable = ['occupation', 'maritalStatus','userId'];

    public function hasUser(){
        return $this->hasOne(User::class);
    }
}
