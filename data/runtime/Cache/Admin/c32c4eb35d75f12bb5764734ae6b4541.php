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
	<div class="wrap">
		<audio src="" id="media" width="1" height="1"></audio>
		<ul class="nav nav-tabs">
			<li class="active"><a>专题详情</a></li>
			<li><a href="javascript:history.go(-1);">返回</a></li>
		</ul>
		<form class="form-horizontal js-ajax-form" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label">标题：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["title"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">简介：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["desc"]); ?></label>
					</div>
				</div>				
				<div class="control-group">
					<label class="control-label">综合评分：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php echo ($info["compoint"]); ?></label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">查看数量：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php if($info['clicknum'] > '999'): ?>999+<?php else: echo ($info["clicknum"]); endif; ?></label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">收藏数量：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php if($info['collectnum'] > '999'): ?>999+<?php else: echo ($info["collectnum"]); endif; ?></label>
					</div>
				</div>	
				<div class="tab-content">
				    <div class="control-group">
					<label class="control-label" style="font-weight: bold"><span><a>内容</a></span></label>
        			<HR width="100%" color=#987cb9 SIZE=1 />
						<table class="table table-hover table-bordered" id="A" >
						<thead>
							<tr>
								<th style="text-align: center;width: 50px;">ID</th>
								<th style="text-align: center;width: 100px;">微课/资源标题</th>
								<th style="text-align: center;width: 100px;">微课/资源类型</th>
								<th style="text-align: center;width: 100px;">简介</th>
								<th style="text-align: center;width: 100px;">发布教师</th>
								<th style="text-align: center;width: 100px;">购买价格</th>
								<th style="text-align: center;width: 100px;">查看量</th>
								<th style="text-align: center;width: 100px;">发布时间</th>
								<th style="text-align: center;width: 100px;">综合评分</th>
								<th style="text-align: center;width: 100px;">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($slist)): foreach($slist as $key=>$vo): ?><tr>
								<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["title"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["classtype"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["brief"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["username"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["price"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["clicknum"]); ?></td>
								<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
								<td style="text-align: center;"><?php echo ($vo["star"]); ?></td>
								<td style="text-align: center;">
									<?php if($vo['type'] == 1): ?><a href="<?php echo U('Wclass/detail',array('id'=>$vo['id']));?>" class="btn">查看详情</a>
									<?php else: ?>
									<a href="<?php echo U('Recommended/detail',array('id'=>$vo['id']));?>" class="btn">查看详情</a><?php endif; ?>
								</td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			</fieldset>
			
		</form>
</div>
<script src="/public/js/common.js"></script>
</body>
</html>