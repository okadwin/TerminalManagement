@extends('layout.base')
@section('title')
    交易导入
@endsection

@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;交易导入</span>
        </div>
        <div class="content">
            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">渠道名称</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="ChannelSearch">
                                <option value="">全部</option>
                                @foreach($channels as $channel)
                                    <option value="{{$channel->id}}" @if(!empty(request()->input('ChannelSearch'))) @if(request()->input('ChannelSearch')==$channel->id) selected="selected" @endif @endif>{{$channel->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">查询</button>
                            <a href="#addPopup" class="btn btn-default" data-toggle="modal">导入</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="proList">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>渠道编号</th>
                            <th>渠道名称</th>
                            <th>导入条数</th>
                            <th>导入时间</th>
                            <th>导入人员</th>
                        </tr>
                        @foreach($transactions_into as $into)
                        <tr>
                            <td>{{$into->Channel}}</td>
                            <td>{{$into->ChannelName->Name}}</td>
                            <td>{{$into->Number}}</td>
                            <td>{{date('Y-m-d H:i:s',$into->Time)}}</td>
                            <td>{{$into->UserName->UserInfo->name}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <nav aria-label="Page navigation">
                    {{$transactions_into->links()}}
                </nav>
            </div>
        </div>
    </div>

    <!--导入 begin-->
    <div class="modal fade" tabindex="-1" role="dialog" id="addPopup">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">交易导入</h4>
                </div>
                <form class="form-horizontal" action="{{action('TransactionController@Into')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body pb0">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">渠道名称</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="channel">
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}">{{$channel->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">交易导入</label>
                            <div class="col-sm-9 pt4">
                                <input type="file" name="transaction" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, .csv">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        {{--<button type="button" class="btn btn-primary" data-dismiss="modal">保存</button>--}}
                        <button type="submit" class="btn btn-primary" id="submitBtn">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--导入 end-->


    <div class="popupBg"></div>

    <script>
        $(function(){
            $("#submitBtn").on("click",function(){
                $(".popupBg").show()
            })
        })
    </script>
@endsection