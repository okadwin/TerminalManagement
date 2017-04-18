<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    public function Shop(){
        return $this->hasOne('App\Models\Shop','ShopNumber','ShopNumber');
    }



}
