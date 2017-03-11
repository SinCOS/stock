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
<style type="text/css">
.frm_signin {
    max-width: 400px;
    margin: 0 auto;
}
</style>
<body style="padding-top: 40px;">
  
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
        	$.post('/user/login', data.field, function(data, textStatus, xhr) {
        		if (data.status == 1) {
                    localStorage['userID']=1;
                    window.location = "/";
                    return;
                }else{
                    layer.msg(data.message);
                }
        	},'json');
            return false;
        });
    });
    </script>
</body>

</html>
