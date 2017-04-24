@extends('layout.base')
@section('title')
    无交易终端报表
@endsection
@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;无交易终端报表</span>
        </div>
        <div class="content">
            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('ReportController@Zero')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="TerminalNumber" value="{{request()->input('TerminalNumber')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">出库日期</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="start" value="{{request()->input('start')}}">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="stop" value="{{request()->input('stop')}}">
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
                            <th>终端号</th>
                            <th>商户号</th>
                            <th>出库日期</th>
                            <th>总交易笔数</th>
                            <th>总交易金额</th>
                            <th>易联众总分润金额</th>
                            <th>代理商总分润金额</th>
                        </tr>
                        @foreach($r as $item)
                        <tr>
                            <td>{{$item['TerminalNumber']}}</td>
                            <td>{{$item['ShopNumber']}}</td>
                            <td>{{$item['OutTime']}}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <nav aria-label="Page navigation">
                    {{$paginate->links()}}
                </nav>
            </div>
        </div>
    </div>
@endsection