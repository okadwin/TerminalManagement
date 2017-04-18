<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Shop;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //
    public function ShopAdd(Request $request){
        $ShopAgent=$request->input('ShopAgent');
        $ShopNumber=$request->input('ShopNumber');
        $ShopName=$request->input('ShopName');
        $ShopContact=$request->input('ShopContact');
        $ShopContactPhone=$request->input('ShopContactPhone');
        $ShopContactID=$request->input('ShopContactID');
        $ShopJoinTime=time();
        $ShopStatus=$request->input('ShopStatus');
        DB::table('shops')
            ->insertGetId(['ShopAgent'=>$ShopAgent,'ShopNumber'=>$ShopNumber,'ShopName'=>$ShopName,'ShopContact'=>$ShopContact,'ShopContactPhone'=>$ShopContactPhone,'ShopContactID'=>$ShopContactID,'ShopJoinTime'=>$ShopJoinTime,'ShopStatus'=>$ShopStatus]);
        return view('ErrorAlert', ['err_info' => '添加成功！']);
    }

    public function ShopIndex(){
        $shops=Shop::paginate();
        //print_r($shops);exit;
        $agents=Agent::all();
        return view('Shop.Index', ['shops' => $shops,'agents'=>$agents]);
    }

    public function ShopSelect(Request $request){
        $ShopNumber=$request->input('ShopNumber');
        $ShopName=$request->input('ShopName');
        $ShopAgent=$request->input('ShopAgent');
        $ShopTimeStart=$request->input('ShopTimeStart');
        $ShopTimeStop=$request->input('ShopTimeStop');
        $ShopStatus=$request->input('ShopStatus');
//todo:翻页方式是GET，翻页后可能无法带有查询条件，可以改成GET传递查询条件即可
        if ($ShopNumber){$where[] = array('ShopNumber','=',$ShopNumber);}
        if ($ShopName){$where[] = array('ShopName','like','%'.$ShopName.'%');}
        if ($ShopAgent){$where[] = array('ShopAgent','=',$ShopAgent);}
        if ($ShopTimeStart){$ShopTimeStart=strtotime($ShopTimeStart);$where[] = array('ShopJoinTime','>',$ShopTimeStart);}
        if ($ShopTimeStop){$ShopTimeStop=strtotime($ShopTimeStop);$where[] = array('ShopJoinTime','<',$ShopTimeStop);}
        if ($ShopStatus/*||$ShopStatus===0*/!==''){$where[] = array('ShopStatus','=',$ShopStatus);}
        if (@!$where){
//            return view('ErrorAlert', ['err_info' => '请输入查询条件！']);
            $shops=Shop::paginate();
        }else{
            $shops=Shop::where($where)->paginate();
        }
        $agents=Agent::all();
//        print_r($shops);exit;
        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('Shop', function ($excel) use ($shops) {
                $excel->sheet('Agents', function ($sheet) use ($shops){
                    foreach ($shops as $item) {
//                        print_r($item);
                        $array[]=[
                            '商户编号'=>$item->ShopNumber,
                            '商户名称'=>$item->ShopName,
                            '所属代理商'=>$item->Agent->AgentName,
                            '联系人'=>$item->ShopContact,
                            '联系电话'=>$item->ShopContactPhone,
                            '入网时间'=>date('Y-m-d H:i:s',$item->ShopJoinTime),
                            '商户状态'=>$item->Status,
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                });
            })->export('xlsx');
        }
        return view('Shop.Index', ['shops' => $shops,'agents'=>$agents]);
    }

    public function ShopEdit($id){
        $agents=Agent::all();
        $shop = Shop::where('id',$id)->first();
        return view('Shop.Edit',['agents'=>$agents,'shop'=>$shop]);
    }

    public function ShopUpdate(Request $request,$id){
        $shop=Shop::find($id);
        $shop->ShopAgent=$request->input('ShopAgent');
        $shop->ShopNumber=$request->input('ShopNumber');
        $shop->ShopName=$request->input('ShopName');
        $shop->ShopContact=$request->input('ShopContact');
        $shop->ShopContactPhone=$request->input('ShopContactPhone');
        $shop->ShopContactID=$request->input('ShopContactID');
        //$shop->ShopJoinTime=time();
        $shop->ShopStatus=$request->input('ShopStatus');
        $shop->save();
        return view('ErrorAlert', ['err_info' => '修改成功！']);
    }

    public function ShopAddView(){
        $agents=Agent::all();
        return view('Shop.Add',['agents'=>$agents]);
    }
}
