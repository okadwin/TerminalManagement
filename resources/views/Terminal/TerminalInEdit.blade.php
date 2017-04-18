@extends('layout.base')
@section('title')
    编辑入库信息
@endsection


@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="{{action('TerminalController@TerminalIn')}}">终端入库</a> - 编辑</span>
        </div>
        <div class="content">
            <div class="formBox">
                <form class="form-horizontal" action="{{action('TerminalController@TerminalInUpdate',['id'=>$terminal->id])}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">终端S/N码</label>
                            <div class="col-md-10 col-lg-8">
                                <input type="text" class="form-control" name="SN" value="{{$terminal->SN}}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">库存地点</label>
                            <div class="col-md-10 col-lg-8">
                                <input type="text" class="form-control" name="location" value="{{$terminal->Location}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">终端厂商</label>
                            <div class="col-md-10 col-lg-8">
                                <select class="form-control" name="manufacture" id="manufacturers">
                                    {{--<option>请选择厂商</option>--}}
                                    @foreach($types as $type)
                                        <option value="{{$type->Manufacture}}"  @if($type->id == $terminal->Type) selected="selected" @endif>{{$type->Manufacture}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">终端型号</label>
                            <div class="col-md-10 col-lg-8">
                                <select class="form-control" name="type" id="equipment">
                                    {{--<option>请选择厂商</option>--}}
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}" @if($type->id == $terminal->Type) selected="selected" @endif>{{$type->Type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>




                    <input type="hidden" name="ShopStatus" value="1">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-6 form-group">
                            <div class="col-md-offset-2 col-md-10 col-lg-offset-4 col-lg-8">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <a href="{{action('TerminalController@TerminalIn')}}" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>



        $(function() {
            //联动
            $("#manufacturers").on("change", function () {
                var val = $(this).val();
                $.ajax({
                    type: "get",
                    url: "{{action('TerminalController@API')}}",
                    data: {
                        Manufacture: val
                    },
                    dataType: "json",
                    success: function (res) {
                        var html = '';
                        var len = res.length;
                        for (var i = 0; i < len; i++) {
                            html = html + '<option value="' + res[i].id + '">' + res[i].Type + '</option>'
                        }
                        $("#equipment").empty();
                        $("#equipment").append(html)
                    }
                })
            })
        })
    </script>


@endsection