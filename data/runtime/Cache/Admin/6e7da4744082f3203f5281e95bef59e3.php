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
.control-group{margin-bottom: 0px;}
</style>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a>数据统计</a></li>
		</ul>
        <form class="well form-search" method="post">
           <fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;font-weight: bold;font-size: 15px;">消费统计</label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;">1、会员总消费：<?php echo ($info["pricetotal"]); ?>元</label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;">2、教师总抽成：<?php echo ($info["ticheng"]); ?>元</label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;">3、平台收入：<?php echo ($info["ptprice"]); ?>元</label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;font-weight: bold;font-size: 15px;">人员统计</label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;">1、会员总注册人数：<?php echo ($info["mcount"]); ?>人</label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;">2、教师总注册人数：<?php echo ($info["tcount"]); ?>人</label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;">3、消费会员比例：<?php echo ($info["persont"]); ?>%</label>
					</div>
				</div>	
		 	</fieldset>
        </form>
		
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>