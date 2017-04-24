@extends('layout.base')
@section('title')
    终端入库
@endsection

@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;终端列表 - 入库</span>
        </div>
        <div class="content">
            <div class="textBox">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <span class="text else">当日入库终端数量：<span>@foreach($number as $n) {{$n->value}} @endforeach</span></span>
                    </div>
                </div>
            </div>

            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('TerminalController@TerminalIn')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端厂商名称</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="manufacturers" name="Manufacture">
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
                            <select class="form-control" id="equipment" name="type">
                                <option value="">全部</option>
                                @foreach($types as $type)
                                    @if(!empty(request()->input('type'))) @if(request()->input('type')==$type->id)<option value="{{$type->id}}" selected="selected">{{$type->Type}}</option>@endif @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端S/N码</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="snCode" name="sn" value="{{request()->input('sn')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">库存地点</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="location" value="{{request()->input('location')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">入库时间</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="InTimeStart" value="{{request()->input('InTimeStart')}}">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control datetimepicker" name="InTimeStop" value="{{request()->input('InTimeStop')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">查询</button>
                            <button type="button" class="btn btn-default" id="storageBtn">入库</button>
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
                            <th>库存地点</th>
                            <th>入库时间</th>
                            <th>入库人员</th>
                            <th>操作</th>
                        </tr>

                        @foreach($terminals as $terminal)
                        <tr>
                            <td>{{$terminal->TerminalType->Manufacture}}</td>
                            <td>{{$terminal->TerminalType->Type}}</td>
                            <td>{{$terminal->SN}}</td>
                            <td>{{$terminal->Location}}</td>
                            <td>{{date('Y-m-d H:i:s',$terminal->InTime)}}</td>
                            <td>{{$terminal->User->UserInfo->name}}</td>
                            <td><a href="{{action('TerminalController@TerminalInEdit',['id'=>$terminal->id])}}">编辑</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <nav aria-label="Page navigation">
                    {{ $paginate->links() }}
                </nav>
            </div>
        </div>
    </div>



    <!--编辑入库 begin-->
    <div class="modal fade" tabindex="-1" role="dialog" id="editPopup">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">终端列表 - 入库编辑</h4>
                </div>
                <form class="form-horizontal">
                    <div class="modal-body pb0">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">终端厂商名称</label>
                            <div class="col-sm-9">
                                <select class="form-control">
                                    <option>全部</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">终端设备型号</label>
                            <div class="col-sm-9">
                                <select class="form-control">
                                    <option>全部</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">终端S/N码</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">库存地点</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--编辑入库 end-->


    <script>
//        $(function(){
//            $(".proList .table td a").on("click",function(){
//                $('#editPopup').modal()
//            })
//        })


/*
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
*/

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
                    }
                })
            })

            //入库
            $("#storageBtn").on("click",function(){
                var manufacturers = $("#manufacturers").val();    //终端厂商名称
                var equipment = $("#equipment").val();            //终端设备型号
                var snCode = $("#snCode").val();                  //终端S/N码
                var address = $("#address").val();                //库存地点
                var token = $("input[name=_token]").val();
                var url = '{{action('TerminalController@TerminalAdd')}}';

                $("#storageBtn").attr('disabled','disabled')

                console.log(token);
                $.ajax({
                    type:"post",
                    url:url,
                    data:{
                        _token:token,
                        manufacturers:manufacturers,
                        type:equipment,
                        SN:snCode,
                        location:address
                    },
                    //dataType:"json",
                    success:function(res){
                        //返回成功
                        //console.log('success');
                        console.log(res);
                        alert(res.msg);
                        $("#storageBtn").removeAttr('disabled');
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
@endsection