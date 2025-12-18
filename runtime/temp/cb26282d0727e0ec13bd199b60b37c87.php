<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\conf\index.html";i:1764861400;s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\public\head.html";i:1764582846;}*/ ?>
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
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">配置管理</a>
            <a>
              <cite>配置列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5" action="<?php echo url('index'); ?>" method="get">
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="title"  placeholder="请输入标题" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                               <!--  <div class="layui-right" style="margin-left:30px;">
                                  <p class="tot">
                                    共有数据：&nbsp;<b id="tot" ></b>&nbsp;条
                                  </p>
                                </div> -->
                                <div class="layui-col-md10">
                                  共有数据：&nbsp;&nbsp;<?php echo $count; ?>条
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <a href="<?php echo url('add'); ?>" style="margin-left: 10px;"><button class="layui-btn"><i class="layui-icon"></i>添加配置</button></a>
                            <!-- <button class="layui-btn" onclick="xadmin.open('添加规则','<?php echo url('add'); ?>',600,400)"><i class="layui-icon"></i>添加</button> -->
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>
                                      <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                                    </th>
                                    <th>ID</th>
                                    <th>配置中文</th>
                                    <th>配置英文</th>
                                    <th>配置类型</th>
                                    <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dat): $mod = ($i % 2 );++$i;?>
                                    <tr>
                                    	<td>
                                    		<input type="checkbox" value="" lay-skin="primary">
                                    	</td>
                                    	<td><?php echo $dat['id']; ?></td>
                                    	<td><?php echo $dat['cname']; ?></td>
                                    	<td><?php echo $dat['ename']; ?></td>
                                    	<td>
                                    		<?php if($dat['type'] == 1): ?>
                                    			单行文本
                                    		<?php elseif($dat['type'] == 2): ?>
                                    			多行文本
                                    		<?php elseif($dat['type'] == 3): ?>
                                    			单选按钮
                                    		<?php elseif($dat['type'] == 4): ?>
                                    			多选按钮
                                    		<?php elseif($dat['type'] == 5): ?>
                                    			下拉菜单
                                    		<?php endif; ?>
                                    	</td>
                                    	<td class="td-manage">
	                                        <a title="编辑" href="<?php echo url('update',array('id'=>$dat['id'])); ?>">
	                                          <i class="layui-icon">&#xe642;</i>
	                                        </a>
	                                        &nbsp;&nbsp;|&nbsp;&nbsp;
	                                        <a title="删除" href="<?php echo url('del',array('id'=>$dat['id'])); ?>">
	                                          <i class="layui-icon">&#xe640;</i>
	                                        </a>
                                      	</td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                  <ul>
                                    <?php echo $page; if(is_array($page) || $page instanceof \think\Collection || $page instanceof \think\Paginator): $i = 0; $__LIST__ = $page;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page): $mod = ($i % 2 );++$i;?>
                                        <li><?php echo $page['nickname']; ?></li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                  </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){

          if(data.elem.checked){
            $('tbody input[type="checkbox"]').prop('checked',true);
          }else{
            $('tbody input[type="checkbox"]').prop('checked',false);
          }
          form.render('checkbox');
        }); 
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });

      


      //批量删除
      function delAll (argument) {
        var ids = [];
        // 获取选中的id 
        $('tbody input').each(function(index, el) {
            if($(this).prop('checked')){
              if ($(this).val()!=0) {
                ids.push($(this).val())
              }
            }
        });
        // str=ids.join(',',ids);          //把数组转换为字符串并用逗号隔开
        // $.post('<?php echo url('ajax_delAll'); ?>',str:str,function(data){
        //   layer.confirm('确认要删除吗？'+ids.toString(),function(index){
        //     if (data==ids.length) {
        //         //捉到所有被选中的，发异步进行删除
        //         layer.msg('删除成功', {icon: 1});
        //         $(".layui-form-checked").not('.header').parents('tr').remove();
        //     }else {
        //         alert('删除失败!!!');
        //     }
        //     // //捉到所有被选中的，发异步进行删除
        //     // layer.msg('删除成功', {icon: 1});
        //     // $(".layui-form-checked").not('.header').parents('tr').remove();
        //   });
        // })
        str=ids.join(',',ids);
        // alert(ids.length);
        layer.confirm('确认要删除吗？'+ids.toString(),function(index){
          $.post("<?php echo url('ajax_delAll'); ?>",{id:str},function(data){
            if (data==ids.length) {
                //捉到所有被选中的，发异步进行删除
                layer.msg('删除成功', {icon: 1});
                $(".layui-form-checked").not('.header').parents('tr').remove();
            }else {
                layer.msg('删除失败!!!');
            }
          })
            // //捉到所有被选中的，发异步进行删除
            // layer.msg('删除成功', {icon: 1});
            // $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>
</html>