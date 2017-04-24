@extends('layout.base')
@section('title')
    渠道管理
@endsection


@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;渠道配置</span>
    </div>
    <div class="content">
        <div class="topBox">
            <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('ChannelController@Select')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">渠道名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Name" value="{{request()->input('Name')}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">查询</button>
                        <a href="{{action('ChannelController@AddView')}}" class="btn btn-default">新增</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="proList">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>
                        {{--<th>渠道编号</th>--}}
                        <th>渠道名称</th>
                        <th>联系人</th>
                        <th>联系电话</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($channels as $channel)
                    <tr>
                        {{--<td>1</td>--}}
                        <td>{{$channel->Name}}</td>
                        <td>{{$channel->Contact}}</td>
                        <td>{{$channel->ContactPhone}}</td>
                        <td>{{date('Y-m-d H:i:s',$channel->CreateTime)}}</td>
                        <td><a href="{{action('ChannelController@Edit',['id'=>$channel->id])}}">编辑</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <nav aria-label="Page navigation">
                {{$channels->links()}}
            </nav>
        </div>
    </div>
</div>
@endsection