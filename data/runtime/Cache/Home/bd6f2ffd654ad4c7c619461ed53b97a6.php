<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>打分</title>
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
	.weui-btn_primary{ background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
</style>
<body data-app="ChineseBang">
	<section id="app">
		<!--打分八块-->
		<section class="score-wrap" style="padding:0 15px">
			<div class="score-item app-flex app-vertical-center">
				<h4>学有所获</h4>
				<h5 class="app-flex app-vertical-center">
					<span :class="{'active':cur_index >= 1}" @click="give_score($event,1,1);"></span>
					<span :class="{'active':cur_index >= 2}" @click="give_score($event,2,1);"></span>
					<span :class="{'active':cur_index >= 3}" @click="give_score($event,3,1);"></span>
					<span :class="{'active':cur_index >= 4}" @click="give_score($event,4,1);"></span>
					<span :class="{'active':cur_index >= 5}" @click="give_score($event,5,1);"></span>
				</h5>
			</div>
			<div class="score-item app-flex app-vertical-center">
				<h4>针对性强</h4>
				<h5 class="app-flex app-vertical-center">
					<span :class="{'active':cur_index2 >= 1}" @click="give_score($event,1,2);"></span>
					<span :class="{'active':cur_index2 >= 2}" @click="give_score($event,2,2);"></span>
					<span :class="{'active':cur_index2 >= 3}" @click="give_score($event,3,2);"></span>
					<span :class="{'active':cur_index2 >= 4}" @click="give_score($event,4,2);"></span>
					<span :class="{'active':cur_index2 >= 5}" @click="give_score($event,5,2);"></span>
				</h5>
			</div>
			<div class="score-item app-flex app-vertical-center">
				<h4>排版整洁</h4>
				<h5 class="app-flex app-vertical-center">
					<span :class="{'active':cur_index3 >= 1}" @click="give_score($event,1,3);"></span>
					<span :class="{'active':cur_index3 >= 2}" @click="give_score($event,2,3);"></span>
					<span :class="{'active':cur_index3 >= 3}" @click="give_score($event,3,3);"></span>
					<span :class="{'active':cur_index3 >= 4}" @click="give_score($event,4,3);"></span>
					<span :class="{'active':cur_index3 >= 5}" @click="give_score($event,5,3);"></span>
				</h5>
			</div>
			<div class="score-item app-flex app-vertical-center">
				<h4>校稿严谨</h4>
				<h5 class="app-flex app-vertical-center">
					<span :class="{'active':cur_index4 >= 1}" @click="give_score($event,1,4);"></span>
					<span :class="{'active':cur_index4 >= 2}" @click="give_score($event,2,4);"></span>
					<span :class="{'active':cur_index4 >= 3}" @click="give_score($event,3,4);"></span>
					<span :class="{'active':cur_index4 >= 4}" @click="give_score($event,4,4);"></span>
					<span :class="{'active':cur_index4 >= 5}" @click="give_score($event,5,4);"></span>
				</h5>
			</div>
			<div class="weui-btn-area">
				<a class="weui-btn weui-btn_primary" href="javascript:;" @click="pop_charge_box($event);">确 定</a>
			</div>
			<!--<div class="give-btn" @click="pop_charge_box($event);">确 定</div>-->
		</section>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;

	var app = new Vue({
		el:'#app',
		data:{
			cur_index:-1,
			cur_index2:-1,
			cur_index3:-1,
			cur_index4:-1,
			show_layer:false,
			score_info:[]
		},
		mounted:function(){
			var that = this;
			Vue.nextTick(function(){
				//是否开启自动评分
				//that.init_score_info();
			});
		},
		methods:{
			init_score_info:function(){
				//根据需求 自动评5分
				this.cur_index = 5;
				this.cur_index2 = 5;
				this.cur_index3 = 5;
				this.cur_index4 = 5;
			},
			give_score:function(evt,index,type){
				var that = this;
				switch(type){
					case 1:
					if(that.cur_index == index){
						that.cur_index-= 1;
					}else{
						that.cur_index = index;
					}
					break;
					case 2:
					if(that.cur_index2 == index){
						that.cur_index2-= 1;
					}else{
						that.cur_index2 = index;
					}
					break;
					case 3:
					if(that.cur_index3 == index){
						that.cur_index3-= 1;
					}else{
						that.cur_index3 = index;
					}
					break;
					case 4:
					if(that.cur_index4 == index){
						that.cur_index4-= 1;
					}else{
						that.cur_index4 = index;
					}
					break;
				}
			},
			pop_charge_box:function(evt){
				
				this.score_info[0] = this.cur_index < 0 ? 0 : this.cur_index;
				this.score_info[1] = this.cur_index2 < 0 ? 0 : this.cur_index2;
				this.score_info[2] = this.cur_index3 < 0 ? 0 : this.cur_index3;
				this.score_info[3] = this.cur_index4 < 0 ? 0 : this.cur_index4;
				console.log(this.score_info);
				var id="<?php echo ($id); ?>";
				$.ajax({
					url:"<?php echo U('Home/Resource/docore');?>",
					data:{cores:this.score_info,id:id},
					type:'POST',
					success:function(data){
						if(data.status==1)
						{
							$.toast("打分成功",'1000',function(){
								//回到首页
								location.href = data.url;
							});
						}else
						{
							app.show_layer = false;
							$.toast(data.msg,"forbidden");
						}
					}
				})
			}
		}
	});
</script>
</html>