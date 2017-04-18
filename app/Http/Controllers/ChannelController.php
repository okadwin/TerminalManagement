<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    //
    public function AddView(){
        return view('Channel.Add');
    }

    public function Add(Request $request){
        $channel = new Channel;
        $channel->Name=$request->input('Name');
        $channel->Contact=$request->input('Contact');
        $channel->ContactPhone=$request->input('ContactPhone');
        $channel->CreateTime=time();
        $channel->save();
        return view('ErrorAlert', ['err_info' => '添加成功！']);
    }

    public function Index(){
        $channels=Channel::paginate();
        return view('Channel.Index',['channels'=>$channels]);
    }

    public function Update(Request $request,$id){
        $channel=Channel::find($id);
        $channel->Name=$request->input('Name');
        $channel->Contact=$request->input('Contact');
        $channel->ContactPhone=$request->input('ContactPhone');
        $channel->save();
        return view('ErrorAlert', ['err_info' => '修改成功！']);
    }

    public function Edit($id) {
        $channel=Channel::find($id);
        return view('Channel.Add',['channel'=>$channel]);
    }

    public function Select(Request $request){
        $Name=$request->input('Name');
        if ($Name){$where[]=array('Name',$Name);}
        if (!$where){return view('ErrorAlert', ['err_info' => '请输入查询条件！']);}
        $channels=Channel::where($where)->paginate();
        return view('Channel.Index',['channels'=>$channels]);
    }
}
