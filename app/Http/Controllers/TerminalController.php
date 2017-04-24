<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Channel;
use App\Models\Terminal;
use App\Models\TerminalType;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

    public function Type(Request $request){
//        $types=TerminalType::paginate();
        $where=array();
        $Manufacture=trim($request->input('Manufacture'));
        $type=trim($request->input('Type'));
        if ($Manufacture){$where[]=array('Manufacture','like','%'.$Manufacture.'%');}
        if ($type){$where[]=array('Type',$type);}
        //if (@!$where){return view('ErrorAlert', ['err_info' => '请输入查询条件！']);}
        $types=TerminalType::where($where)->paginate();
        $types->appends($request->all());
        return view('Terminal.Type',['types'=>$types]);
        //return view('Terminal.Type',['types'=>$types]);
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
        $where=array();
        $Manufacture=trim($request->input('Manufacture'));
        $type=trim($request->input('Type'));
        if ($Manufacture){$where[]=array('Manufacture','like','%'.$Manufacture.'%');}
        if ($type){$where[]=array('Type',$type);}
        //if (@!$where){return view('ErrorAlert', ['err_info' => '请输入查询条件！']);}
        $types=TerminalType::where($where)->paginate();
        $types->appends($request->all());
        return view('Terminal.Type',['types'=>$types]);
    }


    public function API(Request $request){
        $Manufacture=$request->input('Manufacture');
        $types=TerminalType::where('Manufacture','=',$Manufacture)->get();
        return response()->json($types);
    }





    public function TerminalIn(Request $request){
        $number=Terminal::where('InTime','>',strtotime(date('Y-m-d', time())))
            ->get([
            DB::raw('COUNT(*) as value')
            ]);
        //print_r($number);
//        $types=TerminalType::all();
//        $terminals=Terminal::paginate();
//        $number=Terminal::where('InTime','>',strtotime(date('Y-m-d', time())))
//            ->get([
//                DB::raw('COUNT(*) as value')
//            ]);
//        $wtf=0;
        $where=array();
        $types=TerminalType::all();
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('type');
        $sn=trim($request->input('sn'));
        $location=trim($request->input('location'));
        $StartTime=$request->input('InTimeStart');
        $StopTime=$request->input('InTimeStop');
        if ($type){$where[] = array('Type','=',$type);}
        if ($sn){$where[] = array('SN','=',$sn);}
        if ($location){$where[] = array('Location','=',$location);}
        if ($StartTime){$where[] = array('InTime','>',strtotime($StartTime));}
        if ($StopTime){$where[] = array('InTime','<',strtotime($StopTime) + 86400);}
        //        if (@!$where && !$Manufacture){
        //            return view('ErrorAlert', ['err_info' => '请至少输入一个查询条件！']);
        //        }
        if ($where){
            $terminals=Terminal::where($where)->get();
        }else{
            $terminals=Terminal::get();
            //print_r($where);
        }
        if ($Manufacture && !$type){
            $types=TerminalType::where('Manufacture','like','%'.$Manufacture.'%')->get();
//            print_r($types);
            foreach ($types as $type){
                $terminals=$terminals->filter(function ($item)use ($type){
                    if ($item->Type == $type->id){
                        return true;
                    }else{
                        return false;
                    }
                });
            }
        }
        if (@!$terminals){
            return view('ErrorAlert', ['err_info' => '无查询结果！点击确定返回']);
        }

        //$terminals=collect($terminals);

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
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }



//        print_r($terminals);exit;
//        $terminals->appends($request->all());
        //todo:只根据厂家名称查询时的分页问题
        $perPage = 15;
        $paginate = new LengthAwarePaginator($terminals,$terminals->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $paginate->appends($request->all());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $terminals = $terminals->sortByDesc('id')->forPage($page,$perPage);
        return view('Terminal.TerminalIn',['terminals'=>$terminals,'number'=>$number,'types'=>$types,'paginate'=>$paginate]);
        //return view('Terminal.TerminalIn',['types'=>$types,'terminals'=>$terminals,'number'=>$number,'wtf'=>0]);
    }

    public function TerminalAdd(Request $request){
        $terminal=new Terminal;
        $user=Sentinel::getUser();
        if (!$request->input('type') || !$request->input('SN') || !$request->input('location')){return response()->json(['msg'=>'终端型号、SN码、库存地点必须填写！']);}
        $s=Terminal::where('SN',$request->input('SN'))->first();
        if ($s){return response()->json(['msg'=>'该SN码设备已经入库！请检查SN码是否正确']);;}
        $terminal->Type=$request->input('type');
        $terminal->SN=$request->input('SN');
        $terminal->Location=$request->input('location');
        $terminal->InTime=time();
        $terminal->InUser=$user->id;
        $terminal->save();
//        return view('ErrorAlert', ['err_info' => '入库成功！']);
        return response()->json(['msg'=>'入库成功！']);
    }

    /*public function TerminalInSelect(Request $request){
        $number=Terminal::where('InTime','>',strtotime(date('Y-m-d', time())))
            ->get([
                DB::raw('COUNT(*) as value')
            ]);
        $wtf=0;
        $types=TerminalType::all();
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('type');
        $sn=trim($request->input('sn'));
        $location=trim($request->input('location'));
        $StartTime=$request->input('InTimeStart');
        $StopTime=$request->input('InTimeStop');
        if ($type){$where[] = array('Type','=',$type);}
        if ($sn){$where[] = array('SN','=',$sn);}
        if ($location){$where[] = array('Location','=',$location);}
        if ($StartTime){$where[] = array('InTime','>',strtotime($StartTime));}
        if ($StopTime){$where[] = array('InTime','<',strtotime($StopTime) + 86400);}
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
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }


        return view('Terminal.TerminalIn',['terminals'=>$terminals,'number'=>$number,'types'=>$types,'wtf'=>$wtf]);
    }*/

    public function TerminalInEdit($id){
        $terminal=Terminal::find($id);
        $types=TerminalType::all();
        return view('Terminal.TerminalInEdit',['terminal'=>$terminal,'types'=>$types,'wtf'=>0]);
    }

    public function TerminalInUpdate(Request $request,$id){
        $terminal=Terminal::find($id);
        $terminal->Type=$request->input('type');
//        $terminal->SN=$request->input('SN');
        $terminal->Location=$request->input('location');
        $terminal->save();
        return view('ErrorAlert', ['err_info' => '修改成功！']);
    }

    public function TerminalOut(Request $request){
        $number=Terminal::where('OutTime','>',strtotime(date('Y-m-d', time())))
            ->get([
                DB::raw('COUNT(*) as value')
            ]);

        $types=TerminalType::all();
        $channels=Channel::all();
        $terminals=Terminal::where('OutTime','!=',null)->get();
//
//
//
//        $number=Terminal::where('OutTime','>',strtotime(date('Y-m-d', time())))
//            ->get([
//                DB::raw('COUNT(*) as value')
//            ]);
//        $wtf=0;
//        $types=TerminalType::all();
//        $channels=Channel::all();
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('type');
        $sn=trim($request->input('SN'));
        $StartTime=$request->input('OutStartTime');
        $StopTime=$request->input('OutStopTime');
        if ($type){$where[] = array('Type','=',$type);}
        if ($sn){$where[] = array('SN','=',$sn);}
        if ($StartTime){$where[] = array('OutTime','>',strtotime($StartTime));}
        if ($StopTime){$where[] = array('OutTime','<',strtotime($StopTime) + 86400);}
        //        if (@!$where && !$Manufacture){
        //            return view('ErrorAlert', ['err_info' => '请至少输入一个查询条件！']);
        //        }

        $where[]=array('OutTime','>',0);
        $terminals=Terminal::where($where)->get();

        if ($Manufacture && !$type){
            $types=TerminalType::where('Manufacture','like','%'.$Manufacture.'%')->get();
            foreach ($types as $type){
                $terminals=$terminals->filter(function ($item)use ($type){
                    if ($item->Type == $type->id){
                        return true;
                    }else{
                        return false;
                    }
                });
            }
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
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }

        $perPage = 15;
        $paginate = new LengthAwarePaginator($terminals,$terminals->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $paginate->appends($request->all());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $terminals = $terminals->sortByDesc('id')->forPage($page,$perPage);
        return view('Terminal.TerminalOut',['terminals'=>$terminals,'channels'=>$channels,'types'=>$types,'paginate'=>$paginate,'number'=>$number]);

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
        return view('Terminal.TerminalOutEdit',['terminal'=>$terminal,'channels'=>$channels,'wtf'=>0]);
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



    public function TerminalList(Request $request){
        $all=Terminal::first([DB::raw('COUNT(*) as value')]);
        $all=$all->value;
        $in=Terminal::where('OutTime',null)->first([DB::raw('COUNT(*) as value')]);
        $in=$in->value;
        $out=Terminal::where('OutTime','>',0)->first([DB::raw('COUNT(*) as value')]);
        $out=$out->value;
        $number=array('all'=>$all,'in'=>$in,'out'=>$out);
//        $types=TerminalType::all();
//        $terminals=Terminal::paginate();
//        $all=Terminal::first([DB::raw('COUNT(*) as value')]);
//        $all=$all->value;
//        $in=Terminal::where('OutTime',null)->first([DB::raw('COUNT(*) as value')]);
//        $in=$in->value;
//        $out=Terminal::where('OutTime','>',0)->first([DB::raw('COUNT(*) as value')]);
//        $out=$out->value;
//        $number=array('all'=>$all,'in'=>$in,'out'=>$out);
//        $wtf=0;
        $where=array();
        $types=TerminalType::all();
        $channels=Channel::all();
        $Manufacture=$request->input('Manufacture');
        $type=$request->input('Type');
        $sn=trim($request->input('SN'));
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
            $terminals=Terminal::where($where)->get();
        }else{
            $terminals=Terminal::all();
        }
        if ($Manufacture && !$type){
            $types=TerminalType::where('Manufacture','like','%'.$Manufacture.'%')->get();
            foreach ($types as $type){
                $terminals=$terminals->filter(function ($item)use ($type){
                    if ($item->Type == $type->id){
                        return true;
                    }else{
                        return false;
                    }
                });
            }
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
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }

        $perPage = 15;
        $paginate = new LengthAwarePaginator($terminals,$terminals->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $paginate->appends($request->all());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $terminals = $terminals->sortByDesc('id')->forPage($page,$perPage);
        return view('Terminal.TerminalList',['terminals'=>$terminals,'channels'=>$channels,'types'=>$types,'number'=>$number,'paginate'=>$paginate]);
    }

}
