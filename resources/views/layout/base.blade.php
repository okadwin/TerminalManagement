<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！-->
    <title>@yield('title') - 易联众线下终端交易管理平台</title>
    <link rel="stylesheet" href="{{elixir('go/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{elixir('go/css/jquery.datetimepicker.css')}}">
    <link rel="stylesheet" href="{{elixir('go/css/style.css')}}"/>
    <script src="{{elixir('go/js/jquery-2.1.1.min.js')}}"></script>
    <script src="{{elixir('go/js/bootstrap.min.js')}}"></script>
</head>
<body>
<?php
function toa($action){
    $uri=Request::path();
    if (strpos($uri,$action)!==false){
        if ($action == 'Agent'){
            if (strpos($uri,'Profit')!==false){
                return false;
            }
        }
        return true;
    }else{
        return false;
    }
}
?>
<div class="whole">
    <div class="header">
        <div class="titBox">
            <h2 class="title">易联众线下终端管理平台</h2>
        </div>
        <div class="userBox">
            <a href="{{action('UserController@Logout')}}" class="exitBtn">退出<i class="iconFont">&#xe66e;</i></a>
            <span class="name"><i class="iconFont">&#xe604;</i>{{$globalUser->email}}</span>
        </div>
    </div>

    <div class="leftNav">
        <ul class="list">
            <li><a href="/" class="lineBtn"><i class="iconFont left">&#xe635;</i>主页</a></li>
            <li @if(toa('Agent')) class="active" @endif><a href="{{action('AgentController@AgentIndex')}}" class="lineBtn"><i class="iconFont left">&#xe610;</i>代理商管理</a></li>
            <li @if(toa('Shop')) class="active" @endif><a href="{{action('ShopController@ShopIndex')}}" class="lineBtn"><i class="iconFont left">&#xe609;</i>商户管理</a></li>
            <li><!--   @if(toa('Terminal')) class="active" @endif  -->
                <a href="javascript:;" class="lineBtn show"><i class="iconFont left">&#xe607;</i>终端管理<i class="iconFont right">&#xe60d;</i></a>
                <div class="hiddenBox">
                    <a href="{{action('TerminalController@Type')}}" @if(toa('TerminalType')) class="active" @endif>终端型号管理</a>
                    <a href="{{action('TerminalController@TerminalList')}}" @if(toa('TerminalList')) class="active" @endif>终端列表</a>
                    <a href="{{action('TerminalController@TerminalIn')}}" @if(toa('TerminalIn')) class="active" @endif>终端入库</a>
                    <a href="{{action('TerminalController@TerminalOut')}}" @if(toa('TerminalOut')) class="active" @endif>终端出库</a>
                </div>
            </li>
            <li>
                <a href="javascript:;" class="lineBtn show"><i class="iconFont left">&#xe66f;</i>交易管理<i class="iconFont right">&#xe60d;</i></a>
                <div class="hiddenBox">
                    <a href="{{action('ChannelController@Index')}}" @if(toa('Channel')) class="active" @endif>渠道配置</a>
                    <a href="{{action('TransactionController@TransactionList')}}" @if(toa('TransactionList')) class="active" @endif>交易查询</a>
                    <a href="{{action('TransactionController@Into')}}" @if(toa('TransactionInto')) class="active" @endif>交易导入</a>
                </div>
            </li>
            <li>
                <a href="javascript:;" class="lineBtn show"><i class="iconFont left">&#xe614;</i>分润管理<i class="iconFont right">&#xe60d;</i></a>
                <div class="hiddenBox">
                    <a href="{{action('ProfitController@Ylz')}}" @if(toa('ProfitYlz')) class="active" @endif>易联众分润</a>
                    <a href="{{action('ProfitController@Agent')}}" @if(toa('ProfitAgent')) class="active" @endif>代理商分润</a>
                </div>
            </li>
            <li>
                <a href="javascript:;" class="lineBtn show"><i class="iconFont left">&#xe669;</i>报表管理<i
                            class="iconFont right">&#xe60d;</i></a>
                <div class="hiddenBox">
                    <a href="{{action('ReportController@Terminal')}}" @if(toa('ReportTerminal')) class="active" @endif>终端交易报表</a>
                    <a href="{{action('ReportController@Zero')}}" @if(toa('ReportZero')) class="active" @endif>无交易终端报表</a>
                </div>
            </li>
            <li>
                <a href="{{action('UserController@Index')}}" class="lineBtn"><i class="iconFont left">&#xe722;</i>用户管理</a>
            </li>
        </ul>
    </div>
    @yield('main')
</div>


<script src="{{elixir('go/js/jquery.datetimepicker.js')}}"></script>
<script src="{{elixir('go/js/leftNav.js')}}"></script>
<script src="{{elixir('go/js/time.js')}}"></script>
</body>
</html>