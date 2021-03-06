<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！-->
    <title>易联众线下终端交易管理平台</title>
    <link rel="stylesheet" href="{{elixir('go/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{elixir('go/css/style.css')}}"/>
</head>
<body>

<div class="loginBg"></div>

<div class="ppr-loginContainer text-center ng-scope">
    <div class="ppr-paddingBM">
        <p class="ppr-inputLabel ppr-textT ppr-textWhite">易联众线下终端交易<br/>管理平台</p>
    </div>
    <div>
        <form role="form" class="ng-pristine ng-invalid ng-invalid-required" action="{{action('UserController@LoginCheck')}}" method="post">
            {{ csrf_field() }}
            <fieldset ng-disabled="isSaving">
                <div class="ppr-paddingBM">
                    <input name="UserName" class="form-control ppr-loginInput ppr-backgroundTransparent ppr-textWhite ng-pristine ng-invalid ng-invalid-required ng-touched" type="text" placeholder="用户名">
                </div>
                <div class="ppr-paddingBM">
                    <input name="PassWord" class="form-control ppr-loginInput ppr-backgroundTransparent ppr-textWhite ng-pristine ng-untouched ng-invalid ng-invalid-required" type="password" placeholder="密码">
                </div>
                <div class="ppr-marginBL">
                    <input name="captcha" class="form-control ppr-loginInput ppr-backgroundTransparent ppr-textWhite ng-pristine ng-untouched ng-invalid ng-invalid-required" type="text" placeholder="验证码">
                    <img src="{{Captcha::src()}}" class="code" name="captcha"/>
                </div>
                <div class="ppr-marginBL">
                    <button class="ppr-btnSelect ppr-textL" type="submit">登录</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>

</body>
</html>