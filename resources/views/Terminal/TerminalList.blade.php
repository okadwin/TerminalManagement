@extends('layout.base')
@section('title')
    终端列表
@endsection

@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;终端列表</span>
        </div>
        <div class="content">
            <div class="textBox">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <span class="text">终端设备总数量：<span>8888</span></span>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <span class="text">库存终端总数量：<span>8888</span></span>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <span class="text">出库终端总数量：<span>8888</span></span>
                    </div>
                </div>
            </div>

            <div class="topBox">
                <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" method="post" action="{{action('TerminalController@TerminalListSelect')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端厂商名称</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="manufacturers" name="Manufacture">
                                <option value="">全部</option>
                                @foreach($types as $type)
                                    <option value="{{$type->Manufacture}}">{{$type->Manufacture}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端设备型号</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="equipment" name="Type">
                                <option value="">全部</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端S/N码</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="SN">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">终端状态</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Status">
                                <option value="">全部</option>
                                <option value="1">已入库</option>
                                <option value="2">已出库</option>
                            </select>
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
                            <th>终端厂商名称</th>
                            <th>终端设备型号</th>
                            <th>终端设备S/N码</th>
                            <th>终端状态</th>
                            <th>库存地点</th>
                        </tr>
                        @foreach($terminals as $terminal)
                        <tr>
                            <td>{{$terminal->TerminalType->Manufacture}}</td>
                            <td>{{$terminal->TerminalType->Type}}</td>
                            <td>{{$terminal->SN}}</td>
                            <td>@if($terminal->OutTime > 0)已出库 @else 已入库 @endif</td>
                            <td>{{$terminal->Location}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <nav aria-label="Page navigation">
                    @if(@!$wtf){{$terminals->links()}}@endif
                </nav>
            </div>
        </div>
    </div>


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
@endsection