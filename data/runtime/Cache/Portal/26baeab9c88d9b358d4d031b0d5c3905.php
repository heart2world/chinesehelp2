<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>平台公告</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="语文帮">
	<meta name="format-detection" content="telephone=no,address=no,email=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="renderer" content="webkit">
	<meta name="HandheldFriendly" content="true">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="full-screen" content="yes">
	<meta name="keywords" content="语文帮学生端">
	<meta name="description" content="语文帮学生端">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
</head>
<body data-app="ChineseBang">
	<section class="notice-detail-content">
		<h4 class="notice-title"><?php echo ($article["post_title"]); ?></h4>
		<h5 class="content-panel"><span class="content-title">简介:</span> <?php echo ($article["post_excerpt"]); ?></h5>
		<div class="content-panel"><span class="content-title">内容:</span><?php echo ($article["post_content"]); ?></div>	
	</section>
</body>
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/fixed.js"></script>
	<script src="/public/libs/weui/jquery-weui.js"></script>
	<script src="/public/libs/swiper.js"></script>
	<script type="text/javascript" src="http://jqweui.com/dist/js/swiper.js" ></script>
</html>

<script>
	$(function(){
		$(".notice-detail-content").find("*").css("max-width","100%");
	})
	
	$(".notice-detail-content").on('click','img',function(){
		console.log(111);
		console.log($(this).attr('src'));
		var preview = $.photoBrowser({
		  items: [
			$(this).attr("src")
		  ]
		});

		preview.open();
	})
	
</script>