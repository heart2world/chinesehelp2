<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>消息提醒</title>
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
	body .weui-dialog__btn{ color:#3cc8fe}
</style>
<body data-app="ChineseBang">
	<!--消息提醒列表-->
	<section id="app">
		<ul class="msg-list">
			<?php if(count($list) != 0): if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($key % 2 );++$key;?><li class="msg-item app-flex app-vertical-center">
				<div class="msg-info app-basis">
					<h4><?php echo (date('Y-m-d H:i:s',$va["addtime"])); ?></h4>
					<p><?php echo ($va["title"]); ?></p>
					<?php if($va['content'] != ''): ?><p><?php echo ($va["content"]); ?></p><?php endif; ?>
				</div>
				<div class="del-msg" @click="del_msg($event,'<?php echo ($va["id"]); ?>');"></div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
			<?php else: ?>
			<!--<center style="padding: 20px;font-size: 16px;">没有消息记录</center>-->
			<div class="data-text">没有更多了~</div><?php endif; ?>
		</ul>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			
		},
		methods:{
			del_msg:function(evt,mid){
				$.confirm({
					title:'',
					text:'确定要删除该条消息吗？',
					onOK:function(){
						$.showLoading("正在删除...");
						$.ajax({
								url: "<?php echo U('User/center/del_msg');?>",
								data: {id:mid},
								type:'POST',
								success: function (data) {
									console.log(data.msg);
									if (data.status==0) {                               
										//提交信息成功
										setTimeout(function(){
											$.hideLoading();
											setTimeout(function(){
												$.toast("已成功删除~",'text',function(){
													$(evt.target).parents("li").remove();
												});
											});
										},1500);
									}
									else {
										//跳转到预定失败界面
										$.hideLoading();
										$.toast(data.msg,'forbidden');
									}
								}
						});	
					}
				});	
				
			}
		}
	});
</script>
</html>