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
			<li class="active"><a href="<?php echo U('orders/index');?>">会员消费管理</a></li>
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('orders/index');?>">
        	消费时间：<input type="text" name="starttime"  class="js-date"  value="<?php echo I('request.starttime');?>" style="width: 90px;" autocomplete="off">-
                      <input type="text" name="endtime" class="js-date" value="<?php echo I('request.endtime');?>" style="width: 90px;" autocomplete="off">
            消费类型：<select name="typename" style="width: 135px;">
						<option value="">选择类型</option>
						<?php if(is_array($typelist)): $i = 0; $__LIST__ = $typelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["type"]); ?>" <?php if($va['type'] == $typename): ?>selected<?php endif; ?>><?php echo ($va["type"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            		  </select>&nbsp;
            会员:
            <input type="text" name="username" style="width: 100px;" value="<?php echo I('request.username/s','');?>" placeholder="请输入会员名称">&nbsp;
            <input type="submit" class="btn btn-primary" value="查询" />
            <a class="btn btn-danger" href="<?php echo U('orders/index');?>">清空</a>
            <input type="submit" name="export" class="btn btn-primary" value="导出Excel" />
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th style="text-align: center;">ID</th>
					<th style="text-align: center;">单号</th>
					<th style="text-align: center;">消费时间</th>
					<th style="text-align: center;">会员</th>
					<th style="text-align: center;">消费类型</th>	
					<th style="text-align: center;">消费金额</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($orders)): foreach($orders as $key=>$vo): ?><tr>				
					<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["ordersn"]); ?></td>
					<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>					
					<td style="text-align: center;"><?php echo ($vo["username"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["type"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["orderprice"]); ?></td>					
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>