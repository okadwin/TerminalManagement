@extends('layout.base')
@section('title')
    代理商分润
@endsection

@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;代理商分润</span>
        </div>
        <div class="content">
            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('ProfitController@Agent')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">代理商名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="agent" value="{{request()->input('agent')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">交易日期</label>
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
                            <th>交易日期</th>
                            <th>代理商名称</th>
                            <th>总交易笔数</th>
                            <th>总交易金额</th>
                            <th>总分润金额</th>
                        </tr>
                        @foreach($profits as $profit)
                            {{--{{print_r($profit)}}--}}
                        <tr>
                            <td>{{$profit['date']}}</td>
                            <td>{{$profit['AgentName']}}</td>
                            <td>{{$profit['number']}}</td>
                            <td>{{$profit['amount']}}</td>
                            <td>{{$profit['profit']}}</td>
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