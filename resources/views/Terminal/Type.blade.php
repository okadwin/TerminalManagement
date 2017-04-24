@extends('layout.base')
@section('title')
    终端型号管理
@endsection
@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;终端型号管理</span>
    </div>
    <div class="content">
        <div class="topBox">
            <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('TerminalController@TypeSelect')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">终端厂商名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Manufacture" value="{{request()->input('Manufacture')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">终端设备型号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Type" value="{{request()->input('Type')}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">查询</button>
                        <a href="{{action('TerminalController@TypeAdd')}}" class="btn btn-default">新增</a>
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
                        <th>终端设备售价</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($types as $type)
                    <tr>
                        <td>{{$type->Manufacture}}</td>
                        <td>{{$type->Type}}</td>
                        <td>{{$type->Price}}</td>
                        <td>{{date('Y-m-d H:i:s',$type->Time)}}</td>
                        <td><a href="{{action('TerminalController@TypeEdit',['id'=>$type->id])}}">编辑</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <nav aria-label="Page navigation">
                {{$types->links()}}
            </nav>
        </div>
    </div>
</div>
@endsection