<?php

namespace App\Http\ViewComposers;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Contracts\View\View;

class UserComposer
{
    protected $globalUser;
    public function __construct()
    {
        // 已登录用户
        if (Sentinel::check()) {
            $this->globalUser = Sentinel::getUser();
        }else{
            $this->globalUser = null;
        }
    }
    public function globalUser(View $view)
    {
        $view->with('globalUser',$this->globalUser);
    }
}