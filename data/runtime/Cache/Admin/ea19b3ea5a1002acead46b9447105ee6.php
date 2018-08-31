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
.form-horizontal .control-group{margin-bottom: 10px;}
</style>
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a>会员详情</a></li>
			<li><a href="javascript:history.go(-1);">返回</a></li>
		</ul>
		<form class="form-horizontal js-ajax-form" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label">微信昵称：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($nicename); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">性别：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($sex); ?></label>
					</div>
				</div>				
				<div class="control-group">
					<label class="control-label">年龄：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php echo ($age); ?></label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">年级：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php echo ($classname); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">TA的教师：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php if($teachername != ''): echo ($teachername); else: ?>暂无<?php endif; ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">TA的代理：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php if($parentname != ''): echo ($parentname); else: ?>暂无<?php endif; ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">学校：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php echo ($schoolname); ?></label>
					</div>
				</div>
			</fieldset>
			<hr/>
		</form>
		<div class="tab-content">
				    <div class=control-group>
					<label class="control-label" style="font-weight: bold"><span id="xuqiuone"><a onclick="changeorder(this)">提问历史</a></span> | <span id="xuqiutwo"><a onclick="changeorder2(this)" style="color: #ccc;">消费记录</a></span></label>
        			<HR width="100%" color=#987cb9 SIZE=1 />
						<table class="table table-hover table-bordered" id="A">
						<thead>
							<tr>
								<th style="text-align: center;width: 50px;">ID</th>
								<th style="text-align: center;width: 100px;">提问时间</th>
								<th style="text-align: center;width: 150px;">问题</th>
								<th style="text-align: center;width: 200px;">追问问题</th>
								<th style="text-align: center;width: 100px;">回答满意度</th>
								<th style="text-align: center;width: 200px;">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($questionlist)): foreach($questionlist as $key=>$vo): ?><tr>
								<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
								<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
								<td style="text-align: center;"><?php echo ($vo["title"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["againtitle"]); ?></td>							
								<td style="text-align: center;"><?php echo ($vo["star"]); ?></td>
								<td style="text-align: center;">
									<a href="<?php echo U('Question/detail',array('id'=>$vo['id']));?>" style="padding: 2px 15px;background-color:  #bfc6cb;" class="btn btn-primary">查看详情</a>
								</td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="pagination" id="A1"><?php echo ($page); ?></div>
					<table class="table table-hover table-bordered" id="B" style="display: none">
						<thead>
							<tr>
								<th style="text-align: center;width: 50px;">ID</th>
								<th style="text-align: center;width: 80px;">单号</th>
								<th style="text-align: center;width: 100px;">消费时间</th>
								<th style="text-align: center;width: 60px;">会员</th>
								<th style="text-align: center;width: 100px;">消费类型</th>
								<th style="text-align: center;width: 100px;">消费金额</th>								
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($orderlist)): foreach($orderlist as $key=>$vo): ?><tr>
								<td style="text-align: center;"><?php echo ($key+1); ?></td>
								<td style="text-align: center;"><?php echo ($vo["ordersn"]); ?></td>
								<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
								<td style="text-align: center;"><?php echo ($vo["username"]); ?></td>							
								<td style="text-align: center;"><?php echo ($vo["type"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["orderprice"]); ?></td>								
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
					<div class="pagination" id="B1" style="display: none"><?php echo ($page1); ?></div>
				    </div>
		</div>
	</div>
	<script src="/public/js/common.js"></script>
	<script type="text/javascript">
function changeorder2(obj)
{
	$("#B").show();
	$("#B1").show();
	$("#A").hide();
	$("#A1").hide();
	$(obj).css('color','#2fa4e7');
	$("#xuqiuone a").css('color','#ccc');
}
function changeorder(obj)
{
	$("#B").hide();
	$("#B1").hide();
	$("#A").show();
	$("#A1").show();
	$(obj).css('color','#2fa4e7');
	$("#xuqiutwo a").css('color','#ccc');
}
</script>
</body>
</html>