<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    public function Agent(){
        return $this->hasOne('App\Models\Agent','id','ShopAgent');
    }
    public function getStatusAttribute(){
        switch ($this->ShopStatus){
            case 0:
                return "已注销";
                break;
            case 1:
                return "已启用";
                break;
            case 2:
                return "已禁用";
                break;
            default:
                return "未知状态";
        }
    }
}
