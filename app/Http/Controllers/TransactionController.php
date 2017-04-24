<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Channel;
use App\Models\Agent;
use App\Models\Shop;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionInto;

class TransactionController extends Controller
{
    //

    public function Into(Request $request){
        $channels=Channel::all();

        if ($request->hasFile('transaction')) {//如果是导入文件
            $file = $request->file('transaction');
            $baseName =time();
            $newName = $baseName;
            $saveDir = 'import/'.date('Y').'/'.date('m').'/';
            $savePath = $saveDir.$newName.'.'.$file->getClientOriginalExtension();
            Storage::put($savePath, file_get_contents($file->getRealPath()));
            $res =array();
            Excel::load('storage/app/'.$savePath, function($reader) use (&$res) {
                $reader = $reader->getSheet(0);
                $res = $reader->toArray();
                //print_r($res);
            });
            unset($res[0]);
            $terminals=Terminal::where('OutTime','>',0)->get();

            foreach ($terminals as $terminal) {
                $terminalNumber[]=$terminal->TerminalNumber;
            }
            foreach ($res as $item){
                if (!in_array($item[3],$terminalNumber)){
                    return view('ErrorAlert', ['err_info' => '错误！表格中存在非法的终端编号，请检查后重新上传！']);
                }
            }

            foreach ($res as $item){
                $transaction                   = new Transaction();
//                $transaction->Channel          = $request->input('channel');
                $transaction->TransactionTime  = strtotime($item[0].'-'.$item[6][0].$item[6][1].'-'.$item[6][2].$item[6][3].' '.$item[7][0].$item[7][1].':'.$item[7][2].$item[7][3].":".$item[7][4].$item[7][5]);
                $transaction->ShopNumber       = $item[2];
                $transaction->TerminalNumber   = $item[3];
                $transaction->TransactionName  = $item[4];
                $transaction->SettleName       = $item[5];
                $transaction->SettleAmount     = $item[13];
                $transaction->BankAccountNumber= $item[8];
                $transaction->TransactionAmount= $item[9];
                $transaction->Fee              = $item[15];
                $transaction->save();
            }
            $log=new TransactionInto;
            $user=Sentinel::getUser();
            $log->Channel=$request->input('channel');
            $log->Number=count($res);
            $log->Time=time();
            $log->User=$user->id;
            $log->save();
            return view('ErrorAlert', ['err_info' => '导入成功！']);
        }elseif($request->input('ChannelSearch')){//提交查询
            $transactions_into=TransactionInto::where('Channel',$request->input('ChannelSearch'))->paginate();
            return view('Transaction.Into',['channels'=>$channels,'transactions_into'=>$transactions_into]);
        }else{//默认无动作首页
            $transactions_into=TransactionInto::paginate();
            return view('Transaction.Into',['channels'=>$channels,'transactions_into'=>$transactions_into]);
        }
    }


    public function TransactionList(Request $request){
        $agents=Agent::all();
        $transactions=Transaction::all();
        $ShopNumber=$request->input('ShopNumber') ? trim($request->input('ShopNumber')) : '';
        $ShopName=$request->input('ShopName') ? trim($request->input('ShopName')) : '';
        $Agent=$request->input('Agent') ? $request->input('Agent') : '';
        $TimeStart=$request->input('TimeStart') ? $request->input('TimeStart') : '';
        $TimeStop=$request->input('TimeStop') ? $request->input('TimeStop') : '';
        $TerminalNumber=$request->input('TerminalNumber') ? trim($request->input('TerminalNumber')) : '';


        if ($ShopName){
            $shops=Shop::where('ShopName','like','%'.$ShopName.'%')->get();
            //print_r($shops);
            foreach ($shops as $shop){
                $transactions=$transactions->filter(function ($item)use ($shop){
                    if ($item->ShopNumber == $shop->ShopNumber){
                        return true;
                    }else{
                        return false;
                    }
                });
            }
            if (!count($shops)){
                $transactions=collect(array());
            }
        }
        if ($Agent){
            $shops=Shop::where('ShopAgent',$Agent)->get();
            foreach ($shops as $shop){
                $transactions=$transactions->filter(function ($item) use ($shop){
                    if ($item->ShopNumber == $shop->ShopNumber){
                        return true;
                    }else{
                        return false;
                    }
                });
            }
            if (!count($shops)){
                $transactions=collect(array());
            }
        }

        if ($ShopNumber){
            $transactions=$transactions->filter(function ($item) use ($ShopNumber){
                if ($item->ShopNumber == $ShopNumber){
                    return true;
                }else{
                    return false;
                }
            });
        }

        if ($TimeStart){
            $transactions=$transactions->filter(function ($item) use ($TimeStart){
                if ($item->TransactionTime>strtotime($TimeStart)){
                    return true;
                }else{
                    return false;
                }
            });
        }
        if ($TimeStop){
            $transactions=$transactions->filter(function ($item) use ($TimeStop){
                if ($item->TransactionTime<strtotime($TimeStop) +86400){
                    return true;
                }else{
                    return false;
                }
            });
        }

        if ($TerminalNumber){
            $transactions=$transactions->filter(function ($item) use ($TerminalNumber){
                if ($item->TerminalNumber == $TerminalNumber){
                    return true;
                }else{
                    return false;
                }
            });
        }


        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('Transactions', function ($excel) use ($transactions) {
                $excel->sheet('Transactions', function ($sheet) use ($transactions){
                    foreach ($transactions as $item) {
                        //                        print_r($item);
                        $date=date('Y-m-d',$item->TransactionTime);
                        $time=date('H:i:s',$item->TransactionTime);
                        $array[]=[
                            '商户编号'=>$item->ShopNumber,
                            '商户名称'=>@$item->Shop->ShopName,
                            '终端号'=>$item->TerminalNumber,
                            '所属代理商'=>@$item->Shop->Agent->AgentName,
                            '银行卡号'=>$item->BankAccountNumber,
                            '交易金额'=>$item->TransactionAmount,
                            '清算金额'=>$item->SettleAmount,
                            '手续费'=>$item->Fee,
                            '交易日期'=>$date,
                            '交易时间'=>$time,
                            '交易类型'=>$item->TransactionName,
                            '清算类型'=>$item->SettleName,
                            '易联众分润'=>$item->Fee * 0.75 * ((100 - @$item->Shop->Agent->Profit) / 100),
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }

        $perPage = 15;
        $paginate = new LengthAwarePaginator($transactions,$transactions->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $paginate->appends($request->all());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $transactions = $transactions->sortByDesc('id')->forPage($page,$perPage);
        return view('Transaction.Index',['agents'=>$agents,'transactions'=>$transactions,'paginate'=>$paginate]);
    }


}
