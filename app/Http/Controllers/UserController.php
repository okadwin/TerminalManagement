<?php

namespace App\Http\Controllers;

use App\Models\User;
use Sentinel,Validator;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function LoginView(){
        return view('User.Login');
    }

    public function LoginCheck(Request $request){

        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('ErrorAlert', ['err_info' => '验证码错误！']);
        }

        $username=$request->input('UserName');
        $password=$request->input('PassWord');
        $credentials = [
            'email' => $username,
            'password'=>$password,
        ];
        $user = Sentinel::authenticate($credentials);
        if ($user){//todo:用户验证
//            Sentinel::login($user);
            return redirect('/');
        }else{
            return view('ErrorAlert', ['err_info' => '用户名或密码错误！']);
        }
    }

    public function Index(){
        $users=User::paginate();
        return view('User.Index',['users'=>$users]);
    }
    public function AddView(){
        return view('User.Add');
    }

    public function Add(Request $request){
        if (count(User::where('email',$request->input('username'))->get())){return view('ErrorAlert', ['err_info' => '该用户名已经存在！']);}
        $credentials = [
            'email'    => $request->input('username'),
            'password' => $request->input('password'),
        ];
        $user = Sentinel::registerAndActivate($credentials);
        if (!$request->input('permission')){return view('ErrorAlert', ['err_info' => '必须至少勾选一项权限！']);}
        foreach ($request->input('permission') as $item => $value){
            $permission[$value] = true;
        }
        $user->setPermissions($permission);
//        print_r($user);
        $user->save();
        $info=new UserInfo;
        $info->name=$request->input('name');
        $info->phone=$request->input('phone');
        $info->email=$request->input('email');
        $info->uid=$user->id;
        $info->save();
        return view('ErrorAlert', ['err_info' => '用户添加成功！']);
    }

    public function Update(Request $request,$id){
        if (!$request->input('permission')){return view('ErrorAlert', ['err_info' => '必须至少勾选一项权限！']);}
        foreach ($request->input('permission') as $item => $value){
            $permission[$value] = true;
        }
        $user=Sentinel::findById($id);
        if ($request->input('password')){
            $p=[
                'email'=>$user->email,
                'password'=>$request->input('password')
            ];
           $user = Sentinel::update($user,$p);
        }
        $user->setPermissions($permission);
        $user->save();
        $info=UserInfo::where('uid',$user->id)->first();
        //print_r($info);
        $info->name=$request->input('name');
        $info->phone=$request->input('phone');
        $info->email=$request->input('email');
        $info->save();
        return view('ErrorAlert', ['err_info' => '编辑成功！']);
    }

    public function Edit($id){
        $user=User::find($id);
        return view('User.Add',['user'=>$user]);

    }

    public function Select(Request $request){
        $users=User::where('email','like','%'.trim($request->input('username')).'%')->paginate();
        return view('User.Index',['users'=>$users]);
    }

    public function Delete($id){
        $user=Sentinel::findById($id);
        $user->delete();
        return view('ErrorAlert', ['err_info' => '用户已删除！']);
    }

    public function Logout(){
        Sentinel::logout();
        return redirect('/');
    }
}
