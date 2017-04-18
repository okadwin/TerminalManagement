<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Channel;
use App\Models\Terminal;
use App\Models\TerminalType;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerminalController extends Controller
{
    //
    public function TypeAddView(){
        return view('Terminal.TypeAdd');
    }

    public function TypeAdd(Request $request) {
        $type=new TerminalType;
        $type->Manufacture=$request->input('Manufacture');
        $type->Type=$request->input('Type');
        $type->Price=$request->input('Price');
        $type->Time=time();
        $type->save();
        return view('ErrorAlert', ['err_info' => '添加成功！']);
    }

    public function Type(){
        $types=TerminalType::paginate();
        return view('Terminal.Type',['types'=>$types]);
    }

    public function TypeEdit($id){
        $type=TerminalType::find($id);
        return view('Terminal.TypeAdd',['type'=>$type]);
    }

    public function TypeUpdate(Request $request,$id){
        $type=TerminalType::find($id);
        $type->Manufacture=$request->input('Manufacture');
        $type->Type=$request->input('Type');
        $type->Price=$request->input('Price');
        $type->save();
        return view('ErrorAlert', ['err_info' => '修改成功！']);
    }

    public function TypeSelect(Request $request){
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('Type');
        if ($Manufacture){$where[]=array('Manufacture','like','%'.$Manufacture.'%');}
        if ($type){$where[]=array('Type',$type);}
        if (@!$where){return view('ErrorAlert', ['err_info' => '请输入查询条件！']);}
        $types=TerminalType::where($where)->paginate();
        return view('Terminal.Type',['types'=>$types]);
    }


    public function API(Request $request){
        $Manufacture=$request->input('Manufacture');
        $types=TerminalType::where('Manufacture','=',$Manufacture)->get();
        return response()->json($types);
    }





    public function TerminalIn(){
        $types=TerminalType::all();
        $terminals=Terminal::paginate();
        return view('Terminal.TerminalIn',['types'=>$types,'terminals'=>$terminals]);
    }

    public function TerminalAdd(Request $request){
        $terminal=new Terminal;
        $user=Sentinel::getUser();
        if (!$request->input('type') || !$request->input('SN') || !$request->input('location')){return response()->json(['msg'=>'终端型号、SN码、库存地点必须填写！']);}
        $s=Terminal::where('SN',$request->input('SN'))->first();
        if ($s){return view('ErrorAlert', ['err_info' => '该SN码设备已经入库！检查SN码是否正确！']);}
        $terminal->Type=$request->input('type');
        $terminal->SN=$request->input('SN');
        $terminal->Location=$request->input('location');
        $terminal->InTime=time();
        $terminal->InUser=$user->id;
        $terminal->save();
//        return view('ErrorAlert', ['err_info' => '入库成功！']);
        return response()->json(['msg'=>'入库成功！']);
    }

    public function TerminalInSelect(Request $request){
        $wtf=0;
        $types=TerminalType::all();
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('type');
        $sn=$request->input('sn');
        $location=$request->input('location');
        $StartTime=$request->input('InTimeStart');
        $StopTime=$request->input('InTimeStop');
        if ($type){$where[] = array('Type','=',$type);}
        if ($sn){$where[] = array('SN','=',$sn);}
        if ($location){$where[] = array('Location','=',$location);}
        if ($StartTime){$where[] = array('InTime','>',strtotime($StartTime));}
        if ($StopTime){$where[] = array('InTime','<',strtotime($StopTime));}
//        if (@!$where && !$Manufacture){
//            return view('ErrorAlert', ['err_info' => '请至少输入一个查询条件！']);
//        }
        if (@$where){
            $terminals=Terminal::where($where)->paginate();
        }else{
            $terminals=Terminal::paginate();
        }
        if ($Manufacture){
            foreach ($terminals as $terminal){
                if ($terminal->TerminalType->Manufacture != $Manufacture){
                    continue;
                }
                $ts[]=$terminal;
            }
            @$terminals=$ts;
            $wtf=1;
        }
        if (@!$terminals){
            return view('ErrorAlert', ['err_info' => '无查询结果！']);
        }


        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('TerminalIn', function ($excel) use ($terminals) {
                $excel->sheet('Agents', function ($sheet) use ($terminals){
                    foreach ($terminals as $item) {
                        //                        print_r($item);
                        $array[]=[
                            '终端厂商名称'=>$item->TerminalType->Manufacture,
                            '终端设备型号'=>$item->TerminalType->Type,
                            '终端SN码'=>$item->SN,
                            '库存地点'=>$item->Location,
                            '入库时间'=>date('Y-m-d H:i:s',$item->InTime),
                            '入库人员'=>$item->User->UserInfo->name,
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                });
            })->export('xlsx');
        }

        //todo:只根据厂家名称查询时的分页问题
        return view('Terminal.TerminalIn',['terminals'=>$terminals,'types'=>$types,'wtf'=>$wtf]);
    }

    public function TerminalInEdit($id){
        $terminal=Terminal::find($id);
        $types=TerminalType::all();
        return view('Terminal.TerminalInEdit',['terminal'=>$terminal,'types'=>$types]);
    }

    public function TerminalInUpdate(Request $request,$id){
        $terminal=Terminal::find($id);
        $terminal->Type=$request->input('type');
//        $terminal->SN=$request->input('SN');
        $terminal->Location=$request->input('location');
        $terminal->save();
        return view('ErrorAlert', ['err_info' => '修改成功！']);
    }

    public function TerminalOut(){
        $types=TerminalType::all();
        $channels=Channel::all();
        $terminals=Terminal::where('OutTime','!=',null)->paginate();
        return view('Terminal.TerminalOut',['channels'=>$channels,'terminals'=>$terminals,'types'=>$types]);
    }

    public function TerminalOutAdd(Request $request){
        $terminal=Terminal::where([['SN',$request->SN],['OutTime','=',null]])->first();
        if (!$terminal){
            return view('ErrorAlert', ['err_info' => '库存中无此SN码设备！']);
        }
        $terminal->ShopNumber=$request->input('ShopNumber');
        $terminal->TerminalNumber=$request->input('TerminalNumber');
        $terminal->Channel=$request->input('Channel');
        $terminal->OutType=$request->input('OutType');
        $terminal->OutTime=time();
        $user=Sentinel::getUser();
        $terminal->OutUser=$user->id;
        $terminal->save();
        return view('ErrorAlert', ['err_info' => '出库成功！']);
    }

    public function TerminalOutEdit($id){
        $terminal=Terminal::find($id);
//        $types=TerminalType::all();
        $channels=Channel::all();
        return view('Terminal.TerminalOutEdit',['terminal'=>$terminal,'channels'=>$channels]);
    }

    public function TerminalOutUpdate(Request $request,$id){
        $terminal=Terminal::find($id);
        $terminal->ShopNumber=$request->input('ShopNumber');
        $terminal->Channel=$request->input('Channel');
        $terminal->OutType=$request->input('OutType');
        $terminal->TerminalNumber=$request->input('TerminalNumber');
        $terminal->save();
        return view('ErrorAlert', ['err_info' => '修改成功！']);
    }

    public function TerminalOutSelect(Request $request){
        $wtf=0;
        $types=TerminalType::all();
        $channels=Channel::all();
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('type');
        $sn=$request->input('SN');
        $StartTime=$request->input('OutStartTime');
        $StopTime=$request->input('OutStopTime');
        if ($type){$where[] = array('Type','=',$type);}
        if ($sn){$where[] = array('SN','=',$sn);}
        if ($StartTime){$where[] = array('OutTime','>',strtotime($StartTime));}
        if ($StopTime){$where[] = array('OutTime','<',strtotime($StopTime));}
//        if (@!$where && !$Manufacture){
//            return view('ErrorAlert', ['err_info' => '请至少输入一个查询条件！']);
//        }
        if (@$where){
            $where[]=array('OutTime','>',0);
            $terminals=Terminal::where($where)->paginate();
        }else{
            $terminals=Terminal::where('OutTime','>',0)->paginate();
        }
        if ($Manufacture){
            foreach ($terminals as $terminal){
                if ($terminal->TerminalType->Manufacture != $Manufacture){
                    continue;
                }
                $ts[]=$terminal;
            }
            @$terminals=$ts;
            $wtf=1;
        }


        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('TerminalOut', function ($excel) use ($terminals) {
                $excel->sheet('Agents', function ($sheet) use ($terminals){
                    foreach ($terminals as $item) {
                        //                        print_r($item);
                        $array[]=[
                            '终端厂商名称'=>$item->TerminalType->Manufacture,
                            '终端设备型号'=>$item->TerminalType->Type,
                            '终端SN码'=>$item->SN,
                            '商户号'=>$item->ShopNumber,
                            '终端号'=>$item->TerminalNumber,
                            '渠道名称'=>$item->ChannelName->Name,
                            '出库类型'=>$item->OutTypeName,
                            '库存地点'=>$item->Location,
                            '出库时间'=>date('Y-m-d H:i:s',$item->OutTime),
                            '出库人员'=>$item->User->UserInfo->name,
                            //fixme:此处的调用，出库的时候也调用的是入库，尤其注意调用出库操作人员的时候
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                });
            })->export('xlsx');
        }



        if (@!$terminals){
            return view('ErrorAlert', ['err_info' => '无查询结果！']);
        }
        //todo:只根据厂家名称查询时的分页问题
        return view('Terminal.TerminalOut',['terminals'=>$terminals,'channels'=>$channels,'types'=>$types,'wtf'=>$wtf]);
    }

    public function TerminalList(){
        $types=TerminalType::all();
        $terminals=Terminal::paginate();
        return view('Terminal.TerminalList',['terminals'=>$terminals,'types'=>$types]);
    }

    public function TerminalListSelect(Request $request){
        $wtf=0;
        $types=TerminalType::all();
        $channels=Channel::all();
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('Type');
        $sn=$request->input('SN');
        if ($type){$where[] = array('Type','=',$type);}
        if ($sn){$where[] = array('SN','=',$sn);}
        if ($request->input('Status')){
            if ($request->input('Status')==2){
                $where[]=array('OutTime','>',0);
            }
            if ($request->input('Status')==1){
//                echo '111';
                $where[]=array('OutTime','=',null);
            }
        }
//        print_r($where);
//        if (@!$where && !$Manufacture){
//            return view('ErrorAlert', ['err_info' => '请至少输入一个查询条件！']);
//        }
        if (@$where){
            $terminals=Terminal::where($where)->paginate();
        }else{
            $terminals=Terminal::paginate();
        }
        if ($Manufacture){
            foreach ($terminals as $terminal){
                if ($terminal->TerminalType->Manufacture != $Manufacture){
                    continue;
                }
                $ts[]=$terminal;
            }
            @$terminals=$ts;
            $wtf=1;
        }
//        if (@!$terminals){
//            return view('ErrorAlert', ['err_info' => '无查询结果！']);
//        }

        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('TerminalList', function ($excel) use ($terminals) {
                $excel->sheet('Agents', function ($sheet) use ($terminals){
                    foreach ($terminals as $item) {
                        //                        print_r($item);
                        $array[]=[
                            '终端厂商名称'=>$item->TerminalType->Manufacture,
                            '终端设备型号'=>$item->TerminalType->Type,
                            '终端SN码'=>$item->SN,
                            '终端状态'=>$item->TerminalStatus,
                            '库存地点'=>$item->Location,
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                });
            })->export('xlsx');
        }

        //todo:只根据厂家名称查询时的分页问题
        return view('Terminal.TerminalList',['terminals'=>$terminals,'channels'=>$channels,'types'=>$types,'wtf'=>$wtf]);

    }
}
