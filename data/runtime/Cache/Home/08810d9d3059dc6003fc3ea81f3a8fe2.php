<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>好问达</title>
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
	.selectSub{ background:#fff;border-radius:20px; padding:.2rem 1rem .2rem .5rem; background:url(/public/assets/xiala@2x.png) #fff no-repeat 93% center; background-size:9px}
	.selectSub select{ border:0; text-align:center;appearance:none; -moz-appearance:none; -webkit-appearance:none; outline:none;font-size:.8rem}
</style>
<body data-app="ChineseBang">
	<section id="app" style="padding-bottom: 3rem;">
		<!--头部筛选-->
		<header class="fixed-top lesson-top app-flex app-vertical-center app-content-justify" style="background:#f2f2f2; height:2rem;padding-top:0">
			<div class="selectSub">
				<select id="xueke" onchange="changexk(this.value)">
					<option value="" data-type="0">全部学科</option>
					<option value="语文">语文</option>
					<option value="数学">数学</option>
					<option value="英语">英语</option>
					<option value="物理">物理</option>
					<option value="化学">化学</option>
					<option value="政治">政治</option>
					<option value="历史">历史</option>
				</select>
			</div>
			<div class="search-item app-basis">
				<input type="text" placeholder="请在此输入您的问题" v-model="keywords" />
				<div v-if="keywords !=''" class="clear" @click="keywords=''" v-cloak></div>
			</div>
			<div class="search-btn" @click="search($event);">搜索</div>
		</header>
		<section style="padding-top:2rem">
			<div class="lesson-null app-flex app-flex-y app-vertical-center app-hrizontal-center" id="app_hrizontal_center"  style="display: none;">
				<h4 style="font-size:.8rem;line-height:4rem">暂无该问题相关问答</h4>
				<!--<p style="font-size:.8rem">你可直接向老师提问</p>-->
				<div class="pub-btn" style="margin-top:0">
					<a class="tiwen" @click="zjtw($event)" href="javascript:;">">直接提问</a>
				</div>
			</div>

			<div class="pub-btn alone-btn" id="alone_btn">
				<a class="tiwen" @click="zjtw($event)" href="javascript:;">直接提问</a>
			</div>
			<input type="hidden" class="twhref" value="<?php echo U('Home/Problem/online_select_teacher');?>"/>
			<div class="content-list" id="questionlist">
			</div>		
			<!--<section class="online-teacher online-pub" id="online_pub" style="display: none;">
				<div class="title-panel app-flex app-vertical-center app-content-justify">
					<h4>类似问题</h4>
				</div>
				<ul class="content-list">
					<?php if(is_array($qrlist)): $i = 0; $__LIST__ = $qrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="requestion">
						<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id']));?>" class="app-flex app-vertical-center">
							<div class="student-avatar" style="float:left">
								<img src="<?php echo ($va["headimg"]); ?>" alt="img">
							</div>
							<div class="student-info app-basis" style="width:1%">
								<h4 style="font-size:1rem; color:#333"><?php echo ($va["mnicename"]); ?><span style="float:right; line-height:27px; font-size:.8rem;color:#999"><?php echo (date('Y-m-d',$va["addtime"])); ?></span></h4>
								<h4 style="font-size:.9rem;color:#999; white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo ($va["title"]); ?></h4>
								<h4 style="font-size:.9rem;color:#999">回答满意度:<?php echo ($va["star"]); ?></h4>
								<div class="content-info-num2 app-flex app-vertical-center">
									<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
									<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
								</div>
							</div>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<!--<div class="more">
					<a href="<?php echo U('Home/index/hotrecommend');?>">查看更多</a>
				</div>-->
			<!--</section>-->

			<!--<section class="online-teacher" id="online_teacher" style="display: none;">
				<div class="title-panel app-flex app-vertical-center app-content-justify">
					<h4>直接向在线老师提问</h4>
				</div>
				<ul class="teacher-list" style="padding-top: 0;">
					<?php if(is_array($tlist)): $i = 0; $__LIST__ = $tlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item app-flex app-vertical-center">
						<a href="<?php echo U('Home/Teacher/teacher_info',array('id'=>$va['id']));?>" class="app-basis app-flex app-vertical-center">
							<div class="teacher-avatar">
								<img src="<?php echo ($va["headimg"]); ?>" alt="img">
							</div>
							<div class="teacher-info app-basis">
								<div class="titName"><?php echo ($va["nicename"]); ?></div>
								<div><?php echo ($va["honors"]); ?></div>
								<div>综合评分: <?php echo ($va["star"]); ?></div>
								<div class="teacher-attention-num app-flex">
									<h4><?php echo ($va["qcount"]); if($va['qcount'] > '999'): ?>+<?php endif; ?></h4>
									<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
								</div>
							</div>
						</a>
						<div class="question-now">
							<a href="<?php echo U('Home/Problem/pub_question',array('id'=>$va['id']));?>">立即提问</a>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				

			</section>-->
			<div class="data-text" id="data_text" style="display: none;" v-text="data_text"></div>
			<div v-if="show_layer" class="cover-layer transparent" @click="show_layer=false;cur_index = '0'"></div>
		</section>
	</section>
	<!--应用固定导航-->
	<section class="app-nav app-flex">
		<a class="app-basis" href="./" data-home>
			<p>首页</p>
		</a>
		<a class="app-basis active" href="<?php echo U('Home/Problem/pub');?>" data-twen>
			<p>我要提问</p>
		</a>
		<a class="app-basis" href="<?php echo U('Home/Center/index');?>" data-centre>
			<p>个人中心</p>
		</a>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	function changexk(val){
		console.log(val);
		var hrefs=$('.twhref').val();
		$('.tiwen').attr("href",hrefs+"&xk="+val);
		console.log($('.tiwen').attr('href'));
	}
	
	var app = new Vue({
		el:'#app',
		data:{
			cur_index:0,
			title:'课程类型',
			show_layer:false,
			keywords:'',
			data_text:'没有更多了~',
			xktype:0
		},
		methods:{
			search:function(evt){
				if(this.keywords == '')
				{
					$.toast("请输入您的问题","forbidden");
					return;
				}
				$.showLoading("正在搜索...");
				$.ajax({
					url:"<?php echo U('Home/Problem/searchquestion');?>",
					data:{keywords:this.keywords,xueke:$("#xueke").val()},
					type:'POST',
					success:function(data){
						if(data.status==1)
						{
							$("#online_pub").css("display","block");
							$("#online_teacher").css("display","block");
							$("#alone_btn").css('display',"none");
							$("#app_hrizontal_center").css("display","none");
							$("#data_text").css("display","block");
							$("#questionlist").html(data.html);
						}else
						{
							$("#app_hrizontal_center").show();
							$("#online_teacher").css("display","block");
							$("#alone_btn").css('display',"none");
							$("#questionlist").css("display","none");
						}
						//调用数据
						setTimeout(function(){
							$.hideLoading();
						},750);
					}
				})
				
			},
			zjtw:function(evt){
				var self=this;
				if($('.tiwen').attr("href")=='javascript:;'){
					$.toast("请选择学科","forbidden");
				}
			}
		}
	});
</script>
</html>