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
<style type="text/css">
/*.js-ajax-delete{
	color: #fff;
    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
    background-color: #e95d4e;
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
    padding: 0px 15px 5px;
    border-radius: 3px;
    font-size: 14px;
    margin-left: 2px;}*/

</style>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('rbac/index');?>"><?php echo L('ADMIN_RBAC_INDEX');?></a></li>
			<li><a href="<?php echo U('rbac/roleadd');?>"><?php echo L('ADMIN_RBAC_ROLEADD');?></a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('Rbac/index');?>">
			角色名： 
			<input type="text" name="keyword" style="width: 200px;" value="<?php echo I('request.keyword');?>" placeholder="请输入角色名">
			<input type="submit" class="btn btn-primary" value="查询" />
			<a class="btn btn-danger" href="<?php echo U('Rbac/index');?>">清空</a>
		</form>
		<form action="<?php echo U('Rbac/listorders');?>" method="post">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th style="text-align: center;">ID</th>
						<th style="text-align: center;">角色名</th>
						<th style="text-align: center;"><?php echo L('ROLE_DESCRIPTION');?></th>
						<th style="text-align: center;"><?php echo L('ACTIONS');?></th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($roles)): foreach($roles as $key=>$vo): ?><tr>
						<?php if($vo['id'] != 1): ?><td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
						<td style="text-align: center;"><?php echo ($vo["name"]); ?></td>
						<td style="text-align: center;"><?php echo ($vo["remark"]); ?></td>
						<td style="text-align: center;">
							
								<!--<font style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('ROLE_SETTING');?></font> 
								<font style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('EDIT');?></font>  
								<font style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-danger"><?php echo L('DELETE');?></font>-->
							
								<a href="<?php echo U('Rbac/authorize',array('id'=>$vo['id']));?>" style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('ROLE_SETTING');?></a>
								<a href="<?php echo U('Rbac/roleedit',array('id'=>$vo['id']));?>" style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('EDIT');?></a>
								<a class="btn js-ajax-delete" style="padding: 2px 15px;color: black;" href="<?php echo U('Rbac/roledelete',array('id'=>$vo['id']));?>"><?php echo L('DELETE');?></a><?php endif; ?>
						</td>
						</if>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</form>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>