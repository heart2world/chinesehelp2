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
			<li class="active"><a href="<?php echo U('Report/index');?>">举报管理</a></li>
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('Report/index');?>">
            标题:
            <input type="text" name="title" style="width: 100px;" value="<?php echo I('request.title/s','');?>" placeholder="请输入标题">&nbsp;
            发布教师：
            <input type="text" name="teacher" style="width: 100px;" value="<?php echo I('request.teacher/s','');?>" placeholder="请输入教师姓名">
            &nbsp;
            <input type="submit" class="btn btn-primary" value="查询" />
            <a class="btn btn-danger" href="<?php echo U('Report/index');?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr><td colspan="10">共&nbsp;<?php echo ($rcount); ?>&nbsp;条记录</td></tr>
			</thead>
			<thead>
				<tr>
					<th style="text-align: center;min-width: 50px;">ID</th>
					<th style="text-align: center;min-width: 100px;">举报内容的标题</th>
					<th style="text-align: center;min-width: 50px;">类型</th>
					<th style="text-align: center;min-width: 200px;">内容简介</th>
					<th style="text-align: center;min-width: 100px;">发布教师</th>	
					<th style="text-align: center;min-width: 80px;">内容发布时间</th>	
					<th style="text-align: center;min-width: 120px;">举报内容</th>	
					<th style="text-align: center;min-width: 38px;">举报时间</th>	
					<th style="text-align: center;min-width: 38px;">处理状态</th>						
					<th style="text-align: center;min-width: 100px;"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
				
					<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["title"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["type"]); ?></td>					
					<td style="text-align: center;"><?php echo ($vo["brief"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["teachername"]); ?></td>
					<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["lefttime"])); ?></td>
					<td style="text-align: center;"><?php echo ($vo["content"]); ?></td>
					<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
					<td style="text-align: center;"><?php if($vo['status'] == 1): ?>未处理<?php else: ?>已处理<?php endif; ?></td>
					<td style="text-align: center;">
							<a style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary" href="<?php echo U('Report/info',array('id'=>$vo['id']));?>">查看详情</a>		
							<a class="btn js-ajax-delete"  style="padding: 2px 15px;color: black;" href="<?php echo U('Report/delete',array('id'=>$vo['id']));?>"><?php echo L('DELETE');?></a>	
							
					</td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>