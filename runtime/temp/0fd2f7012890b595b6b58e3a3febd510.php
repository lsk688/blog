<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\lunbo\index.html";i:1764419698;s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\public\head.html";i:1764582846;}*/ ?>
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
            <a href="">演示</a>
            <a>
              <cite>导航元素</cite></a>
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
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','<?php echo url('memberadd'); ?>',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>
                                      <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                                    </th>
                                    <th>ID</th>
                                    <th>标题</th>
                                    <th>图片</th>
                                    <th>视频</th>
                                    <!-- <th>链接</th> -->
                                    <th>排序</th>
                                    <th>状态</th>
                                    <th>操作</th></tr>
                                </thead>
                                <tbody>
                                    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
                                    <tr>
                                      <td>
                                        <input type="checkbox" name="id"  value="<?php echo $data['id']; ?>" lay-skin="primary">
                                      </td>
                                      <td><?php echo $data['id']; ?></td>
                                      <td><?php echo $data['title']; ?></td>
                                      <td>
                                        <?php if($data['img'] != ''): ?>
                                        <img src="__STATIC__/uploads/lunbo/<?php echo $data['img']; ?>" alt="" width="100" height="70">
                                        <?php endif; ?>
                                      </td>
                                      <td>
                                        <?php if($data['video'] != ''): ?>
                                        <video class="video" autoplay="" loop="" muted="" width="120" height="70"><source src="__STATIC__/uploads_video/lunbo/<?php echo $data['video']; ?>" type="video/mp4"></video>
                                        <?php endif; ?>
                                      </td>
                                      <!-- <td><?php echo $data['href']; ?></td> -->
                                      <td>
                                        <input type="text" name="sort" id="" value="<?php echo $data['sort']; ?>" onblur="sort(this,<?php echo $data['id']; ?>)">
                                      </td>
                                      <td class="td-status">
                                        <?php if($data['status'] == 1): ?>
                                        <span class="layui-btn layui-btn-normal layui-btn-mini">
                                        已启用
                                        </span>
                                        <?php else: ?>
                                        <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">
                                        已停用
                                        </span>
                                        <?php endif; ?>
                                      </td>
                                      <td class="td-manage">
                                        <?php if($data['status'] == 1): ?>
                                          <a onclick="member_stop(this,<?php echo $data['id']; ?>,<?php echo $data['status']; ?>)" href="javascript:;"  title="启用">
                                            <i class="layui-icon">&#xe601;</i>
                                          </a>
                                        <?php else: ?>
                                          <a onclick="member_stop(this,<?php echo $data['id']; ?>,<?php echo $data['status']; ?>)" href="javascript:;"  title="停用">
                                            <i class="layui-icon">&#xe62f;</i>
                                          </a>
                                        <?php endif; ?>
                                        <a title="编辑"  onclick="xadmin.open('编辑','<?php echo url('memberedit',array('id'=>$data['id'])); ?>',600,400)" href="javascript:;">
                                          <i class="layui-icon">&#xe642;</i>
                                        </a>
                                        <a title="删除" onclick="member_del(this,'<?php echo $data['id']; ?>')" href="javascript:;">
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

       /*用户-停用*/
      function member_stop(obj,id,val){
          if (val) {
            layer.confirm('确认要停用吗？',function(index){
              $.post("<?php echo url("ajax_status"); ?>",{id:id,status:0},function(data){
                if (data==1) {
                    //发异步把用户状态进行更改
                    $(obj).attr('title','停用')
                    $(obj).find('i').html('&#xe62f;');
                    $(obj).attr('onclick','member_stop(this,'+id+',0)');
                    $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                    layer.msg('已停用!',{icon: 5,time:1000});
                }else {
                    layer.alert('停用失败!!!');
                }
              })
            });
          }else {
            layer.confirm('确认要启用吗？',function(index){
              $.post("<?php echo url("ajax_status"); ?>",{id:id,status:1},function(data){
                  if (data==1) {
                      $(obj).attr('title','启用')
                      $(obj).find('i').html('&#xe601;');
                      $(obj).attr('onclick','member_stop(this,'+id+',1)');
                      $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                      layer.msg('已启用!',{icon: 6,time:1000});
                  }else {
                      layer.alert('启用失败!!!');
                  }
              })
            })
          }
      }

      //排序
      function sort(obj,id) {
          // alert($(obj).val());
          num=$(obj).val();
          $.post('<?php echo url("sort"); ?>', {sort:num,id:id}, function(data) {
              if (data==1) {
                  $(obj).val(num);
                  layer.alert("排序修改成功！", {
                      icon: 6
                  },
                  function() {
                      // // 获得frame索引
                      // var index = parent.layer.getFrameIndex(window.name);
                      // //关闭当前frame
                      // parent.layer.close(index);
                      parent.location.reload();
                  });
              }
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
          $.post('<?php echo url('ajax_del'); ?>',{id:id},function(data){
            if (data==1) {
                  //发异步删除数据
                  $(obj).parents("tr").remove();
                  layer.msg('已删除!',{icon:1,time:1000});
              
            }
          })
        });
          // layer.confirm('确认要删除吗？',function(index){
          //     //发异步删除数据
          //     $(obj).parents("tr").remove();
          //     layer.msg('已删除!',{icon:1,time:1000});
          // });
      }


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