<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\auth_rule\add.html";i:1764502909;s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\public\head.html";i:1764582846;}*/ ?>
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
    <script type="text/javascript" src="__STATIC__/admin/js/jquery-3.6.4.min.js"></script>
  </head>
  <body>
    <style>
      .layui-input-inline {
        width: 100%;
      }
    </style>
    <div class="layui-fluid">
      <div class="layui-row">
        <form class="layui-form" id="addForm" onsubmit="return false">
          <div class="layui-form-item">
		    <label for="username" class="layui-form-label">
              <span class="x-red">*</span>上级权限
            </label>
		    <div class="layui-input-block">
		      <select name="pid" lay-verify="required">
		        <option value="0">顶级权限</option>
		        <?php if(is_array($rule) || $rule instanceof \think\Collection || $rule instanceof \think\Paginator): $i = 0; $__LIST__ = $rule;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rule): $mod = ($i % 2 );++$i;?>
		        <option value="<?php echo $rule['id']; ?>"><?php
		        	if ($rule['level']!=0) {
		        		echo '|';
		        	}
		        	echo str_repeat('---------',$rule['level']);
		        ?><?php echo $rule['title']; ?></option>
		        <?php endforeach; endif; else: echo "" ;endif; ?>
		      </select>
		    </div>
		  </div>

          <div class="layui-form-item">
            <label for="username" class="layui-form-label">
              <span class="x-red">*</span>权限名称
            </label>
            <div class="layui-input-block">
              <input type="text" name="title" required  lay-verify="required" placeholder="请输入权限名称" autocomplete="off" class="layui-input">
              <!-- <input type="text" id="username" name="username" required="" lay-verify="required"
                autocomplete="off" class="layui-input"> -->
            </div>
            <!-- <div class="layui-form-mid layui-word-aux">
              将会成为您唯一的登入名
            </div> -->
          </div>
          <div class="layui-form-item">
            <label for="des" class="layui-form-label">
              控/方
            </label>
            <div class="layui-input-block">
              <input type="text" id="des" name="name" placeholder="请输入控制器/方法路径" lay-verify="des" autocomplete="off"
                class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button class="layui-btn" lay-filter="add" lay-submit="add">
              提交
            </button>
            <!-- <input type="submit" class="layui-btn" value="提交"> -->
            <input type="reset" class="layui-btn layui-bg-red" value="重置">
          </div>
        </form>
      </div>
    </div>

    <script>
      layui.use(['form', 'layer'],
        function() {
          $ = layui.jquery;
          var form = layui.form,
            layer = layui.layer;

          //监听提交
          form.on('submit(add)',
            function(data) {
              console.log(data);
              //发异步，把数据提交给php
              str = $('#addForm').serialize();  //获取序列化的数据
              // alert(str);
              $.post("<?php echo url('add'); ?>",{str:str},function(data){
                  if (data==1) {
                      layer.alert("添加成功", {
                          icon: 6
                      },
                      function() {
                          // 获得frame索引
                          var index = parent.layer.getFrameIndex(window.name);
                          //关闭当前frame
                          parent.layer.close(index);
                          // 刷新父级页面
                          parent.location.reload();
                      });

                  }else {
                      // layer.alert(data.error);
                  	layer.alert("添加失败！");
                  }
              })
            });

        });
    </script>
  </body>
</html>