<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>我要提问</title>
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
	.weui-picker-container .weui-check_label{ text-align:center}
	.toolbar .picker-button{ display:none}
	.weui-cells_radio .weui-check:checked+.weui-icon-checked:before{ display:none}
	.select-teacher .select-cell h5 a,.fixed-top .select-title{ font-size:.8rem}
	.teacher-list .list-item .teacher-info > h4{font-size:.8rem}
</style>
<body data-app="ChineseBang">
	<section id="app" style="padding-bottom: 2.5rem;">
		<!--头部筛选-->
		<header class="fixed-top lesson-top" style="z-index:999">
			<h4 class="select-title" style="color:#595959; font-weight:normal">请选择答题老师</h4>
		</header>
		<!--老师选择板块-->
		<section class="select-teacher" style="padding-top: 2.65rem;">
			<div class="select-cell app-flex app-vertical-center app-content-justify">
				<h4>方式一：</h4>
				<h5>
					<a href="<?php echo U('Home/Center/myfavar');?>">选择我收藏的老师</a>
				</h5>
			</div>
			<div class="select-cell app-flex app-vertical-center app-content-justify">
				<h4>方式二：</h4>
				<h5>
					<a href="javascript:void(0);">平台为你推荐以下老师</a>
				</h5>
			</div>
			<ul class="teacher-list online-teacher" style="padding-top: 0;">
				<?php if(is_array($tlist)): $i = 0; $__LIST__ = $tlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item app-flex app-vertical-center">
					<a href="<?php echo U('Home/Teacher/teacher_info',array('id'=>$va['id']));?>" class="app-basis app-flex app-vertical-center">
						<div class="teacher-avatar">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="teacher-info app-basis">
							<h4><?php echo ($va["truename"]); ?></h4>
							<div><?php echo ($va["honors"]); ?></div>
							<div>综合评分: <?php echo ($va["star"]); ?></div>
							<div class="teacher-attention-num app-flex">
								<h4><?php echo ($va["qcount"]); ?></h4>
								<h5><?php echo ($va["colcount"]); ?></h5>
							</div>
						</div>
					</a>
					<div class="question-now">
						<a href="<?php echo U('Home/Problem/pub_question',array('id'=>$va['id']));?>">立即提问</a>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<div class="select-cell app-flex app-vertical-center app-content-justify">
				<h4>方式三：</h4>
				<h5>
					<a href="javascript:;" id="choseSub" @click="ismeng='true'">在教师列表中选择</a>
				</h5>
			</div>
		</section>
		<div v-show="ismeng" style="display:block" class="meng1" @click="closeFn($event)"></div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$(function(){
		$("#choseSub").select({
			title: "请选择学科",
			multi: false,
			items: [
				{
				  title: "语文",
				  value: 3
				},
				{
				  title: "数学",
				  value: 4
				},
				{
				  title: "英语",
				  value: 5
				},
				{
				  title: "物理",
				  value: 6
				},
				{
				  title: "化学",
				  value: 7
				},
				{
				  title: "政治",
				  value: 8
				},
				{
				  title: "历史",
				  value: 9
				},
			],
			onChange:function(v,t){
				console.log(v.values);   //value，1，2，3，加入参数
				$(".meng1").hide();
				location.href="<?php echo U('Home/Teacher/index');?>"+"&type="+v.values;
			}
		});
	})
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			data_text:'没有更多了~',
			ismeng:false     //是否显示蒙层
		},
		methods:{		
			closeFn:function(evt){
				var self=this;
				self.ismeng=false;
				$("#choseSub").select("close");
				return
			}
		}
	});
</script>
</html>