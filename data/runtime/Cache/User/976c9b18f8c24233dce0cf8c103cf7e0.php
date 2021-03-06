<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>我的教师</title>
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/jquery-weui.css" />
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/weui.min.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/public.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/style.css" />
		<script type="text/javascript" src="/public/chhelp2/lib/jq/jquery-1.10.2.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/lib/weui/jquery-weui.js" ></script>
	</head>
	<style>
		.notice{ padding:15px; font-size:12px;color:#8e8e8e}
	</style>
	<body>
		
		<section class="stuSec">
			<div class="tit">
				<p style="font-size:1rem">总人数</p>
				<p class="count"><?php echo ($count); ?></p>
			</div>
			<div class="weui-cells">
	            <a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/tcode');?>">
	                <div class="weui-cell__hd"><img src="/public/assets/erweima.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
	                <div class="weui-cell__bd">
	                    <p>教师推广码</p>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </a>
	            <a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/teacherlist');?>">
	                <div class="weui-cell__hd"><img src="/public/assets/jiaoshiliebiao1.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
	                <div class="weui-cell__bd">
	                    <p>教师列表</p>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </a>
	        </div>
			<p class="notice">祝贺您开启代理模式，您可以用此码组织老师们加入问学帮，您将在TA们学生的全部消费中，获得<?php echo ($option["teacherpersent"]); ?>%的分成</p>
		</section>
		
	</body>
</html>