<?php
/* Smarty version 3.1.30, created on 2017-03-03 17:41:19
  from "/data/wwwroot/default/app/tpl/user/register.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58b93a3f176010_68632090',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ced9b3e23b21d9b90bfeb597749f1c8a38c4f137' => 
    array (
      0 => '/data/wwwroot/default/app/tpl/user/register.tpl',
      1 => 1488467601,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58b93a3f176010_68632090 (Smarty_Internal_Template $_smarty_tpl) {
?>
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
			<?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
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
   <!--  <?php echo '<script'; ?>
 type="text/javascript" src="http://cdn.bootcss.com/vue/2.1.8/vue.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdn.jsdelivr.net/vue.resource/1.0.3/vue-resource.min.js"><?php echo '</script'; ?>
> -->
    <?php echo '<script'; ?>
 src="//code.jquery.com/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/public/layui/layui.js" charset="utf-8"><?php echo '</script'; ?>
>

    <style type="text/css">
    .login-from {
        width: 500px;
        margin: 0 auto;
        margin-top: 20%;
    }
    </style>
    <?php echo '<script'; ?>
>
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
    <?php echo '</script'; ?>
>
</body>

</html>
<?php }
}
