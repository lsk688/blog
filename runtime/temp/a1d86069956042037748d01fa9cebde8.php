<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\conf\add.html";i:1764858253;s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\public\head.html";i:1764582846;}*/ ?>
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
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">配置管理</a>
            <a href="">配置列表</a>
            <a><cite>配置添加</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body layui-table-body layui-table-main" style="padding-bottom: 80px;">
                            <form class="layui-form" action="" method="POST">
							  <div class="layui-form-item">
							    <label class="layui-form-label">配置中文</label>
							    <div class="layui-input-block">
							      <input type="text" name="cname" required  lay-verify="required" placeholder="请输入配置中文" autocomplete="off" class="layui-input">
							    </div>
							  </div>
							  <div class="layui-form-item">
							    <label class="layui-form-label">配置英文</label>
							    <div class="layui-input-block">
							      <input type="text" name="ename" required  lay-verify="required" placeholder="请输入配置英文" autocomplete="off" class="layui-input">
							    </div>
							  </div>
							   <div class="layui-form-item">
							    <label class="layui-form-label">配置类型</label>
							    <div class="layui-input-block">
							      <select name="type" lay-verify="required">
							      	<option value="">选择类型</option>
							        <option value="1">单行文本</option>
							        <option value="2">多行文本</option>
							        <option value="3">单选按钮</option>
							        <option value="4">多选按钮</option>
							        <option value="4">下拉菜单</option>
							      </select>
							    </div>
							  </div>
							  <div class="layui-form-item layui-form-text">
							    <label class="layui-form-label">可选值</label>
							    <div class="layui-input-block">
							      <textarea name="vals" placeholder="请输入可选值" class="layui-textarea"></textarea>
							    </div>
							    <div class="layui-input-block">
							      可选值是在选择配置类型为单选按钮、多选按钮、下拉菜单时填写，多个可选内容用要中文"，"逗号隔开。
							    </div>
							    <!-- <label class="layui-form-label">可选值</label>
							    <div class="layui-form-mid layui-word-aux">
		                            <span class="x-red">*</span>将会成为您唯一的登入名
		                        </div> -->
							  </div>
							  <div class="layui-form-item">
							    <div class="layui-input-block">
							      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
							      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
							      <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary">取消添加</a>
							    </div>
							  </div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['form'], function(){
        // var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){
          if(data.elem.checked){
            // $('tbody input.check').prop('checked',true);
            $('tbody input[type="checkbox"]').prop('checked',true);
          }else{
            $('tbody input.check').prop('checked',false);
          }
          form.render('checkbox');
        });

        //批量修改，取消顶级分类及该顶级分类下的子分类
        form.on('checkbox(0)', function(data){
          cateIds = [];
          var cateId = $(this).parents('tr').attr("cate-id");
          // alert(cateId);
          getCateId(cateId);
          // alert(cateIds);
          // alert($(this).get(0).checked);
          // if ($(this).get(0).checked) {
          //   for (var i in cateIds) {
          //     $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('.layui-form-checkbox').addClass("layui-form-checked");
          //     $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('input[type="checkbox"').prop('checked',true);
          //     // alert(cateIds[i]);
          //   }
          // }else {
          //   for (var i in cateIds) {
          //     $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('.layui-form-checkbox').removeClass("layui-form-checked");
          //     $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('input[type="checkbox"').prop('checked',false);
          //     // alert(cateIds[i]);
          //   }
          // }
        });

        form.on('checkbox', function(data){
        	// console.log(data.elem);
        	if (data.elem) {
        		var fid = $(this).attr("fid");
        		var dataid = $(this).attr("dataid");
        		// console.log(fid);
        		if (fid==0) {
        			var cateId = $(this).parents('tr').attr("cate-id");
        			getCateId(cateId);
        			// alert(cateIds);
			        // alert($(this).get(0).checked);
			        if ($(this).get(0).checked) {
			            for (var i in cateIds) {
			              $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('.layui-form-checkbox').addClass("layui-form-checked");
			              $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('input[type="checkbox"').prop('checked',true);
			              // alert(cateIds[i]);
			        	}
			        }else {
			            for (var i in cateIds) {
			              $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('.layui-form-checkbox').removeClass("layui-form-checked");
			              $("tbody tr[cate-id=" + cateIds[i] + "]").find('td').find('input[type="checkbox"').prop('checked',false);
			              // alert(cateIds[i]);
		            	}
			        }
        		}else {
        			dataid = dataid.substring(0, dataid.lastIndexOf("-"));
        			// var parent = $('input[dataid=' + dataid + ']');
        			var parent = $("tbody tr[cate-id=" + dataid + "]");
        			// console.log(parent);
        			// console.log(dataid);
        			if ($('input.checkbox-child').is(':checked')) {
        				parent.find('td').find('.layui-form-checkbox').addClass("layui-form-checked");
        				parent.find('td').find('input[type="checkbox"').prop('checked',true);
        			}else {
			            // 父级
			            if ($('input[dataid=' + dataid + '-]:checked').length == 0) {
			            	parent.find('td').find('.layui-form-checkbox').removeClass("layui-form-checked");
			                parent.find('td').find('input[type="checkbox"').prop('checked',false);
			            }
			        }

        		}
        	}
			//   console.log(data.elem.checked); //是否被选中，true或者false
			//   console.log(data.value); //复选框value值，也可以通过data.elem.value得到
			//   console.log(data.othis); //得到美化后的DOM对象
		});

      });

      var cateIds = [];
      function getCateId(cateId) {
        $("tbody tr[fid="+cateId+"]").each(function(index, el) {
            id = $(el).attr('cate-id');
            cateIds.push(id);
            getCateId(id);
        });
      }
    </script>
</html>