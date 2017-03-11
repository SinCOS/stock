<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录页面</title>
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body style="padding-top: 40px;">
    <div class="login-from">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-block">
                    <input type="text" name="username" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密 码</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux"><img src=""></div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="repassword" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux"><img src=""></div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <a href="/user/forget" title="已有帐号">已有帐号</a>
                </div>
            </div>
        </form>
    </div>
   <!--  <script type="text/javascript" src="http://cdn.bootcss.com/vue/2.1.8/vue.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/vue.resource/1.0.3/vue-resource.min.js"></script> -->
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="/public/layui/layui.js" charset="utf-8"></script>

    <style type="text/css">
    .login-from {
        width: 500px;
        margin: 0 auto;
        margin-top: 20%;
    }
    </style>
    <script>
    layui.use('form', function() {
        var form = layui.form();

        //监听提交
        form.on('submit(formDemo)', function(data) {
            if(data.field.password!=data.field.repassword){
                layer.msg('两次收入的密码不一致');
                return false;
            }
        	$.post('/user/register', data.field, function(data, textStatus, xhr) {
        		layer.msg(data.message)
        	},'json');
            

            return false;
        });
    });
    </script>
</body>

</html>
