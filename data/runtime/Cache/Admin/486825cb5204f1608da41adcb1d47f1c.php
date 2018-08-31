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
	<div class="wrap" id="app">
		<ul class="nav nav-tabs">
			<li class="active"><a>图片详情</a></li>
			<li><a href="javascript:history.go(-1);">返回</a></li>
		</ul>
		
			<fieldset>
				<div class="control-group">
				<div>
					<img src="<?php echo ($info["titleimg"]); ?>" style="display: block; margin: 0 auto; max-width: 45%;" id="preview-img">
				</div>
				<div class="btns" style="text-align: center; padding: 10px 0;">
					<a class="btn btn-primary" href="javascript:rotate_img(this);">图片旋转</a></div>
				</div>
				</div>
			</fieldset>
	</div>
	
	<script src="/public/js/common.js"></script>
	<script>
		var deg = 0;
		var rotate_img = function(){
			var preview_img = $("#preview-img");
			deg+=90;
			
			preview_img.css({
				"backface-visibility":"none",
				"-webkit-backface-visibility":"none",
				"-webkit-backface-visibility":"none",
				"transform":"rotate("+deg+"deg)",
				"-webkit-transform":"rotate("+deg+"deg)",
				"-Moz-transform":"rotate("+deg+"deg)",
				"-O-transform":"rotate("+deg+"deg)",
				"-ms-transform":"rotate("+deg+"deg)",
				"transition":"transform 0.725s ease",
				"-webkit-transition":"transform 0.725s ease",
				"-Moz-transition":"transform 0.725s ease",
				"-O-transition":"transform 0.725s ease",
				"-ms-transition":"transform 0.725s ease",
			});
		}
	</script>
	
</body>
</html>