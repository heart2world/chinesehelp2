<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>专题列表</title>
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
	<link rel="stylesheet" href="public/style/base.min.css">
	<link rel="stylesheet" href="public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="public/libs/weui/jquery-weui.css">
	<link rel="stylesheet" href="public/style/app.css">
	<script src="public/libs/jq.min.js"></script>
	<script src="public/libs/v.min.js"></script>
</head>
<style>
	#app_hrizontal_center{ padding:1rem 0; border-bottom:1px solid #f0eff4}
	.content-list .content-item a{ display:block}
	.content-item .content-inner-item h4{font-size:.8rem;margin-right:5px}
	.content-item .content-inner-item h5,.content-item .content-inner-item h4>span{font-size:.8rem;color:#999}
	.weui-btn_primary{ background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
</style>
<body data-app="ChineseBang">
	<section id="app" style="padding-bottom: 2rem;">
		<!--头部筛选-->
		<header class="fixed-top lesson-top app-flex app-vertical-center app-content-justify" style="background:#f2f2f2; height:2rem">
			<div class="search-item app-basis">
				<input type="text" placeholder="请输入专题名称" v-model="keywords" />
				<div v-if="keywords !=''" class="clear" @click="keywords=''" v-cloak></div>
			</div>
			<div class="search-btn" @click="search($event);">搜索</div>
		</header>
		<section style="padding-top:2rem" >
			<div class="lesson-null app-flex app-flex-y app-vertical-center app-hrizontal-center" id="app_hrizontal_center"  <?php if(count($list) > 0): ?>style="display: none;"<?php endif; ?>>
				<h4 style="font-size:.8rem;padding:.5rem 0">暂无该专题~</h4>
				<p style="font-size:.8rem">你可向在线老师发起提问</p>
			</div>
			<section class="content-module">
				<!--题库-->
				<article class="content-panel">
					<ul class="content-list" id="ztlist" <?php if(count($list) == 0): ?>style="display: none;"<?php endif; ?>>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="mrolesson">
							<a href="<?php echo U('Home/Zhuantis/ztinfo',array('id'=>$va['id']));?>" class="app-flex" style="display:flex">
								<div class="headImg">
									<img src="<?php echo ($va["headimg"]); ?>" alt="img">
								</div>
								<div class="app-basis" style="width:1%">
									<div style="font-size:.8rem"><?php echo ($va["truename"]); ?></div>							
									<h4 class="ellipsis" style="font-size:.8rem;color:#999"><?php echo ($va["questiontype"]); ?></h4>
									<div class="ellipsis" style="font-size:.8rem"><?php echo ($va["title"]); ?></div>							
									<h5 style="font-size:.8rem;color:#999;">专题简介 :&nbsp;<?php echo ($va["desc"]); ?></h5>
									<h5 class="Line2" style="color:#999;font-size:.8rem;">专题评分 :&nbsp;<?php if($va['compoint'] != '0.0'): echo ($va["compoint"]); else: ?>暂无评分<?php endif; ?></h5>
									<div class="content-info-num3 app-flex app-vertical-center" style="margin-top:.5rem">
										<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
										<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
									</div>
								</div>
							</a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</article>
			</section>
		
			<section class="online-teacher" id="online_teacher" <?php if(count($list) > 0): ?>style="display: none;"<?php endif; ?>>
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
								<div>专题评分: <?php if($va['star'] != '0.0'): echo ($va["star"]); else: ?>暂无评分<?php endif; ?></div>
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
			</section>
			<div class="data-text" id="data_text" v-text="data_text"></div>
			<!--<div v-if="show_layer" class="cover-layer transparent" @click="show_layer=false;cur_index = '0'"></div>-->
		</section>
	</section>
</body>
<script src="public/libs/fixed.js"></script>
<script src="public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			cur_index:0,
			title:'课程类型',
			show_layer:false,
			keywords:'',
			data_text:'没有更多了~'

		},
		methods:{
			search:function(evt){
				if(this.keywords == '')
				{
					$.toast("请输入专题","forbidden");
					return;
				}
				$.showLoading("正在搜索...");
				$.ajax({
					url:"<?php echo U('Home/Zhuantis/searchztlist');?>",
					data:{keywords:this.keywords},
					type:'POST',
					success:function(data){
						if(data.status==1)
						{
							$("#online_pub").css("display","block");
							$("#online_teacher").css("display","block");
							$("#alone_btn").css('display',"none");
							$("#app_hrizontal_center").css("display","none");
							$("#data_text").css("display","block");
							$("#ztlist").html(data.html);
						}else
						{
							$("#app_hrizontal_center").show();
							$("#online_teacher").css("display","block");
							$("#alone_btn").css('display',"none");
							$("#ztlist").css("display","none");
						}
						//调用数据
						setTimeout(function(){
							$.hideLoading();
						},750);
					}
				})
				
			}
		}
	});
</script>
</html>