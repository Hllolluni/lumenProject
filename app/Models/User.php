<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName','age','email','password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function createUser($request,$password_hash){
        $data = $this->dataToCreate($request, $password_hash);
        $this->create($data);
    }

    public function dataToCreate($request, $password_hash){
        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $password_hash
        ];
        return $data;
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

}
