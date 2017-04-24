@extends('layout.base')
@section('title')
    增加渠道
@endsection
@section('main')
<div class="main">
    <div class="location">
        <span class="text"><i class="iconFont">&#xe635;</i><a href="/">首页</a>&nbsp;&nbsp;>&nbsp;&nbsp;<a href="{{action('ChannelController@Index')}}">渠道配置</a></span>
    </div>
    <div class="content">
        <div class="formBox">
            <form class="form-horizontal" action="{{isset($channel) ? action('ChannelController@Update',['id'=>$channel->id]) : action('ChannelController@Add')}}" method="post" id="commentForm">
                {{ csrf_field() }}
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">渠道名称</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="Name" value="{{isset($channel->Name) ? $channel->Name : ''}}" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系人</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="Contact" value="{{isset($channel->Contact) ? $channel->Contact : ''}}" required>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <label class="col-md-2 col-lg-4 control-label">联系电话</label>
                        <div class="col-md-10 col-lg-8">
                            <input type="text" class="form-control" name="ContactPhone" value="{{isset($channel->ContactPhone) ? $channel->ContactPhone : ''}}" required>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="col-md-12 col-lg-6 form-group">
                        <div class="col-md-offset-2 col-md-10 col-lg-offset-4 col-lg-8">
                            <button type="submit" class="btn btn-primary">提交</button>
                            <a href="{{action('ChannelController@Index')}}" class="btn btn-default">取消</a>
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