<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>我的学生</title>
		<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
		<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
		<link rel="stylesheet" href="/public/style/app.css">
		<script src="/public/libs/jq.min.js"></script>
		<script src="/public/libs/v.min.js"></script>
	</head>
	<style>
		.notice{ padding:15px; font-size:12px;color:#8e8e8e}}
		.weui-cell__bd>p{ color:#595959}
	</style>
	<body>
		<section id="app">
			<section class="stuSec">
				<div class="tit">
					<div class="app-flex">
						<p class="app-basis" style="font-size:1rem">总人数</p>
					</div>
					<p class="count"><?php echo ($count); ?></p>
				</div>
				<div class="weui-cells">
					<a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/scode');?>">
						<div class="weui-cell__hd"><img src="/public/assets/erweima.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
						<div class="weui-cell__bd">
							<p>学生推广码</p>
						</div>
						<div class="weui-cell__ft"></div>
					</a>
					<a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/studentlist');?>">
						<div class="weui-cell__hd"><img src="/public/assets/xuesheng.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
						<div class="weui-cell__bd">
							<p>学生列表</p>
						</div>
						<div class="weui-cell__ft"></div>
					</a>
				</div>
				<p class="notice">凡是扫描此二维码进入问学帮的学生，您将在TA们的所有消费中获得<?php echo ($option["studentpersent"]); ?>%的分成</p>
			</section>
		</section>
		<!--<section class="stuSec">
			<div class="tit">
				<p style="font-size:1rem">总人数</p>
				<p class="count"><?php echo ($count); ?></p>
			</div>
			<div class="weui-cells">
	            <a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/scode');?>">
	                <div class="weui-cell__hd"><img src="/public/assets/erweima.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
	                <div class="weui-cell__bd">
	                    <p>学生推广码</p>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </a>
	            <a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/studentlist');?>">
	                <div class="weui-cell__hd"><img src="/public/assets/xuesheng.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
	                <div class="weui-cell__bd">
	                    <p>学生列表</p>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </a>
	        </div>
			<p class="notice">凡是扫描此二维码进入问学帮的学生，您将在TA们的所有消费中获得<?php echo ($option["studentpersent"]); ?>%的分成</p>
		</section>-->
		
	</body>
</html>