@extends('layout.base')
@section('title')
    添加商户
@endsection


@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="{{action('ShopController@ShopIndex')}}">商户管理</a> - 新增</span>
    </div>
    <div class="content">
        <div class="formBox">
            <form class="form-horizontal" action="{{action('ShopController@ShopAdd')}}" method="post">
                {{ csrf_field() }}
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">所属代理商</label>
                        <div class="col-md-10 col-lg-8">
                            <select class="form-control" name="ShopAgent">
                                <option>请选择所属代理商</option>
                                @foreach($agents as $agent)
                                    <option value="{{$agent->id}}">{{$agent->AgentName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">商户编号</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="ShopNumber">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">商户名称</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="ShopName">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系人</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="ShopContact">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系电话</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="ShopContactPhone">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">身份证号</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="ShopContactID">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="ShopStatus" value="1">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <div class="col-md-offset-2 col-md-10 col-lg-offset-4 col-lg-8">
                            <button type="submit" class="btn btn-primary">提交</button>
                            <a href="{{action('ShopController@ShopIndex')}}" class="btn btn-default">取消</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection