@extends('layout.base')
@section('title')
    交易记录
@endsection

@section('main')

    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;交易查询</span>
        </div>
        <div class="content">
            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('TransactionController@TransactionList')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">商户编号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ShopNumber" value="{{request()->input('ShopNumber')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">商户名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ShopName" value="{{request()->input('ShopName')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">所属代理商</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Agent">
                                <option value="">请选择代理商</option>
                                @foreach($agents as $agent)
                                    <option value="{{$agent->id}}" @if(!empty(request()->input('Agent'))) @if(request()->input('Agent')==$agent->id) selected="selected" @endif @endif>{{$agent->AgentName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">交易日期</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="TimeStart" value="{{request()->input('TimeStart')}}">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="TimeStop" value="{{request()->input('TimeStop')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="TerminalNumber" value="{{request()->input('TerminalNumber')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">查询</button>
                            <button type="submit" class="btn btn-primary" name="button" value="export">导出</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="proList">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>商户编号</th>
                            <th>商户名称</th>
                            <th>终端号</th>
                            <th>所属代理商</th>
                            <th>卡号</th>
                            <th>交易金额</th>
                            <th>清算金额</th>
                            <th>手续费</th>
                            <th>交易日期</th>
                            <th>交易时间</th>
                            <th>交易类型</th>
                            <th>清算类型</th>
                            <th>易联众分润</th>
                        </tr>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->ShopNumber}}</td>
                            <td>{{@$transaction->Shop->ShopName}}</td>
                            <td>{{$transaction->TerminalNumber}}</td>
                            <td>{{@$transaction->Shop->Agent->AgentName}}</td>
                            <td>{{$transaction->BankAccountNumber}}</td>
                            <td>{{$transaction->TransactionAmount}}</td>
                            <td>{{$transaction->SettleAmount}}</td>
                            <td>{{$transaction->Fee}}</td>
                            <td>{{date('Y-m-d',$transaction->TransactionTime)}}</td>
                            <td>{{date('H:i:s',$transaction->TransactionTime)}}</td>
                            <td>{{$transaction->TransactionName}}</td>
                            <td>{{$transaction->SettleName}}</td>
                            <td>{{$transaction->Fee * 0.75 * ((100 - @$transaction->Shop->Agent->Profit) / 100)}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <nav aria-label="Page navigation">
                    {{--{{$transactions->links()}}--}}
                    {!!$paginate->links()!!}
                </nav>
            </div>
        </div>
    </div>
@endsection