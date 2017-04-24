@extends('layout.base')
@section('title')
    用户管理
@endsection

@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;用户管理</span>
    </div>
    <div class="content">
        <div class="topBox">
            <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('UserController@Select')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username"  value="{{request()->input('username')}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">查询</button>
                        <a href="{{action('UserController@AddView')}}" class="btn btn-default">新增</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="proList">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th>用户名</th>
                        <th>联系人</th>
                        <th>联系电话</th>
                        <th>邮箱</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->email}}</td>
                        <td>{{$user->UserInfo->name}}</td>
                        <td>{{$user->UserInfo->phone}}</td>
                        <td>{{$user->UserInfo->email}}</td>
                        <td>{{$user->created_at}}</td>
                        <td><a href="{{action('UserController@Edit',['id'=>$user->id])}}">编辑</a><!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{action('UserController@Delete',['id'=>$user->id])}}">删除</a>--></td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <nav aria-label="Page navigation">
                {{$users->links()}}
            </nav>
        </div>
    </div>
</div>
@endsection