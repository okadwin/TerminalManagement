@extends('layout.base')
@section('title')
    代理商管理
@endsection
@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="{{url('Agent')}}">代理商管理</a> - 新增</span>
    </div>
    <div class="content">
        <div class="formBox">
            <form class="form-horizontal" action="{{url('AgentAdd')}}" method="post">
                {{ csrf_field() }}
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <!--
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">代理商编号</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    -->
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">代理商名称</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="AgentName">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">法人</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="Person">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系人</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="cPerson">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">身份证号</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="IDcard">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系电话</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="cPhone">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">银行账户</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="BankAccountNum">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">开户名</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="BankAccountName">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">开户行</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="BankName">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 form-group">
                    <label class="col-md-2 col-lg-4 control-label">联行号</label>
                    <div class="col-md-10 col-lg-8">
                        <input type="text" class="form-control" name="BankNum">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 form-group">
                    <label class="col-md-2 col-lg-4 control-label">分润率(%)</label>
                    <div class="col-md-10 col-lg-8">
                        <input type="text" class="form-control" name="Profit">
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <div class="col-md-offset-2 col-md-10 col-lg-offset-4 col-lg-8">
                            <button type="submit" class="btn btn-primary">提交</button>
                            <a href="{{url('Agent')}}" class="btn btn-default">取消</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection