<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    //
    public function TerminalType(){
        return $this->hasOne('App\Models\TerminalType','id','Type');
    }

    public function ChannelName(){
        return $this->hasOne('App\Models\Channel','id','Channel');
    }

    public function User(){
        return $this->hasOne('App\Models\User','id','InUser');
    }

    public function getOutTypeNameAttribute(){
        switch ($this->OutType){
            case 1:
                return "免投";
                break;
            case 2:
                return "自购";
                break;
            default:
                return "未知/错误";
        }
    }

    public function getTerminalStatusAttribute(){
        if ($this->OutTime>0){
            return "已出库";
        }else{
            return"已入库";
        }
    }

}
