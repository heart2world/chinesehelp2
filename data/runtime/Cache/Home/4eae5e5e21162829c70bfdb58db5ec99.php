<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>教师信息</title>
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
	.content-list .content-item a:before{ display:none;}
	.teacher-navbar:after{ display:none}
	.teacher-navbar{ border-bottom:1px solid #f0eff4}
	.content-list .content-item .content-top1 h4{font-size:.8rem}
	.teacher-navbar .navbar-item{font-size:.8rem;padding:0 .4rem}
	.content-list .content-item a:after{ left:0;right:0}
</style>
<style>
	.content-list .content-item a{ display:block}
	.content-item .content-inner-item h4{font-size:.8rem;margin-right:5px}
	.content-item .content-inner-item h5,.content-item .content-inner-item h4>span{font-size:.8rem;color:#999}
	.weui-btn_primary{ background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
	.weui-btn-area{ margin:0;padding:15px}
</style>
<body data-app="ChineseBang">
	<section id="app" class="pdbtm" style="padding-bottom:0">
		<!--教师头部信息-->
		<header class="teacher-hd-info" style="padding:0">
			<div class="teacher-top app-flex app-vertical-center" style="padding: .5rem 1rem 0">
				<div class="teacher-image">
					<img src="<?php echo ($tinfo["headimg"]); ?>" alt="img">
				</div>
				<div class="info-content app-basis">
					<h4><?php echo ($tinfo["truename"]); ?></h4>
					<div class="info-btm app-flex">
						<h4 class="dati"><?php echo ($tinfo["qcount"]); ?></h4>
						<h5 class="sc" id="colcount"><?php echo ($tinfo["colcount"]); ?></h5>
					</div>
				</div>
				<?php if($tinfo['iscollect'] == 0): ?><div class="favar-btn" @click="add_favar_or_cancel($event,'<?php echo ($tinfo["id"]); ?>');"></div>
				<?php else: ?>
				<div class="favar-btn favared" @click="add_favar_or_cancel($event,'<?php echo ($tinfo["id"]); ?>');"></div><?php endif; ?>
			</div>
			<aside class="teacher-detail-info" style="padding:.5rem 1rem">
				<div class="info-cell app-flex">
					<h4>教<span class="zhanwei">占位</span>龄 :  </h4>
					<h5><?php echo ($tinfo["seniority"]); ?>年</h5>
				</div>
				<div class="info-cell app-flex">
					<h4>职<span class="zhanwei">占位</span>称 :  </h4>
					<h5><?php echo ($tinfo["title"]); ?></h5>
				</div>
				<div class="info-cell app-flex">
					<h4>所在学校 : </h4>
					<h5 class="app-basis"><?php echo ($tinfo["schoolname"]); ?></h5>
				</div>
				<div class="info-cell app-flex">
					<h4>擅长题型 : </h4>
					<h5 class="app-basis"><?php echo ($tinfo["questiontype"]); ?></h5>
				</div>
				<div class="info-cell app-flex">
					<h4>所获荣誉 : </h4>
					<h5 class="app-basis"><?php echo ($tinfo["honors"]); ?></h5>
				</div>
			</aside>
		</header>
		<!--教师导航-->
		<nav class="teacher-navbar app-flex">
			<div :class="{'cur':cur_index == 1}" class="navbar-item app-basis" @click="cur_index = 1">TA的问答</div>
			<div :class="{'cur':cur_index == 3}" class="navbar-item app-basis" @click="cur_index = 3">TA的微课</div>
			<div :class="{'cur':cur_index == 2}" class="navbar-item app-basis" @click="cur_index = 2">TA的资源</div>
			<div :class="{'cur':cur_index == 4}" class="navbar-item app-basis" @click="cur_index = 4">TA的专题</div>
		</nav>

		<!--内容板块-->
		<section class="content-module">
			<!--题库-->
			<article v-if="cur_index == 1" class="content-panel">
				<ul class="content-list">
					<?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="requestion">
						<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id'],'tid'=>$tinfo['id']));?>">
							<div class="content-top1 app-flex app-vertical-center">
								<h4 class="app-basis"><?php echo ($va["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4>回答满意度 :  <span><?php echo ($va["star"]); ?></span></h4>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</article>
			<!--资源-->
			<article v-if="cur_index == 2" class="content-panel">
				<ul class="content-list">
					<?php if(is_array($zylist)): $i = 0; $__LIST__ = $zylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="resource">
						<a href="<?php echo U('Home/Resource/lesson_info',array('id'=>$va['id']));?>">
							<div class="content-top1 app-flex app-vertical-center">
								<h4 class="app-basis"><?php echo ($va["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4>资源类型 : </h4>
								<h5 class="app-basis"><?php echo ($va["classtype"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4>资源简介 : </h4>
								<h5 class="app-basis"><?php echo ($va["brief"]); ?></h5>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</article>
			<!--微课-->
			<article v-if="cur_index == 3" class="content-panel">
				<ul class="content-list">
					<?php if(is_array($wklist)): $i = 0; $__LIST__ = $wklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="mrolesson">
						<a href="<?php echo U('Home/Task/lesson_info',array('id'=>$va['id']));?>">
							<div class="content-top1 app-flex app-vertical-center">
								<h4 class="app-basis"><?php echo ($va["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4>微课类型 :  </h4>
								<h5 class="app-basis"><?php echo ($va["classtype"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4>课程简介 :  </h4>
								<h5 class="app-basis"><?php echo ($va["brief"]); ?></h5>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</article>
			<article v-if="cur_index == 4" class="content-panel">
				<ul class="content-list">
					<?php if(is_array($ztlist)): $i = 0; $__LIST__ = $ztlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="mrolesson">
						<a href="<?php echo U('Home/Zhuantis/ztinfo',array('id'=>$va['id']));?>">
							<div class="content-top1 app-flex app-vertical-center">
								<h4 class="app-basis"><?php echo ($va["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4>专题简介 :  </h4>
								<h5 class="app-basis Line2"><?php echo ($va["desc"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4>专题评分 :  </h4>
								<h5 class="app-basis"><?php if($va['compoint'] != '0.0'): echo ($va["compoint"]); else: ?>暂无评分<?php endif; ?></h5>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</article>
		</section>
		
		<!--<div class="btm-btn">
			<a class="question-now" href="<?php echo U('Home/Problem/pub_question',array('id'=>$tinfo['id']));?>">立即提问</a>
		</div>-->
		<div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="<?php echo U('Home/Problem/pub_question',array('id'=>$tinfo['id']));?>">提问</a>
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
			cur_index:1,
			data_text:'没有更多了~~',
			show_layer:false

		},
		methods:{
			
			add_favar_or_cancel:function(evt,teacherid){
				console.log(evt);
				if($(evt.target).hasClass('favared')){
					//数据操作
					$.ajax({
						url:"<?php echo U('Home/Problem/collect');?>",
						data:{taskid:teacherid,type:2},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
								$("#colcount").html(data.collectnum);
                        		$(evt.target).removeClass("favared");
								$.toast("你已取消对TA的收藏",3000);
                        	}
                        }
					})
				}else{
					//数据操作
					$.ajax({
						url:"<?php echo U('Home/Problem/collect');?>",
						data:{taskid:teacherid,type:1},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
								$("#colcount").html(data.collectnum);
                        		$(evt.target).addClass("favared");
								$.toast("你已成功收藏TA~",3000);
                        	}
                        }
					})
				}
			}
		}
	});
</script>
</html>