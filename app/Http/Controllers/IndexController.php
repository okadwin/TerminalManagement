<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function Index(){
        $transactions=Transaction::all();
        $amount=0;
        $profit=0;
        $number=0;
        foreach ($transactions as $transaction) {
            $profit+=$transaction->Fee * 0.75 * ((100 - $transaction->Shop->Agent->Profit) / 100);
            $amount+=$transaction->TransactionAmount;
            $number+=1;
        }
        $transactions=Transaction::where('TransactionTime','>',strtotime(date('Y-m-d', time())))->get();
        $profitt=0;
        $numbert=0;
        $amountt=0;
        foreach ($transactions as $transaction){
            $profitt+=$transaction->Fee * 0.75 * (100 - ($transaction->Shop->Agent->Profit - 100) / 100);
            $amountt+=$transaction->TransactionAmount;
            $numbert+=1;
        }
        $shop=DB::table('shops')->select(DB::raw('COUNT(*) as value'))->first();
        //$shop=Shop::first(DB::raw('COUNT(*) as value'));
        $shop=$shop->value;
        $shopt=DB::table('shops')
            ->select(DB::raw('COUNT(*) as value'))
            ->where('ShopJoinTime','>',strtotime(date('Y-m-d', time())))
            ->first();
        //$shopt=Shop::where('ShopJoinTime','>',strtotime(date('Y-m-d', time())))->first(DB::raw('COUNT(*) as value'));
        $shopt=$shopt->value;
        $head=array(
            'amount'    =>$amount,
            'amountt'   =>$amountt,
            'profit'    =>$profit,
            'profitt'   =>$profitt,
            'number'    =>$number,
            'numbert'   =>$numbert,
            'shop'      =>$shop,
            'shopt'     =>$shopt
        );

        for ($days=0;$days<7;$days++){
            $day=strtotime(date('Y-m-d', time()))-86400*7;
            $value=DB::table('shops')
                ->select(DB::raw('COUNT(*) as value'))
                ->where('ShopJoinTime','<',$day + $days * 86400)
                ->first();
            $shops[$days]=$value->value;
        }
        foreach ($shops as $item => $value){
            if (!$value) {
                $shops[$item] = 0;
            }
            $shops[$item]=(int)$value;
        }

        for ($days=0;$days<7;$days++){
            $day=strtotime(date('Y-m-d', time()))-86400*7;
            $value=DB::table('transactions')
                ->select(DB::raw('COUNT(*) as value'))
                ->where('TransactionTime','<',$day + $days * 86400)
                ->first();
            $numbers[$days]=$value->value;
        }
        foreach ($numbers as $item => $value){
            if (!$value) {
                $numbers[$item] = 0;
            }
            $numbers[$item]=(int)$value;
        }
        for ($days=0;$days<7;$days++){
            $day=strtotime(date('Y-m-d', time()))-86400*7;
            $value=DB::table('transactions')
                ->select(DB::raw('SUM(TransactionAmount) as value'))
                ->where('TransactionTime','<',$day + $days * 86400)
                ->first();
            $amounts[$days]=$value->value;
        }
        foreach ($amounts as $item => $value){
            if (!$value) {
                $amounts[$item] = 0;
            }
            $amounts[$item]=(int)$value;
        }

        //////////////////////////////////
        for ($days=0;$days<7;$days++){
            $day=strtotime(date('Y-m-d', time()))-86400*7;
            $value=DB::table('shops')
                ->select(DB::raw('COUNT(*) as value'))
                ->where([['ShopJoinTime','>',$day + $days * 86400],['ShopJoinTime','<',$day + $days * 86400 + 86400]])
                ->first();
            $shopd[$days]=$value->value;
        }
        foreach ($shopd as $item => $value){
            if (!$value) {
                $shopd[$item] = 0;
            }
            $shopd[$item]=(int)$value;
        }

        for ($days=0;$days<7;$days++){
            $day=strtotime(date('Y-m-d', time()))-86400*7;
            $value=DB::table('transactions')
                ->select(DB::raw('COUNT(*) as value'))
                ->where([['TransactionTime','>',$day + $days * 86400],['TransactionTime','<',$day + $days * 86400 + 86400]])
                ->first();
            $numberd[$days]=$value->value;
        }
        foreach ($numberd as $item => $value){
            if (!$value) {
                $numberd[$item] = 0;
            }
            $numberd[$item]=(int)$value;
        }
        for ($days=0;$days<7;$days++){
            $day=strtotime(date('Y-m-d', time()))-86400*7;
            $value=DB::table('transactions')
                ->select(DB::raw('SUM(TransactionAmount) as value'))
                ->where([['TransactionTime','>',$day + $days * 86400],['TransactionTime','<',$day + $days * 86400 + 86400]])
                ->first();
            $amountd[$days]=$value->value;
        }
        foreach ($amountd as $item => $value){
            if ($value === null) {
                $amountd[$item] = 0;
            }
            $amountd[$item]=(int)$value;
        }
        return view('Index',['head'=>$head,'shops'=>$shops,'numbers'=>$numbers,'amounts'=>$amounts,'shopd'=>$shopd,'numberd'=>$numberd,'amountd'=>$amountd]);
    }
}
