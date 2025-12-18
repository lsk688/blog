<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\index\memberadd.html";i:1762686691;s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\public\head.html";i:1764582846;}*/ ?>
<!DOCTYPE html>
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
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" id="addForm" onsubmit="return false">
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">
                            <span class="x-red">*</span>用户名</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="username" required="" lay-verify="nikename"
                                autocomplete="off" class="layui-input" value="">
                        </div>
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>将会成为您唯一的登入名
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">
                            <span class="x-red">*</span>密码</label>
                        <div class="layui-input-inline">
                            <input type="password" id="L_pass" name="password" required="" lay-verify="pass" autocomplete="off"
                                class="layui-input" value="">
                        </div>
                        <div class="layui-form-mid layui-word-aux">5到12个字符</div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            <span class="x-red">*</span>确认密码</label>
                        <div class="layui-input-inline">
                            <input type="password" id="L_repass" name="repass" required="" lay-verify="repass" autocomplete="off"
                                class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                              <input type="radio" name="status" title="启用" value="1" checked>
                              <input type="radio" name="status" title="禁用" value="0"}>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" id="sublit" lay-submit="">添加</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            layui.use(['form', 'layer', 'jquery'],
                function() {
                    $ = layui.jquery;
                    var form = layui.form,
                        layer = layui.layer;

                    //自定义验证规则
                    // form.verify({
                    //     nikename: function(value) {
                    //         if (value.length < 5) {
                    //             return '昵称至少得5个字符啊';
                    //         }
                    //     },
                    //     pass: [/(.+){6,12}$/, '密码必须6到12位'],
                    //     repass: function(value) {
                    //         if ($('#L_pass').val() != $('#L_repass').val()) {
                    //             return '两次密码不一致';
                    //         }
                    //     }
                    // });

                    //监听提交
                    form.on('submit(add)',
                        function(data) {
                            // console.log(data);
                            str = $('#addForm').serialize();  //获取序列化的数据
                            $.post("<?php echo url('ajax_add'); ?>",{str:str},function(data){
                                if (!data.code==1) {
                                    layer.alert("添加成功", {
                                        icon: 6
                                    },
                                    function() {
                                        // 获得frame索引
                                        var index = parent.layer.getFrameIndex(window.name);
                                        //关闭当前frame
                                        parent.layer.close(index);
                                        parent.location.reload();
                                    });
                                }else {
                                    layer.alert(data.error);
                                }
                            })
                            //发异步，把数据提交给php
                            // layer.alert("增加成功", {
                            //         icon: 6
                            //     },
                            //     function() {
                            //         //关闭当前frame
                            //         xadmin.close();

                            //         // 可以对父窗口进行刷新 
                            //         xadmin.father_reload();
                            //     });
                            // return false;
                        });

                });
        </script>
    </body>
</html>