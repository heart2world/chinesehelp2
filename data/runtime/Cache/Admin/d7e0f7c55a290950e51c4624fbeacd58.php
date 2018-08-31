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
			<li class="active"><a href="<?php echo U('user/index');?>"><?php echo L('ADMIN_USER_INDEX');?></a></li>
			<li><a href="<?php echo U('user/add');?>">添加用户</a></li>
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('User/index');?>">
            姓名:
            <input type="text" name="user_nicename" style="width: 100px;" value="<?php echo I('request.user_nicename/s','');?>" placeholder="请输入姓名">&nbsp;
            手机号:
            <input type="text" name="user_login" style="width: 100px;" value="<?php echo I('request.user_login/s','');?>" placeholder="请输入手机号">&nbsp;
            <input type="submit" class="btn btn-primary" value="查询" />
            <a class="btn btn-danger" href="<?php echo U('User/index');?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th style="text-align: center;">ID</th>
					<th style="text-align: center;">姓名</th>
					<th style="text-align: center;">手机号（账号）</th>
					<th style="text-align: center;">所属角色</th>						
					<th style="text-align: center;"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($users)): foreach($users as $key=>$vo): ?><tr>
				<?php if($vo['id'] == 1 || $vo['id'] == sp_get_current_admin_id()): else: ?>
					<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["user_nicename"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["user_login"]); ?></td>					
					<td style="text-align: center;"><?php echo ($vo["rolename"]); ?></td>
					<td style="text-align: center;">
						
							<a href='<?php echo U("user/edit",array("id"=>$vo["id"]));?>' style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('EDIT');?></a> 
							<a class="btn js-ajax-delete"  style="padding: 2px 15px;color: black;" href="<?php echo U('user/delete',array('id'=>$vo['id']));?>"><?php echo L('DELETE');?></a>
							<?php if($vo['user_status'] == 1): ?><a href="<?php echo U('user/ban',array('id'=>$vo['id']));?>" class="btn js-ajax-dialog-btn" style="padding: 2px 15px;color: black;" data-msg="您确定要冻结此用户吗？">冻结</a> 
							<?php else: ?>
								<a href="<?php echo U('user/cancelban',array('id'=>$vo['id']));?>" class="btn js-ajax-dialog-btn" style="padding: 2px 15px;color: black;" data-msg="您确定要解冻此用户吗？">解冻</a><?php endif; ?>
							<a style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary" href="<?php echo U('user/userinfo',array('id'=>$vo['id']));?>">详情</a>
					</td><?php endif; ?>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>