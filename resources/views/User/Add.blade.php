@extends('layout.base')
@section('title')
用户管理
@endsection
@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="{{action('UserController@Index')}}">用户管理</a> </span>
    </div>
    <div class="content">
        <div class="formBox">
            <form class="form-horizontal" action="{{isset($user) ? action('UserController@Update',['id'=>$user->id]) : action('UserController@Add')}}" method="post" id="commentForm">
                {{ csrf_field() }}
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">用户名</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="username" value="{{isset($user->email) ? $user->email : ''}}" @if(isset($user)) readonly="readonly" @endif required>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">密码</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="password" class="form-control" name="password" value="" required>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系人</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="name" value="{{isset($user->UserInfo->name) ? $user->UserInfo->name : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系电话</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="phone" value="{{isset($user->UserInfo->phone) ? $user->UserInfo->phone : ''}}" required digits="true">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">邮箱</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="email" value="{{isset($user->UserInfo->email) ? $user->UserInfo->email : ''}}" required>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">权限分配</label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText">代理商管理</span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="agent"@if(isset($user)) @if($user->hasAccess('agent')) checked @endif @endif>代理商管理</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText">商户管理</span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="shop"@if(isset($user)) @if($user->hasAccess('shop')) checked @endif @endif>商户管理</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText">终端管理</span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="terminal.type"@if(isset($user)) @if($user->hasAccess('terminal.type')) checked @endif @endif>终端型号管理</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText"></span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="terminal.list"@if(isset($user)) @if($user->hasAccess('terminal.list')) checked @endif @endif>终端列表</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="terminal.in"@if(isset($user)) @if($user->hasAccess('terminal.in')) checked @endif @endif>终端入库</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="terminal.out"@if(isset($user)) @if($user->hasAccess('terminal.out')) checked @endif @endif>终端出库</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText">交易管理</span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="channel"@if(isset($user)) @if($user->hasAccess('channel')) checked @endif @endif>渠道配置</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText"></span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="transaction.list"@if(isset($user)) @if($user->hasAccess('transaction.list')) checked @endif @endif>交易查询</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="transaction.in"@if(isset($user)) @if($user->hasAccess('transaction.in')) checked @endif @endif>交易导入</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText">分润管理</span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="profit.ylz"@if(isset($user)) @if($user->hasAccess('profit.ylz')) checked @endif @endif>易联众分润</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText"></span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="profit.agent"@if(isset($user)) @if($user->hasAccess('profit.agent')) checked @endif @endif>代理商分润</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText">报表管理</span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="report.terminal"@if(isset($user)) @if($user->hasAccess('report.terminal')) checked @endif @endif>终端交易报表</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText"></span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="report.zero"@if(isset($user)) @if($user->hasAccess('report.zero')) checked @endif @endif>无交易终端报表</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label"></label>
                        <div class="col-md-10 col-lg-8">
                            <span class="userText">用户管理</span>
                            <div class="checkbox">
                                <label><input type="checkbox" name="permission[]" value="user"@if(isset($user)) @if($user->hasAccess('user')) checked @endif @endif>用户管理</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <div class="col-md-offset-2 col-md-10 col-lg-offset-4 col-lg-8">
                            <button type="submit" class="btn btn-primary">提交</button>
                            <a href="{{action('UserController@Index')}}" class="btn btn-default">取消</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $().ready(function() {
        $("#commentForm").validate();
    });
</script>
@endsection