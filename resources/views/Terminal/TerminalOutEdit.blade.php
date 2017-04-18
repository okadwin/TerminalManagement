@extends('layout.base')
@section('title')
    编辑出库信息
@endsection


@section('main')
    <div class="main">
        <div class="location">
            <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="{{action('TerminalController@TerminalOut')}}">终端出库</a> - 编辑</span>
        </div>
        <div class="content">
            <div class="formBox">
                <form class="form-horizontal" action="{{action('TerminalController@TerminalOutUpdate',['id'=>$terminal->id])}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">终端S/N码</label>
                            <div class="col-md-10 col-lg-8">
                                <input type="text" class="form-control" name="SN" value="{{$terminal->SN}}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">商户号</label>
                            <div class="col-md-10 col-lg-8">
                                <input type="text" class="form-control" name="ShopNumber" value="{{$terminal->ShopNumber}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">渠道</label>
                            <div class="col-md-10 col-lg-8">
                                <select class="form-control" name="Channel" id="equipment">
                                    {{--<option>请选择厂商</option>--}}
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" @if($channel->id == $terminal->Channel) selected="selected" @endif>{{$channel->Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">终端号</label>
                            <div class="col-md-10 col-lg-8">
                                <input type="text" class="form-control" name="TerminalNumber" value="{{$terminal->TerminalNumber}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-6 form-group">
                            <label class="col-md-2 col-lg-4 control-label">出库类型</label>
                            <div class="col-md-10 col-lg-8">
                                <select class="form-control" name="OutType" id="equipment">
                                    {{--<option>请选择厂商</option>--}}
                                    <option value="1" @if($terminal->OutType == 1) selected="selected" @endif>免投</option>
                                    <option value="2" @if($terminal->OutType == 2) selected="selected" @endif>自购</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="ShopStatus" value="1">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="col-md-12 col-lg-6 form-group">
                            <div class="col-md-offset-2 col-md-10 col-lg-offset-4 col-lg-8">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <a href="{{action('TerminalController@TerminalOut')}}" class="btn btn-default">取消</a>
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