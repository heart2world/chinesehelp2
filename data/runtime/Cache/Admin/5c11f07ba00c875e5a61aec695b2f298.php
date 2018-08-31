<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
		.form-required{color:red;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/",
	    WEB_ROOT: "/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('teacher/index');?>">教师管理</a></li>
			<!--<li><a href="<?php echo U('teacher/add');?>">新增教师</a></li>-->
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('teacher/index');?>">
            姓名:
            <input type="text" name="nicename" style="width: 100px;" value="<?php echo I('request.nicename/s','');?>" placeholder="请输入姓名">&nbsp;
            <!--职称:
            <select name="title" style="width: 135px;">
				<option value="">请选择职称</option>
				<?php if(is_array($titlelist)): $i = 0; $__LIST__ = $titlelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["title"]); ?>" <?php if($va['title'] == $title): ?>selected<?php endif; ?>><?php echo ($va["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>&nbsp;-->			
			学科:
            <select name="xueke" style="width: 135px;">
				<option value="">选择学科</option>
				<?php if(is_array($xuekelist)): $i = 0; $__LIST__ = $xuekelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["title"]); ?>" <?php if($va['title'] == $title): ?>selected<?php endif; ?>><?php echo ($va["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>&nbsp;
            学校:
            <select name="schoolname" style="width: 135px;">
				<option value="">请选择学校类型</option>
				<?php if(is_array($schollist)): $i = 0; $__LIST__ = $schollist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["schoolname"]); ?>" <?php if($va['schoolname'] == $schoolname): ?>selected<?php endif; ?>><?php echo ($va["schoolname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>&nbsp;
			注册时间：<input type="text" name="starttime"  class="js-date"  value="<?php echo I('request.starttime');?>" style="width: 90px;" autocomplete="off">-
                      <input type="text" name="endtime" class="js-date" value="<?php echo I('request.endtime');?>" style="width: 90px;" autocomplete="off">
            <input type="submit" class="btn btn-primary" value="查询" />
            <a class="btn btn-danger" href="<?php echo U('teacher/index');?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead><tr><th colspan='12'>合计：&nbsp;<?php echo ($count); ?>&nbsp;人</th></tr></thead>
			<thead>
				<tr>
					<th style="text-align: center;">ID</th>
					<th style="text-align: center;">姓名</th>
					<th style="text-align: center;">账号</th>
					<th style="text-align: center;">教龄</th>
					<th style="text-align: center;">学科</th>
					<th style="text-align: center;">职称</th>	
					<th style="text-align: center;">当前学校</th>	
					<th style="text-align: center;">TA的代理</th>	
					<th style="text-align: center;">代理权限</th>								
					<th style="text-align: center;">审核状态</th>
					<th style="text-align: center;"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
				
					<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["nicename"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["mobile"]); ?></td>					
					<td style="text-align: center;"><?php echo ($vo["seniority"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["xueke"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["title"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["schoolname"]); ?></td>					
					<td style="text-align: center;"><?php if($vo['parentname'] != ''): echo ($vo["parentname"]); else: ?>暂无<?php endif; ?></td>
					<td style="text-align: center;"><?php if($vo['isdaili'] == '1'): ?>已开启<?php else: ?>未开启<?php endif; ?></td>
					<td style="text-align: center;"><?php if($vo['status'] == 1): ?>已审核<?php elseif($vo['status'] == 2): ?>已驳回<?php else: ?>待审核<?php endif; ?></td>
					<td style="text-align: center;">
							<a class="btn js-ajax-delete"  style="padding: 2px 15px;color: black;" href="<?php echo U('teacher/delete',array('id'=>$vo['id']));?>"><?php echo L('DELETE');?></a>	
							<a href='<?php echo U("teacher/edit",array("id"=>$vo["id"]));?>' style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('EDIT');?></a> 
							<a style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary" href="<?php echo U('teacher/detail',array('id'=>$vo['id']));?>">详细</a>		
					</td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<?php if($count > 20): ?><div class="pagination" style="float: right;"><?php echo ($page); ?></div><?php endif; ?>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>