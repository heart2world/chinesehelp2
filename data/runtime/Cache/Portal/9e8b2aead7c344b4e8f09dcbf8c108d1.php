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
			<li class="active"><a href="javascript:;"><?php echo L('PORTAL_ADMINPOST_INDEX');?></a></li>
			<li><a href="<?php echo U('AdminPost/add');?>" target="_self">新增</a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('AdminPost/index');?>">
			标题： 
			<input type="text" name="keyword" style="width: 200px;" value="<?php echo ((isset($formget["keyword"]) && ($formget["keyword"] !== ""))?($formget["keyword"]):''); ?>" placeholder="请输入关键字...">
			类型： 
			<select name="term" style="width: 120px;">
				<option value='0'>选择类型</option>
				<option value='1' <?php if($post_term == 1): ?>selected<?php endif; ?>>公告</option>
				<option value='2' <?php if($post_term == 2): ?>selected<?php endif; ?>>轮播图</option>
			</select> &nbsp;&nbsp;
			
			<input type="submit" class="btn btn-primary" value="搜索" />
			<a class="btn btn-danger" href="<?php echo U('AdminPost/index');?>">清空</a>
		</form>
		<form class="js-ajax-form" action="" method="post">
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>						
						<th style="min-width: 50px;text-align: center;">ID</th>
						<th style="min-width: 50px;text-align: center;">类型</th>
						<th style="min-width: 50px;text-align: center;">位置</th>
						<th style="min-width: 100px;text-align: center;">标题</th>
						<th style="min-width: 200px;text-align: center;">内容简介</th>
						<th style="min-width: 150px;text-align: center;">开发端</th>
						<th style="min-width: 150px;text-align: center;">链接</th>
						<th style="min-width: 80px;text-align: center;">添加时间</th>
						<th style="min-width: 50px;text-align: center;">状态</th>
						<th style="min-width: 200px;text-align: center;"><?php echo L('ACTIONS');?></th>
					</tr>
				</thead>
				<?php if(is_array($posts)): foreach($posts as $key=>$vo): ?><tr>					
                    <td style="text-align: center;"><b><?php echo ($vo["id"]); ?></b></td>
                    <td style="text-align: center;"><?php if($vo['post_term'] == 1): ?>公告<?php else: ?>轮播图<?php endif; ?></td>
					<td style="text-align: center;"><?php echo ($vo["positionstr"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["post_title"]); ?></td>
					<td style="text-align: center;"><?php if($vo['post_term'] == 1): echo ($vo["post_excerpt"]); else: ?><a href="<?php echo ($vo["post_img2"]); ?>"><img src="<?php echo ($vo["post_img2"]); ?>" width="120px;"></a><?php endif; ?></td>
					<td style="text-align: center;"><?php if($vo['isterm'] == 1): ?>教师端<?php else: ?>学生端<?php endif; ?></td>
					<td style="text-align: center;"><?php echo ($vo["link_url"]); ?></td>
					<td style="text-align: center;"><?php echo date('Y-m-d H:i',strtotime($vo['post_date']));?></td>
					<td style="text-align: center;">
						<?php if($vo['post_status'] == 1): ?>上架<?php else: ?>下架<?php endif; ?>
					</td>
					<td style="text-align: center;">
					    <?php if($vo['post_status'] == 1): ?><a href="<?php echo U('AdminPost/ban',array('id'=>$vo['id']));?>" class="btn js-ajax-dialog-btn" style="padding: 2px 15px;color: black;" data-msg="您确定要下架此用户吗？">下架</a> 
							<?php else: ?>
								<a href="<?php echo U('AdminPost/cancelban',array('id'=>$vo['id']));?>" class="btn js-ajax-dialog-btn" style="padding: 2px 15px;color: black;" data-msg="您确定要上架此用户吗？">上架</a><?php endif; ?>
						<a href="<?php echo U('AdminPost/detail',array('id'=>$vo['id']));?>" style="padding:2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary">查看详情</a>
						<a href="<?php echo U('AdminPost/edit',array('id'=>$vo['id']));?>" style="padding:2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary"><?php echo L('EDIT');?></a> 
						<a href="<?php echo U('AdminPost/delete',array('id'=>$vo['id']));?>" class="btn js-ajax-delete" style="padding: 2px 15px;color: black;" class="btn btn-primary"><?php echo L('DELETE');?></a>
					</td>
				</tr><?php endforeach; endif; ?>
				
			</table>
			
			<div class="pagination"><?php echo ($page); ?></div>
		</form>
	</div>
	<script src="/public/js/common.js"></script>
	<script>
		function refersh_window() {
			var refersh_time = getCookie('refersh_time');
			if (refersh_time == 1) {
				window.location = "<?php echo U('AdminPost/index',$formget);?>";
			}
		}
		setInterval(function() {
			refersh_window();
		}, 2000);
		$(function() {
			setCookie("refersh_time", 0);
			Wind.use('ajaxForm', 'artDialog', 'iframeTools', function() {
				//批量复制
				$('.js-articles-copy').click(function(e) {
					var ids=[];
					$("input[name='ids[]']").each(function() {
						if ($(this).is(':checked')) {
							ids.push($(this).val());
						}
					});
					
					if (ids.length == 0) {
						art.dialog.through({
							id : 'error',
							icon : 'error',
							content : '您没有勾选信息，无法进行操作！',
							cancelVal : '关闭',
							cancel : true
						});
						return false;
					}
					
					ids= ids.join(',');
					art.dialog.open("/index.php?g=portal&m=AdminPost&a=copy&ids="+ ids, {
						title : "批量复制",
						width : "300px"
					});
				});
				//批量移动
				$('.js-articles-move').click(function(e) {
					var ids=[];
					$("input[name='ids[]']").each(function() {
						if ($(this).is(':checked')) {
							ids.push($(this).val());
						}
					});
					
					if (ids.length == 0) {
						art.dialog.through({
							id : 'error',
							icon : 'error',
							content : '您没有勾选信息，无法进行操作！',
							cancelVal : '关闭',
							cancel : true
						});
						return false;
					}
					
					ids= ids.join(',');
					art.dialog.open("/index.php?g=portal&m=AdminPost&a=move&old_term_id=<?php echo ((isset($term["term_id"]) && ($term["term_id"] !== ""))?($term["term_id"]):0); ?>&ids="+ ids, {
						title : "批量移动",
						width : "300px"
					});
				});
			});
		});
	</script>
</body>
</html>