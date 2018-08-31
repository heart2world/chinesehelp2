<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>举报内容</title>
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
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<style>
	.weui-btn_primary{background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
	.content-list .content-item a:after{display:none}
</style>
<body data-app="ChineseBang">
	<section id="app">
		<!--内容举报-->
		<article class="content-panel tipoff">
			<div class="content-list">
				<div class="tipoff-title">举报内容</div>
				<div class="content-item" data-type="mrolesson">
					<?php if($atype > 0): if($atype == 1): ?><a href="<?php echo U('Home/Task/lesson_info',array('id'=>$qinfo['id']));?>" style="display:block">
					<?php else: ?>
					<a href="<?php echo U('Home/Task/lesson_info',array('id'=>$qinfo['id']));?>" style="display:block"><?php endif; ?>
						<div class="content-top app-flex app-vertical-center">
							<h4 class="app-basis" style="font-size:.8rem"><?php echo ($qinfo["title"]); ?></h4>
						</div>
						<div class="content-inner-item app-flex">
							<h4 style="font-size:.8rem"><?php echo ($qinfo["type"]); ?>类型 :&nbsp;</h4>
							<h5 style="font-size:.8rem" class="app-basis"><?php echo ($qinfo["classtype"]); ?></h5>
						</div>
						<div class="content-inner-item app-flex">
							<h4 style="font-size:.8rem"><?php echo ($qinfo["type"]); ?>简介 :&nbsp;</h4>
							<h5 style="font-size:.8rem" class="app-basis"><?php echo ($qinfo["brief"]); ?></h5>
						</div>
						<div class="content-info-num2 app-flex app-vertical-center">
							<h4><?php echo ($qinfo["clicknum"]); if($qinfo['clicknum'] > '999'): ?>+<?php endif; ?></h4>
							<h5><?php echo ($qinfo["colcount"]); ?></h5>
						</div>
					</a><?php endif; ?>
					<?php if($atype == 0): ?><a href="<?php echo U('Home/Problem/detail',array('id'=>$qinfo['id']));?>" style="display:block">
						<div class="content-top app-flex app-vertical-center">
							<h4 class="app-basis" style="font-size:.9rem"><?php echo ($qinfo["title"]); ?></h4>
							<h5>问答</h5>
						</div>
						<div class="content-inner-item app-flex">
							<h4 style="font-size:.8rem">回答满意度:  <span><?php echo ($qinfo["star"]); ?></span></h4>
						</div>
						<div class="content-info-num2 app-flex app-vertical-center">
							<h4><?php echo ($qinfo["clicknum"]); if($qinfo['clicknum'] > '999'): ?>+<?php endif; ?></h4>
							<h5><?php echo ($qinfo["colcount"]); ?></h5>
						</div>
					</a><?php endif; ?>
					<input type="hidden" id="atype" value="<?php echo ($atype); ?>">
				</div>
			</div>
		</article>
		<!--举报原因填写-->
		<aside class="tip-reason">
			<h4 style="font-size:.8rem">举报原因</h4>
			<textarea name="reason" v-model="reason" placeholder="我们将进行匿名举报，请如实填写举报原因"></textarea>
			<!--<div class="tipoff-btn" @click="tipoff($event);">提 交</div>-->
		</aside>
		<div class="weui-btn-area" style="margin:1rem">
            <a class="weui-btn weui-btn_primary" href="javascript:" @click="tipoff($event);">提 交</a>
        </div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			aid:'1',
			reason:''
		},
		methods:{
			tipoff:function(evt){
				//提交举报内容
				if(this.reason == ''){
					$.toptip("提交失败，举报原因内容未填写~",3000,'warning');
					return;
				}
				$.showLoading("正在提交...");
				var tid ='<?php echo ($qinfo["id"]); ?>';
				var atype = $("#atype").val();
				$.ajax({
					url:"<?php echo U('Home/Problem/doreport');?>",
					data:{reason:this.reason,tid:tid,atype:atype},
					type:'POST',
					success:function(data){
						if(data.status==1)
						{
							//提交成功
							setTimeout(function(){
								$.hideLoading();
								$.toast("感谢您的反馈，我们会尽快处理~",1500,function(){
									location.href=data.url;
								});
							},2000);
						}else{
							$.toast("举报失败","forbidden");
						}
					}
				})				
			}
		}
	});
</script>
</html>