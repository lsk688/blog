<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\login\index.html";i:1764926540;s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\public\head.html";i:1764582846;}*/ ?>
<!doctype html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
<title>后台登录-X-admin2.2</title>
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!-- <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" /> -->
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="stylesheet" href="__STATIC__/admin/css/font.css">
<link rel="stylesheet" href="__STATIC__/admin/css/login.css">
<link rel="stylesheet" href="__STATIC__/admin/css/xadmin.css">
<!-- <link rel="stylesheet" href="./css/theme5.css"> -->
<script src="__STATIC__/admin/lib/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="__STATIC__/admin/js/xadmin.js"></script>
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script>
    // 是否开启刷新记忆tab功能
    // var is_remember = false;
</script>
    <![endif]-->
    </head>
    <body class="login-bg">

        <div class="login layui-anim layui-anim-up">
            <div class="message">x-admin2.0-管理登录</div>
            <div id="darkbannerwrap"></div>
            <form method="post" class="layui-form">
                <input name="username" placeholder="用户名" type="text" lay-verify="required" class="layui-input">
                <hr class="hr15">
                <input name="password" lay-verify="required" placeholder="密码" type="password" class="layui-input">
                <?php
                    if ($data['val']=='是') {
                ?>
                <hr class="hr15">
                <div id="validatePanel" class="item" style="position: relative;">
                    <input type="text" name="yzm" placeholder="请输入验证码" maxlength="4">
                    <div style="position: absolute;right: 0;top: 1px;"><img src="<?php echo captcha_src(); ?>" class="verifyimg" onclick="javascript:this.src='<?php echo captcha_src(); ?>?rand='+Math.random()" ></div>
                </div>
                <?php } ?>
                <hr class="hr15">
                <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
                <hr class="hr20">
            </form>
        </div>

        <script>
            $(function() {
                layui.use('form', function() {
                    var form = layui.form;
                    // layer.msg('玩命卖萌中', function(){
                    //   //关闭后的操作
                    //   });
                    //监听提交
                    form.on('submit(login)', function(data) {
                        // alert(888)
                        layer.msg(JSON.stringify(data.field), function() {
                            location.href = 'index.html'
                        });
                        return false;
                    });
                });
            })
        </script>
    </body>
</html>