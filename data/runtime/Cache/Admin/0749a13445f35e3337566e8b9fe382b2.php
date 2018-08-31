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
			<li class="active"><a href="<?php echo U('member/index');?>">会员管理</a></li>
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('member/index');?>">
            微信昵称:
            <input type="text" name="nicename" style="width: 100px;" value="<?php echo I('request.nicename/s','');?>" placeholder="请输入微信昵称">&nbsp;
            学校:
            <input type="text" name="schoolname" style="width: 100px;" value="<?php echo I('request.schoolname/s','');?>" placeholder="请输入学校名称">&nbsp;
			注册时间：<input type="text" name="starttime"  class="js-date"  value="<?php echo I('request.starttime');?>" style="width: 90px;" autocomplete="off">-
                      <input type="text" name="endtime" class="js-date" value="<?php echo I('request.endtime');?>" style="width: 90px;" autocomplete="off">
            <input type="submit" class="btn btn-primary" value="查询" />
            <a class="btn btn-danger" href="<?php echo U('member/index');?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th colspan="9">合计：&nbsp;<?php echo ($count); ?>&nbsp;人</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th style="text-align: center;">ID</th>
					<th style="text-align: center;">微信昵称</th>
					<th style="text-align: center;">年龄</th>
					<th style="text-align: center;">年级</th>
					<th style="text-align: center;">性别</th>	
					<th style="text-align: center;">学校</th>
					<th style="text-align: center;">TA的教师</th>
					<th style="text-align: center;">TA的代理</th>					
					<th style="text-align: center;"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($member)): foreach($member as $key=>$vo): ?><tr>
				
					<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["nicename"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["age"]); ?></td>					
					<td style="text-align: center;"><?php echo ($vo["classname"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["sex"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["schoolname"]); ?></td>
					<td style="text-align: center;"><?php if($vo["teachername"] != ''): echo ($vo["teachername"]); else: ?>暂无<?php endif; ?></td>
					<td style="text-align: center;"><?php if($vo["parentname"] != ''): echo ($vo["parentname"]); else: ?>暂无<?php endif; ?></td>
					<td style="text-align: center;">
							<a style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary" href="<?php echo U('member/detail',array('id'=>$vo['id']));?>">查看详情</a>							
							<?php if($vo['user_status'] == 1): ?><a href="<?php echo U('member/ban',array('id'=>$vo['id']));?>" class="btn js-ajax-dialog-btn" style="padding: 2px 15px;color: black;" data-msg="您确定要冻结此用户吗？">冻结</a> 
							<?php else: ?>
								<a href="<?php echo U('member/cancelban',array('id'=>$vo['id']));?>" class="btn js-ajax-dialog-btn" style="padding: 2px 15px;color: black;" data-msg="您确定要解冻此用户吗？">解冻</a><?php endif; ?>
							<a href='<?php echo U("member/edit",array("id"=>$vo["id"]));?>' style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('EDIT');?></a> 
					</td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>