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
			<li class="active"><a href="<?php echo U('Question/index');?>">提问管理</a></li>
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('Question/index');?>">
            问题:
            <input type="text" name="title" style="width: 100px;" value="<?php echo I('request.title/s','');?>" placeholder="请输入问题">&nbsp;
            提问学生：
            <input type="text" name="username" style="width: 100px;" value="<?php echo I('request.username/s','');?>" placeholder="请输入提问学生姓名">
            &nbsp;
			学科:
            <select name="xueke" style="width: 135px;">
				<option value="">选择学科</option>
				<?php if(is_array($xuekelist)): $i = 0; $__LIST__ = $xuekelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["title"]); ?>" <?php if($va['title'] == $xueke): ?>selected<?php endif; ?>><?php echo ($va["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>&nbsp;
			发布时间：<input type="text" name="starttime"  class="js-date"  value="<?php echo I('request.starttime');?>" style="width: 90px;" autocomplete="off">-
                      <input type="text" name="endtime" class="js-date" value="<?php echo I('request.endtime');?>" style="width: 90px;" autocomplete="off">
            <input type="submit" class="btn btn-primary" value="查询" />
            <a class="btn btn-danger" href="<?php echo U('Question/index');?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead><tr><th colspan='12'>合计：&nbsp;<?php echo ($count); ?>&nbsp;篇</th></tr></thead>
			<thead>
				<tr>
					<th style="text-align: center;min-width: 50px;">ID</th>
					<th style="text-align: center;min-width: 100px;">提问标题</th>
					<th style="text-align: center;min-width: 50px;">追问问题</th>
					<th style="text-align: center;min-width: 200px;">提问会员</th>
					<th style="text-align: center;min-width: 100px;">指定教师</th>	
					<th style="text-align: center;min-width: 80px;">回答满意度</th>	
					<th style="text-align: center;min-width: 80px;">回答形式</th>
					<th style="text-align: center;min-width: 80px;">提问时间</th>										
					<th style="text-align: center;min-width: 38px;">平台精选（排序）</th>		
					<th style="text-align: center;min-width: 38px;">教师端链接</th>
					<th style="text-align: center;min-width: 38px;">学生端链接</th>	
					<th style="text-align: center;min-width: 150px;"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
				
					<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["title"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["againtitle"]); ?></td>					
					<td style="text-align: center;"><?php echo ($vo["nicename"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["teachername"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["star"]); ?></td>
					<td style="text-align: center;"><?php if($vo['isfree'] == 1): ?>私密<?php else: ?>公开<?php endif; ?></td>
					<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
					<td style="text-align: center;"><input type="text" style="width: 35px;height: 10px;" onblur="changeindex(this.value,<?php echo ($vo["id"]); ?>)" value="<?php echo ($vo["isindex"]); ?>"></td>
					<td style="text-align: center;"><?php echo ($vo["turl"]); ?></td>
					<td style="text-align: center;"><?php echo ($vo["surl"]); ?></td>
					<td style="text-align: center;">
							<a style="padding: 2px 15px;color: black;background-color: #bfc6cb;" class="btn btn-primary" href="<?php echo U('Question/detail',array('id'=>$vo['id']));?>">查看详情</a>		
							<a class="btn js-ajax-delete"  style="padding: 2px 15px;color: black;" href="<?php echo U('Question/delete',array('id'=>$vo['id']));?>"><?php echo L('DELETE');?></a>	
							
					</td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/public/js/common.js"></script>
	<script>
	function changeindex(val,id)
	{
		$.ajax({
                url:"<?php echo U('Question/changesort');?>",
                data:{id:id,val:val},
                type:"POST",
                dataType:"json",
                success:function (res) {
                	if(res.status == 0)
                	{
                		// alert(res.msg);
                	}
                }
               })
	}
	</script>
</body>
</html>