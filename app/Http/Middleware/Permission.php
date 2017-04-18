<?php

namespace App\Http\Middleware;

use Closure,Response,Sentinel;

class Permission
{
    protected $permission = [
        '/'                     =>null,
        'API'=>null,
        'Agent*'=>'agent',
        'Shop*'=>'shop',
        'TerminalType*'=>'terminal.type',
        'TerminalList'=>'terminal.list',
        'TerminalIn*'=>'terminal.in',
        'TerminalOut*'=>'terminal.out',
        'Channel*'=>'channel',
        'TransactionList'=>'transaction.list',
        'TransactionInto'=>'transaction.in',
        'ProfitYlz'=>'profit.ylz',
        'ProfitAgent'=>'profit.agent',
        'ReportTerminal'=>'report.terminal',
        'ReportZero'=>'report.zero',
        'User*'=>'user'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->hasAccess($request)){
            return $next($request);
        }else{
//            return Response::view('backend.unauthorized',[
//                'nav' => 0,
//                'sub_nav' => 0
//            ]);
            return Response::view('ErrorAlert', ['err_info' => '无权限查看此页！']);
        }
    }
    protected function hasAccess($request)
    {
        foreach ($this->permission as $item => $value) {
            if ($item !== '/') {
                $item = trim($item, '/');
            }
            if ($request->is($item)) {
                if ($value !== null){
                    if (Sentinel::hasAnyAccess($value))
                    {
                        return true;
                    }
                }else{
                    return true;
                }
            }/*elseif(Sentinel::hasAccess('*')){
                print_r('11111111111');
                return true;
            }*/
        }
        return false;
    }
}
