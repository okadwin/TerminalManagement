@extends('layout.base')
@section('title')
    终端交易报表
@endsection

@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;终端交易报表</span>
        </div>
        <div class="content">
            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('ReportController@Terminal')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="TerminalNumber">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">交易日期</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="start">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="low" value="1">低于终端售价
                                </label>
                            </div>
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
                            {{--<th>交易日期</th>--}}
                            <th>总交易笔数</th>
                            <th>总交易金额</th>
                            <th>易联众总分润金额</th>
                            <th>代理商总分润金额</th>
                        </tr>

                        @foreach($r as $item)
                            {{--{{print_r($r)}}--}}
                        <tr>
                            <td>{{$item['TerminalNumber']}}</td>
                            <td>{{$item['ShopNumber']}}</td>
                            {{--<td>2017-04-05</td>--}}
                            <td>{{$item['Number']}}</td>
                            <td>{{$item['Amount']}}</td>
                            <td>{{$item['ProfitY']}}</td>
                            <td>{{$item['ProfitA']}}</td>
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