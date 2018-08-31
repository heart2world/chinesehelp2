<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>消费记录</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="好问达">
	<meta name="format-detection" content="telephone=no,address=no,email=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="renderer" content="webkit">
	<meta name="HandheldFriendly" content="true">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="full-screen" content="yes">
	<meta name="keywords" content="好问达学生端">
	<meta name="description" content="好问达学生端">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<body data-app="ChineseBang">
	<section class="consume-note" id="app">
		<ul class="note-list">
			<?php if(is_array($order)): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="note-cell">
					<div class="note-top app-flex app-vertical-center app-content-justify">
						<h4><?php echo ($va["teachername"]); ?></h4>
						<h5><?php echo ($va["type"]); ?></h5>
					</div>
					<div class="note-btm app-flex app-vertical-center app-content-justify">
						<h4><?php echo (date('Y-m-d',$va["addtime"])); ?></h4>
						<h5>￥<?php echo ($va["orderprice"]); ?></h5>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<div class="data-text" v-text="data_text"></div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script>
	var app = new Vue({
		el:'#app',
		data:{
			data_text:'没有更多了~'

		},
		methods:{
			
		}
	});
</script>
</html>