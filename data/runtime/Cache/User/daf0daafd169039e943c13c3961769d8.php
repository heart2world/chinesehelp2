<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>认证资料</title>
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
<style>
	body .weui-cell__bd{ max-width:75px}
</style>
<body data-app="ChineseBang">
	<!--认证资料-->
	<section class="info-container" style="padding:0">
		<div class="weui-cells">
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<p>姓名</p>
				</div>
				<div class="weui-cell__ft"><?php echo ($nicename); ?></div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<p>学科</p>
				</div>
				<div class="weui-cell__ft"><?php echo ($xueke); ?></div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<p>电话</p>
				</div>
				<div class="weui-cell__ft"><?php echo ($mobile); ?></div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<p>教龄</p>
				</div>
				<div class="weui-cell__ft"><?php echo ($seniority); ?>年</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<p>职称</p>
				</div>
				<div class="weui-cell__ft"><?php echo ($title); ?></div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<p>学校</p>
				</div>
				<div class="weui-cell__ft"><?php echo ($schoolname); ?></div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<p>擅长</p>
				</div>
				<div class="weui-cell__ft"><?php echo ($questiontype); ?></div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd" style="min-width:75px">
					<p>荣誉</p>
				</div>
				<div class="weui-cell__ft" style="text-align:left"><?php echo ($honors); ?></div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd" style="min-width:4rem">
					<p>照片</p>
				</div>
				<div class="weui-cell__ft">
					<img src="<?php echo ($titleimg); ?>" alt="">
				</div>
			</div>
		</div>
		<div class="info-tip">如有变更请联系客服进行更新~</div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/script/common.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>

</html>