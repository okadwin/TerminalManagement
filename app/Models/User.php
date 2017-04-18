<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser as Sentinel;

class User extends Sentinel
{
    //
    public function UserInfo()
    {
        return $this->hasOne('App\Models\UserInfo','uid','id');
    }
}