<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>提现记录</title>
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
	<meta name="keywords" content="好问达教师端">
	<meta name="description" content="好问达教师端">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<body data-app="ChineseBang">
	<!--提现记录列表-->
	<section id="app">
		<ul class="widthdrawls-list">
			<!--<?php if(count($tixianlog) != 0): ?>-->
			<?php if(is_array($tixianlog)): $i = 0; $__LIST__ = $tixianlog;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item app-flex app-vertical-center">
				<h4 class="app-basis"><?php echo (date('Y-m-d H:i',$va["addtime"])); ?></h4>
				<h5>￥<?php echo ($va["price"]); ?></h5>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
			<!--<?php else: ?>
			<center style="padding: 10px;font-size: 16px;">没有提现记录</center><?php endif; ?>-->		
		</ul>
		<?php if(count($tixianlog) != 0): ?><div style="text-align: center; font-size: 0.8rem; color: #595959; line-height: 2.2rem;">没有更多了~</div>
		<?php else: ?>
		<div style="text-align: center; font-size: 0.8rem; color: #595959; line-height: 2.2rem;">暂无提现记录~</div><?php endif; ?>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/script/common.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>

</html>