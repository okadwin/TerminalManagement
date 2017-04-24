@extends('layout.base')
@section('title')
    终端出库
@endsection

@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;终端列表 - 出库</span>
        </div>
        <div class="content">
            <div class="textBox">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <span class="text else">当日出库终端数量：<span>@foreach($number as $n) {{$n->value}} @endforeach</span></span>
                    </div>
                </div>
            </div>

            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" method="post" action="{{action('TerminalController@TerminalOut')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端厂商名称</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Manufacture" id="manufacturers">
                                <option value="">全部</option>
                                @foreach($types as $type)
                                    <option value="{{$type->Manufacture}}" @if(!empty(request()->input('Manufacture'))) @if(request()->input('Manufacture')==$type->Manufacture) selected="selected" @endif @endif>{{$type->Manufacture}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端设备型号</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Type" id="equipment">
                                <option>全部</option>
                                @foreach($types as $type)
                                    @if(!empty(request()->input('Type'))) @if(request()->input('Type')==$type->id)<option value="{{$type->id}}" selected="selected">{{$type->Type}}</option>@endif @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端S/N码</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="SN" id="snCode" value="{{request()->input('SN')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">出库时间</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="OutStartTime" value="{{request()->input('OutStartTime')}}">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="OutStopTime" value="{{request()->input('OutStopTime')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">查询</button>
                            <a href="#addPopup" class="btn btn-default" data-toggle="modal">出库</a>
                            <button type="submit" class="btn btn-primary" name="button" value="export">导出</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="proList">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>终端厂商名称</th>
                            <th>终端设备型号</th>
                            <th>终端设备S/N码</th>
                            <th>商户号</th>
                            <th>终端号</th>
                            <th>渠道名称</th>
                            <th>出库类型</th>
                            <th>库存地点</th>
                            <th>出库时间</th>
                            <th>出库人员</th>
                            <th>操作</th>
                        </tr>
                        @foreach($terminals as $terminal)
                        <tr>
                            <td>{{$terminal->TerminalType->Manufacture}}</td>
                            <td>{{$terminal->TerminalType->Type}}</td>
                            <td>{{$terminal->SN}}</td>
                            <td>{{$terminal->ShopNumber}}</td>
                            <td>{{$terminal->TerminalNumber}}</td>
                            <td>{{@$terminal->ChannelName->Name}}</td>
                            <td>{{$terminal->OutTypeName}}</td>
                            <td>{{$terminal->Location}}</td>
                            <td>{{date('Y-m-d H:i:s',$terminal->OutTime)}}</td>
                            <td>{{$terminal->User->UserInfo->name}}</td>
                            <td><a href="{{action('TerminalController@TerminalOutEdit',['id'=>$terminal->id])}}">编辑</a></td>
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


    <!--新增出库 begin-->
    <div class="modal fade" tabindex="-1" role="dialog" id="addPopup">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">终端列表 - 出库</h4>
                </div>
                <form class="form-horizontal" action="{{action('TerminalController@TerminalOutAdd')}}" method="post" id="commentForm">
                    {{ csrf_field() }}
                    <div class="modal-body pb0">

                        <div class="alert alert-danger" role="alert">
                            <span class="alert-link">1、如S/N码查询结果为已入库，可以进行出库操作</span>
                            <br />
                            <span class="alert-link">2、如S/N码查询结果为已出库，不能进行出库操作</span>
                            <br />
                            <span class="alert-link">3、如S/N码查询结果为不存在，不能进行出库操作</span>
                            <br />
                            <br>
                            <span class="alert-link">****************************注意****************************</span>
                            <br />
                            <span class="alert-link">终端S/N码和终端号码务必反复确认，一经出库，禁止修改！！！</span>
                            <br>
                            <span class="alert-link">************************************************************</span>
                            <br />
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="color: darkred">终端S/N码</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="SN" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">商户号</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ShopNumber" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="color: darkred">终端号 </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="TerminalNumber" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">渠道</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="Channel" required>
                                    @foreach($channels as $channel)
                                    <option value="{{$channel->id}}">{{$channel->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">出库类型</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="OutType" required>
                                    <option value="1">免投</option>
                                    <option value="2">自购</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        {{--<button type="button" class="btn btn-default">查询</button>--}}
                        <button type="submit" class="btn btn-primary">出库</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--新增出库 end-->



    <script>

        $(function(){
            //联动
            $("#manufacturers").on("change",function(){
                var val = $(this).val();
                $.ajax({
                    type:"get",
                    url:"{{action('TerminalController@API')}}",
                    data:{
                        Manufacture:val
                    },
                    dataType:"json",
                    success:function(res){
                        var html='<option value="">全部</option>';
                        var len = res.length;
                        for ( var i = 0; i<len; i++ ){
                            html = html + '<option value="'+ res[i].id +'">'+ res[i].Type +'</option>'
                        }
                        $("#equipment").empty();
                        $("#equipment").append(html)
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.readyState);
                        console.log(errorThrown);
                    }
                })
            })

        })
    </script>
    <script>
        $().ready(function() {
            $("#commentForm").validate();
        });
    </script>
@endsection