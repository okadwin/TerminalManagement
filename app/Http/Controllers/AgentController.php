<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Agent;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//use PhpParser\Node\Expr\New_;

class AgentController extends Controller {
    //
    public function AgentIndex() {
        $a=10/0;
        $agents = Agent::paginate();
        return view('Agent.AgentIndex', ['agents' => $agents]);
    }



    public function AgentSelect(Request $request) {
        //todo:翻页方式是GET，翻页后可能无法带有查询条件，可以改成GET传递查询条件即可
        $AgentName=trim($request->input('AgentName'));
        $agents = Agent::where('AgentName','like','%'.$AgentName.'%')
            ->paginate();
        if ($request->has('button') && $request->get('button')=='export'){
            Excel::create('Agent', function ($excel) use ($agents) {
                $excel->sheet('Agents', function ($sheet) use ($agents){

                    foreach ($agents as $index=>$item) {
//                        if($index == 0 ){ //排除标题row
//                            continue;
//                        }
                        $array[]=[
                            '代理商编号'=>$item['id'],
                            '代理商名称'=>$item['AgentName'],
                            '法人'=>$item['Person'],
                            '联系人'=>$item['cPerson'],
                            '联系电话'=>$item['cPhone'],
                            '身份证号'=>$item['IDcard'],
                            '账户号'=>$item['BankAccountNum'],
                            '账户名'=>$item['BankAccountName'],
                            '开户行'=>$item['BankName'],
                            '联行号'=>$item['BankNum'],
                            '分润利率'=>$item['Profit']
                        ];
                    }
                    $sheet->fromArray($array);
                    $sheet->setAutoSize(true);
                    $sheet->setAutoFilter();
                });
            })->export('xlsx');
        }
        return view('Agent.AgentIndex', ['agents' => $agents,'where'=>['AgentName','like','%'.$AgentName.'%']]);
    }

    public function AgentEdit($id) {
        $agent=Agent::find($id);
        return view('Agent.AgentEdit',['agent'=>$agent]);
    }

    public function AgentUpdate(Request $request,$id){
        $agent=Agent::find($id);
        $agent->AgentName = $request->input('AgentName');
        $agent->Person = $request->input('Person');
        $agent->cPerson = $request->input('cPerson');
        $agent->cPhone = $request->input('cPhone');
        $agent->IDcard = $request->input('IDcard');
        $agent->BankAccountNum = $request->input('BankAccountNum');
        $agent->BankAccountName = $request->input('BankAccountName');
        $agent->BankName = $request->input('BankName');
        $agent->BankNum = $request->input('BankNum');
        $agent->Profit = $request->input('Profit');
        $agent->save();
        return view('ErrorAlert', ['err_info' => '修改成功！']);
    }

    public function AgentAddView() {
        return view('Agent.AgentAdd');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AgentAdd(Request $request) {
        $agent=new Agent;
        $agent->AgentName = $request->input('AgentName');
        $agent->Person = $request->input('Person');
        $agent->cPerson = $request->input('cPerson');
        $agent->cPhone = $request->input('cPhone');
        $agent->IDcard = $request->input('IDcard');
        $agent->BankAccountNum = $request->input('BankAccountNum');
        $agent->BankAccountName = $request->input('BankAccountName');
        $agent->BankName = $request->input('BankName');
        $agent->BankNum = $request->input('BankNum');
        $agent->Profit = $request->input('Profit');
        $agent->save();
        //todo:数据格式验证没做，或者就前端验证一下就得了？
        //DB::table('agents')->insertGetId(['AgentName' => $AgentName, 'Person' => $Person, 'cPerson' => $cPerson, 'cPhone' => $cPhone, 'IDcard' => $IDcard, 'BankAccountNum' => $BankAccountName, 'BankAccountName' => $BankAccountNum, 'BankName' => $BankName, 'BankNum' => $BankNum, 'Profit' => $Profit]);
        return view('ErrorAlert', ['err_info' => '添加成功！']);
    }
}
