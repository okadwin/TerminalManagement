@extends('layout.base')

@section('title')
    代理商管理
@endsection

@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;代理商管理</span>
    </div>
    <div class="content">
        <div class="topBox">
            <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('AgentController@AgentSelect')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">代理商名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="AgentName">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">查询</button>
                        <a href="{{action('AgentController@AgentAddView')}}" class="btn btn-default">新增</a>
                        {{--<a href="javascript:;" class="btn btn-default" id="" name="button" value="export">导出</a>--}}
                        <button type="submit" class="btn btn-primary"  id="" name="button" value="export">导出</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="proList">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th>代理商编号</th>
                        <th>代理商名称</th>
                        <th>法人</th>
                        <th>联系人</th>
                        <th>联系电话</th>
                        <th>身份证号</th>
                        <th>账户号</th>
                        <th>账户名</th>
                        <th>开户行</th>
                        <th>联行号</th>
                        <th>分润费率</th>
                        <th>操作</th>
                    </tr>
                    @foreach($agents as $agent)
                    <tr>
                        <td>{{$agent->id}}</td>
                        <td>{{$agent->AgentName}}</td>
                        <td>{{$agent->Person}}</td>
                        <td>{{$agent->cPerson}}</td>
                        <td>{{$agent->cPhone}}</td>
                        <td>{{$agent->IDcard}}</td>
                        <td>{{$agent->BankAccountNum}}</td>
                        <td>{{$agent->BankAccountName}}</td>
                        <td>{{$agent->BankName}}</td>
                        <td>{{$agent->BankNum}}</td>
                        <td>{{$agent->Profit}}%</td>
                        <td><a href="{{url('AgentEdit',[ 'id' => $agent -> id ] ) }}">编辑</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <nav aria-label="Page navigation">
                {{ $agents->links() }}
            </nav>
        </div>
    </div>
</div>


<script>
    $(function () {
        var parseParam=function(param, key){
            var paramStr="";
            if(param instanceof String||param instanceof Number||param instanceof Boolean){
                paramStr+="&"+key+"="+encodeURIComponent(param);
            }else{
                $.each(param,function(i){
                    var k=key==null?i:key+(param instanceof Array?"["+i+"]":"."+i);
                    paramStr+='&'+parseParam(this, k);
                });
            }
            return paramStr.substr(1);
        };
        $('#export').click(function () {
            var where = @if(@$where){!! json_encode($where) !!}@else '' @endif ;
//            var where = {"a":1,"b":2};
            $("#export").attr('disabled','disabled')
            url = '{{action('AgentController@AgentExport')}}'
            console.log(url);
            window.location.href=url + parseParam(where);
            /*$.ajax({
                type:"get",
                url: '{{action("AgentController@AgentExport")}}',
                data:{where:where},
                //dataType:"json",
                success:function(res){
                    //window.location.href=url;
                    $("#export").removeAttr('disabled');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("error!");
                    $("#export").removeAttr('disabled');
                    console.log(XMLHttpRequest.status);
                    console.log(XMLHttpRequest.readyState);
                    console.log(errorThrown);
                }
            })*/
        })
    })
</script>
@endsection