<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>学生列表</title>
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/jquery-weui.css" />
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/weui.min.css" />
		<link rel="stylesheet" href="/public/style/app.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/public.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/style.css" />
		<script type="text/javascript" src="/public/chhelp2/lib/jq/jquery-1.10.2.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/lib/weui/jquery-weui.js" ></script>
	</head>
	<body>		
		<section class="stuListSec">
			<div class="weui-cells">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><div class="weui-cell">
	                <div class="weui-cell__hd"><img src="<?php echo ($va["headimg"]); ?>" alt="" style="width:2rem;height: 2rem;border-radius: 50%; margin-right:5px;display:block"></div>
	                <div class="weui-cell__bd">
	                    <p class="name"><?php echo ($va["nicename"]); ?></p>
	                    <p class="time">加入时间：<?php echo (date('Y-m-d H:i',$va["addtime"])); ?></p>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </div><?php endforeach; endif; else: echo "" ;endif; ?>				
        	</div>
			<!--<div style="text-align: center; font-size: 0.85rem; color: #595959; line-height: 2.2rem;">没有更多了~</div>-->
			<div class="data-text">没有更多了~</div>
		</section>
		
	</body>
</html>