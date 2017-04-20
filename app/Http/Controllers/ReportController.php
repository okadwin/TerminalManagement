<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Transaction;

class ReportController extends Controller
{
    //
    public function Terminal(Request $request){
        if ($request->input('TerminalNumber')){
            $terminals=Terminal::where('TerminalNumber',$request->input('TerminalNumber'))->get();
        }else{
            $terminals=Terminal::where('OutTime','>',0)->get();
        }
        //print_r($terminals);
        $r=array();
        foreach ($terminals as $terminal){
            $number=0;
            $amount=0;
            $profitY=0;//易联众分润
            $profitA=0;//代理商分润
            $where=array();//初始化条件
            if ($request->input('start')){
                $where[]=['TransactionTime','>',strtotime($request->input('start'))];
            }
            if ($request->input('stop')){
                $where[]=['TransactionTime','<',strtotime($request->input('stop'))+86400];
            }
            $where[]=['TerminalNumber',$terminal->TerminalNumber];
//            print_r($where);exit;
            $transactions=Transaction::where($where)->get();
//            if (!count($transactions)){
            //                continue;
            //            }
            foreach ($transactions as $transaction){
                $number+=1;
                $amount+=$transaction->TransactionAmount;
                $profitY+=$transaction->Fee * 0.75 * ((100 - $transaction->Shop->Agent->Profit)/100);
                $profitA+=$transaction->Fee * 0.75 * ($transaction->Shop->Agent->Profit/100);
            }
            //print_r($request->input('low'));
            if ($request->input('low')==1){
                //echo '11111111111111';
                if (!(($profitY < $terminal->TerminalType->Price) && ($terminal->OutType ==1 ))){
                    continue;//免投，并且易联众分润低于售价
                }
            }
            $r[]=[
                'TerminalNumber'        =>$terminal->TerminalNumber,
                'ShopNumber'            =>$terminal->ShopNumber,
                'Number'                =>$number,
                'Amount'                =>$amount,
                'ProfitY'               =>$profitY,
                'ProfitA'               =>$profitA
            ];
        }

        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('ReportTerminal', function ($excel) use ($r) {
                $excel->sheet('ReportTerminal', function ($sheet) use ($r){
                    foreach ($r as $item) {
                        $array[]=[
                            '终端号'=>$item['TerminalNumber'],
                            '商户号'=>$item['ShopNumber'],
                            '总交易笔数'=>$item['Number'],
                            '总交易金额'=>$item['Amount'],
                            '易联众分润金额'=>$item['ProfitY'],
                            '代理商分润金额'=>$item['ProfitA'],
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }



//        print_r($r);
        $r=collect($r);

        $perPage = 15;
        $paginate = new LengthAwarePaginator($r,$r->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $r = $r->sortByDesc('id')->forPage($page,$perPage);
        return view('Report.Terminal',['r'=>$r,'paginate'=>$paginate]);
    }


    public function Zero(Request $request){
        if ($request->input('TerminalNumber')){
            $where[]=['TerminalNumber',$request->input('TerminalNumber')];
        }
        if ($request->input('start')){
            $where[]=['OutTime','>',strtotime($request->input('start'))];
        }else{
            $where[]=['OutTime','>',0];
        }
        if ($request->input('stop')){
            $where[]=['OutTime','<',strtotime($request->input('stop')) + 86400];
        }

        $terminals=Terminal::where($where)->get();


        $ts=DB::table('transactions')
            ->select(DB::raw('distinct TerminalNumber'))
            ->get();

        $r=array();
        $s=array();
        foreach ($ts as $t){
            $s[]=$t->TerminalNumber;
        }
        //print_r($s);
        foreach ($terminals as $terminal){
            if (!in_array($terminal->TerminalNumber,$s)){
                $r[]=[
                    'TerminalNumber'    =>$terminal->TerminalNumber,
                    'ShopNumber'        =>$terminal->ShopNumber,
                    'OutTime'           =>date('Y-m-d',$terminal->OutTime),
                ];
            }
        }


        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('ReportZero', function ($excel) use ($r) {
                $excel->sheet('ReportZero', function ($sheet) use ($r){
                    foreach ($r as $item) {
                        $array[]=[
                            '终端号'=>$item['TerminalNumber'],
                            '商户号'=>$item['ShopNumber'],
                            '出库日期'=>$item['OutTime'],
                            '总交易笔数'=>0,
                            '总交易金额'=>0,
                            '易联众分润金额'=>0,
                            '代理商分润金额'=>0,
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }


        $r=collect($r);

        $perPage = 15;
        $paginate = new LengthAwarePaginator($r,$r->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $r = $r->sortByDesc('id')->forPage($page,$perPage);
        return view('Report.Zero',['r'=>$r,'paginate'=>$paginate]);

    }
}
