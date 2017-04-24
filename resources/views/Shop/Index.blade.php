@extends('layout.base')
@section('title')
    商户管理
@endsection
@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;商户管理</span>
    </div>
    <div class="content">
        <div class="topBox">
            <form class="form-horizontal col-sm-10 col-md-10 col-lg-8 search" action="{{action('ShopController@ShopSelect')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">商户编号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ShopNumber" value="{{request()->input('ShopNumber')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商户名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ShopName" value="{{request()->input('ShopName')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">所属代理商</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="ShopAgent">
                            <option value="">请选择代理商</option>
                            @foreach($agents as $agent)
                                <option value="{{$agent->id}}" @if(!empty(request()->input('ShopAgent'))) @if(request()->input('ShopAgent')==$agent->id) selected="selected" @endif @endif>{{$agent->AgentName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">入网时间</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control datetimepicker" name="ShopTimeStart" value="{{request()->input('ShopTimeStart')}}">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control datetimepicker" name="ShopTimeStop" value="{{request()->input('ShopTimeStop')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商户状态</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="ShopStatus">
                            <option value="">全部</option>
                            <option value="1" @if(!empty(request()->input('ShopStatus'))) @if(request()->input('ShopStatus')==1) selected="selected" @endif @endif>已上线</option>
                            <option value="2" @if(!empty(request()->input('ShopStatus'))) @if(request()->input('ShopStatus')==2) selected="selected" @endif @endif>已禁用</option>
                            <option value="0" @if(!empty(request()->input('ShopStatus'))) @if(request()->input('ShopStatus')===0) selected="selected" @endif @endif>已注销</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">查询</button>
                        <a href="{{action('ShopController@ShopAddView')}}" class="btn btn-default">入网</a>
                        {{--<a href="javascript:;" class="btn btn-default">导出</a>--}}
                        <button type="submit" class="btn btn-primary" name="button" value="export">导出</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="proList">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th>商户编号</th>
                        <th>商户名称</th>
                        <th>所属代理商</th>
                        <th>联系人</th>
                        <th>联系电话</th>
                        <th>入网时间</th>
                        <th>商户状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($shops as $shop)
                    <tr>
                        <td>{{$shop->ShopNumber}}</td>
                        <td>{{$shop->ShopName}}</td>
                        <td>{{$shop->Agent->AgentName}}</td>
                        <td>{{$shop->ShopContact}}</td>
                        <td>{{$shop->ShopContactPhone}}</td>
                        <td>{{date('Y-m-d H:i:s',$shop->ShopJoinTime)}}</td>
                        <td>{{$shop->Status}}</td>
                        <td><a href="{{action('ShopController@ShopEdit',[ 'id' => $shop -> id ] )}}">编辑</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <nav aria-label="Page navigation">
                {{$shops->links()}}
            </nav>
        </div>
    </div>
</div>
@endsection