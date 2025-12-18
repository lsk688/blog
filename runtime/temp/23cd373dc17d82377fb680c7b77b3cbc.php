<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\auth_group\add.html";i:1764757917;s:74:"D:\phpstudy_pro\WWW\blog\public/../application/admin\view\public\head.html";i:1764582846;}*/ ?>
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
            <a href="">管理员管理</a>
            <a href="">权限管理</a>
            <a><cite>权限添加</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <form class="layui-form" action="" method="POST">
							  <div class="layui-form-item">
							    <label class="layui-form-label">管理员名称</label>
							    <div class="layui-input-block">
							      <select name="title" lay-verify="required">
							      	<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
							      		<option value="<?php echo $data['id']; ?>"><?php echo $data['username']; ?></option>
							      	<?php endforeach; endif; else: echo "" ;endif; ?>
							      </select>
							    </div>
							  </div>

							  <div class="layui-form-item">
							    <label class="layui-form-label">规则</label>
							    <div class="layui-input-block">
							      <table>
							      	<?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tree): $mod = ($i % 2 );++$i;?>
								      	<tr fid="<?php echo $tree['pid']; ?>" cate-id='<?php echo $tree['id']; ?>'>
								      		<td>
								      			<?php echo str_repeat("&nbsp;",$tree['level']*8); ?>
								      			<input type="checkbox" lay-filter="<?php echo $tree['pid']; ?>" name="rules[]" title="<?php echo $tree['title']; ?>" lay-skin="primary" dataid="<?php echo $tree['dataid']; ?>" value="<?php echo $tree['id']; ?>" class="checkbox-parent <?php echo $tree['level']==0?'':'checkbox-child';?>" fid="<?php echo $tree['pid']; ?>">
								      		</td>
								      	</tr>
							      	<?php endforeach; endif; else: echo "" ;endif; ?>
							      </table> 
							    </div>
							  </div>
							  <div class="layui-form-item">
							    <label class="layui-form-label">状态</label>
							    <div class="layui-input-block">
							      <input type="radio" name="status" value="1" title="开启" checked>
							      <input type="radio" name="status" value="0" title="禁用">
							    </div>
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

		// form.on('checkbox', function(data){
		//   // console.log(data.elem); //得到checkbox原始DOM对象
		//   var dataid = $('input.checkbox-child').attr("dataid");
	    //     dataid = dataid.substring(0, dataid.lastIndexOf("-"));
	    //     var parent = $('input[dataid=' + dataid + ']');
	    //     if ($('input.checkbox-child').is(':checked')) {
	    //         parent.prop('checked', true);
	    //     } else {
	    //         //父级
	    //         if ($('input[dataid=' + dataid + '-]:checked').length == 0) {
	    //             parent.prop('checked', false);
	    //         }
	    //     }
		// });      


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

    <script>
		/* 权限配置 */
		// $(function () {
		//     //动态选择框，上下级选中状态变化
		//     $('input.checkbox-parent').on('change', function () {
		//         // var dataid = $(this).attr("dataid");
		//         alert("11111111");
		//         // $('input[dataid^=' + dataid + ']').prop('checked', $(this).is(':checked'));
		//     });
		//     $('input.checkbox-child').on('change', function () {
		//         var dataid = $(this).attr("dataid");
		//         dataid = dataid.substring(0, dataid.lastIndexOf("-"));
		//         var parent = $('input[dataid=' + dataid + ']');
		//         if ($(this).is(':checked')) {
		//             parent.prop('checked', true);
		//         } else {
		//             //父级
		//             if ($('input[dataid^=' + dataid + '-]:checked').length == 0) {
		//                 parent.prop('checked', false);
		//             }
		//         }
		//     });
		// });
	</script>
</html>