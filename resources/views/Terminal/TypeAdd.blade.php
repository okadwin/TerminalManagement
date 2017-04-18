@extends('layout.base')
@section('title')
    新增终端型号
@endsection
@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="{{action('TerminalController@Type')}}">终端型号管理</a> - 新增</span>
    </div>
    <div class="content">
        <div class="formBox">
            <form class="form-horizontal" action="{{isset($type) ? action('TerminalController@TypeUpdate',['id'=>$type->id]) : action('TerminalController@TypeAdd')}}" method="post">
                {{ csrf_field() }}
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">终端厂商名称</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="Manufacture" value="{{isset($type->Manufacture) ? $type->Manufacture : ''}}">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">终端设备型号</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="Type" value="{{isset($type->Type) ? $type->Type : ''}}">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">终端设备售价</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="Price" value="{{isset($type->Price) ? $type->Price : ''}}">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <div class="col-md-offset-2 col-md-10 col-lg-offset-4 col-lg-8">
                            <button type="submit" class="btn btn-primary">提交</button>
                            <a href="{{action('TerminalController@Type')}}" class="btn btn-default">取消</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection