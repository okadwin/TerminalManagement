<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionInto extends Model
{
    //
    public function ChannelName(){
        return $this->hasOne('App\Models\Channel','id','Channel');
    }

    public function UserName(){
        return $this->hasOne('App\Models\User','id','User');
    }
}
