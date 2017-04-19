<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;

class ProfitController extends Controller
{
    //
    public function Ylz(Request $request){
        $start=$request->input('start') ? $request->input('start') : '';
        $stop=$request->input('stop') ? $request->input('stop') : '';
        if ($start){$where[]=array('TransactionTime','>',strtotime($start));}
        if ($stop){$where[]=array('TransactionTime','<',strtotime($stop)+86400);}
        if (@$where){
            $r=DB::table('transactions')
                ->select([
                    DB::raw('FROM_UNIXTIME(TransactionTime, "%Y-%m-%d" ) as date '),
                    DB::raw('COUNT(id) AS number'),
                    DB::raw('SUM(TransactionAmount)  AS amount')
                ])
                ->where($where)
                ->groupBy(DB::raw('FROM_UNIXTIME( TransactionTime, "%Y-%m-%d")'))
                ->orderBy('date', 'DESC')
                ->get();
        }else{
            $r=DB::table('transactions')
                ->select([
                    DB::raw('FROM_UNIXTIME(TransactionTime, "%Y-%m-%d" ) as date '),
                    DB::raw('COUNT(id) AS number'),
                    DB::raw('SUM(TransactionAmount)  AS amount')
                ])
                ->groupBy(DB::raw('FROM_UNIXTIME( TransactionTime, "%Y-%m-%d")'))
                ->orderBy('date', 'DESC')
                ->get();
        }
        foreach ($r as $day){
            $ts=Transaction::where([
                ['TransactionTime','>',strtotime($day->date)],
                ['TransactionTime','<',strtotime($day->date)+86400]
            ])->get();
            $num[$day->date]=0;
//            print_r($ts);
            foreach ($ts as $t){
                //cho $t->Fee * ((100 - @$t->Shop->Agent->Profit) / 100)."\n";
                $num[$day->date]+=$t->Fee * 0.75 * ((100 - @$t->Shop->Agent->Profit) / 100);
            }
        }
        //print_r($num);

        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('ProfitYlz', function ($excel) use ($r,$num) {
                $excel->sheet('ProfitYlz', function ($sheet) use ($r,$num){
                    foreach ($r as $item) {
                        $array[]=[
                            '清算日期'=>$item->date,
                            '总交易笔数'=>$item->number,
                            '总交易金额'=>$item->amount,
                            '总分润金额'=>$num[$item->date],
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                });
            })->export('xlsx');
        }


        $perPage = 15;
        $paginate = new LengthAwarePaginator($r,$r->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $r = $r->sortByDesc('id')->forPage($page,$perPage);
        return view('Profit.Ylz',['r'=>$r,'profit'=>$num,'paginate'=>$paginate]);
    }




    public function Agent(Request $request){
        if ($request->input('agent')){
            $agents=Agent::where('AgentName','like','%'.$request->input('agent').'%')->get();
        }else{
            $agents=Agent::all();
        }
        if ($request->input('start')){
            $where[]=array('TransactionTime','>',strtotime($request->input('start')));
        }
        if ($request->input('stop')){
            $where[]=array('TransactionTime','<',strtotime($request->input('stop')) + 86400);
        }
        $profits=array();
        foreach ($agents as $agent){
            $profit=array();
            $profit['AgentName']=$agent->AgentName;
            $shops=Shop::where('ShopAgent',$agent->id)->get();
            $WhereIn=array();
            foreach ($shops as $shop){
                $WhereIn[]=array($shop->ShopNumber);
            }
            if (@$where){
                $r=DB::table('transactions')
                    ->select([
                        DB::raw('FROM_UNIXTIME(TransactionTime, "%Y-%m-%d" ) as date '),
                        DB::raw('COUNT(id) AS number'),
                        DB::raw('SUM(TransactionAmount)  AS amount'),
                        DB::raw('SUM(Fee) AS fee')
                    ])
                    ->where($where)
                    ->WhereIn('ShopNumber',$WhereIn)
                    ->groupBy(DB::raw('FROM_UNIXTIME( TransactionTime, "%Y-%m-%d")'))
                    ->orderBy('date', 'DESC')
                    ->get();
            }else{
                $r=DB::table('transactions')
                    ->select([
                        DB::raw('FROM_UNIXTIME(TransactionTime, "%Y-%m-%d" ) as date '),
                        DB::raw('COUNT(id) AS number'),
                        DB::raw('SUM(TransactionAmount)  AS amount'),
                        DB::raw('SUM(Fee) AS fee')
                    ])
                    ->WhereIn('ShopNumber',$WhereIn)
                    ->groupBy(DB::raw('FROM_UNIXTIME( TransactionTime, "%Y-%m-%d")'))
                    ->orderBy('date', 'DESC')
                    ->get();
            }

            //print_r($r);
            foreach ($r as $t){
                $profit['date']=$t->date;
                $profit['number']=$t->number;
                $profit['amount']=$t->amount;
                $profit['profit']=$t->fee * 0.75 * ($agent->Profit/100);
//                $profit=collect($profit);
                $profits[]=$profit;
            }
        }
        //print_r($profits);
        $profits=collect($profits);

        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('ProfitAgent', function ($excel) use ($profits) {
                $excel->sheet('ProfitAgent', function ($sheet) use ($profits){
                    foreach ($profits as $item) {
                        $array[]=[
                            '清算日期'=>$item['date'],
                            '代理商名称'=>$item['AgentName'],
                            '总交易笔数'=>$item['number'],
                            '总交易金额'=>$item['amount'],
                            '总分润金额'=>$item['profit'],
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                });
            })->export('xlsx');
        }


        $perPage = 15;
        $paginate = new LengthAwarePaginator($profits,$profits->count(),$perPage);
        $paginate->setPath(Paginator::resolveCurrentPath());
        $page = empty($request->get('page'))? 1 : $request->get('page');
        $profits = $profits->sortByDesc('id')->forPage($page,$perPage);
        return view('Profit.Agent',['profits'=>$profits,'paginate'=>$paginate]);
    }
}
