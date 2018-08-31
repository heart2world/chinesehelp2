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
<style type="text/css">
.pic-list li {
	margin-bottom: 5px;
}
</style>
</head>
<body>
	<div class="wrap js-check-wrap" id="app">
		<ul class="nav nav-tabs">
			<li class="active"><a>财务设置</a></li>
		</ul>
		<form class="form-horizontal" id="tagforms" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group">
					<label class="control-label">1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;微课：</label>
					<div class="controls">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
					教师微课的提成比例:&nbsp;<input type="number" style="width: 70px;" min="1" max="99.99" name="options[wxpersent]" value="<?php echo ($wxpersent); ?>">&nbsp;%
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">2.为TA充电：</label>
					<div class="controls">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
					为TA充电教师的提成比例:&nbsp;<input type="number" style="width: 70px;" min="1" max="99.99" name="options[cdpersent]" value="<?php echo ($cdpersent); ?>">&nbsp;%
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">3.&nbsp;购买资源：</label>
					<div class="controls">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
					教师资源的提成比例:&nbsp;<input type="number" style="width: 70px;" min="1" max="99.99" name="options[zypersent]" value="<?php echo ($zypersent); ?>">&nbsp;%
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">4&nbsp;分销佣金：</label>
					<div class="controls">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
					代理教师提成比例:&nbsp;<input type="number" style="width: 70px;" min="1" max="99.99" name="options[teacherpersent]" value="<?php echo ($teacherpersent); ?>">&nbsp;%
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
					学生上级提成比例:&nbsp;<input type="number" style="width: 70px;" min="1" max="99.99" name="options[studentpersent]" value="<?php echo ($studentpersent); ?>">&nbsp;%
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<input type="button" @click="add()" class="btn btn-primary" value="保存"/>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script src="/public/js/vue.js"></script>
	<script src="/public/js/content_addtop.js"></script>
	<script src="/public/js/define_my.js"></script>
	<script src="/public/js/artDialog/artDialog.js"></script>
	<script>
		var app = new Vue({
			el:"#app",
			data:{
				info:{},				
			},
			created:function () {
			},
			methods:{
				add:function () {	
				     var tagvals=$('#tagforms').serialize();				
					$.ajax({
						url:'<?php echo U("Fset/edit_post");?>',
						data:tagvals,
						type:"POST",
						dataType:"json",
						success:function (res) {							
							if(res.status==0){
								$.dialog({id: 'popup', lock: true,icon:"succeed", content: res.msg, time: 2});
								setInterval(function(){
									location.href='<?php echo U("Fset/index");?>';
								},3000)
							}
							else {
								$.dialog({id: 'popup', lock: true,icon:"warning", content: res.msg, time: 2});
							}
						}

					})
				}
			}
		});	

	</script>
</body>
</html>