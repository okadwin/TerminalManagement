<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\UserInfo;

class UserInit extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $credentials = [
            'email'    => 'admin',
            'password' => '123456',
        ];
        $user = Sentinel::registerAndActivate($credentials);
        $permission=array(
            "agent"=>true,
            "shop"=>true,
            "terminal.type"=>true,
            "terminal.list"=>true,
            "terminal.in"=>true,
            "terminal.out"=>true,
            "channel"=>true,
            "transaction.list"=>true,
            "transaction.in"=>true,
            "profit.ylz"=>true,
            "profit.agent"=>true,
            "report.terminal"=>true,
            "report.zero"=>true,
            "user"=>true
        );
        $user->setPermissions($permission);
        $user->save();
        $info=new UserInfo;
        $info->name='admin';
        $info->phone='13888888888';
        $info->email='root@okadwin.com';
        $info->uid=$user->id;
        $info->save();
    }
}
