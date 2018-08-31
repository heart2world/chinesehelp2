<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>热门推荐</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="语文帮">
	<meta name="format-detection" content="telephone=no,address=no,email=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="renderer" content="webkit">
	<meta name="HandheldFriendly" content="true">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="full-screen" content="yes">
	<meta name="keywords" content="语文帮学生端">
	<meta name="description" content="语文帮学生端">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<style>
	.content-list .content-item a:before{ display:none}
	.content-list .content-item a:after{ left:0;right:0}
	.content-inner-item>h4,.content-inner-item>h5{ font-size:.8rem}
</style>
<body data-app="ChineseBang">
	<section id="app">
		<nav class="top-nav app-flex">
			<div :class="{'cur':cur_index == 1}" class="nav-cell app-basis" @click="change_tab($event,'1');">本周最新</div>
			<div :class="{'cur':cur_index == 2}" class="nav-cell app-basis" @click="change_tab($event,'2');">围观最多</div>
		</nav>
		<article v-if="cur_index == 1" class="content-panel hot-panel">
			<ul class="content-list">
				<?php if(is_array($indexlist2)): $i = 0; $__LIST__ = $indexlist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == '微课'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Task/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>					
					<?php if($va['type'] == '资源'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Resource/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] == '问答'): ?><li class="content-item" data-type="requestion">
					<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] != '问答'): ?><div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="app-basis" style="width:1%">
							<div class="content-top app-flex app-vertical-center">
								<h4 class="app-basis ellipsis" style="margin-right:1rem;color:#595959"><?php echo ($va["title"]); ?></h4>
								<h5><?php echo ($va["type"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4><?php echo ($va["type"]); ?>类型 :&nbsp;</h4>
								<h5 class="app-basis"><?php echo ($va["classtype"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4><?php echo ($va["type"]); ?>简介 :&nbsp;</h4>
								<h5 class="app-basis"><?php echo ($va["brief"]); ?></h5>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($info['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</div>
					<?php else: ?>			
						<div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:.9rem"><?php echo ($va["username"]); ?> <span style="color:#999;font-size:0.8rem;">问答</span></div>
							<div class="content-top1 app-flex app-vertical-center">
								<h4 class="app-basis"><?php echo ($va["title"]); ?></h4>
								
							</div>
							<div class="content-inner-item app-flex">
								<h4>回答满意度:  <span><?php echo ($va["brief"]); ?></span></h4>
							</div>
							<div class="content-info-num3 app-flex app-vertical-center" style="margin-top:.5rem">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</div><?php endif; ?>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</article>
		<article v-if="cur_index == 2" class="content-panel hot-panel">
			<ul class="content-list">
				<?php if(is_array($indexlist)): $i = 0; $__LIST__ = $indexlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == '微课'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Task/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>					
					<?php if($va['type'] == '资源'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Resource/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] == '问答'): ?><li class="content-item" data-type="requestion">
					<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] != '问答'): ?><div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:.9rem"><?php echo ($va["truename"]); ?></div>
							<h4 class="ellipsis" style="font-size:.8rem;color:#999"><?php echo ($va["questiontype"]); ?></h4>
							<h4 class="ellipsis" style="color:#595959; font-size:.9rem"><?php echo ($va["title"]); ?></h4>
							<h5 class="app-basis" style="font-size:.8rem;color:#999;margin:5px 0"><?php echo ($va["classtype"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($va["type"]); ?></h5>
							<h5 class="Line2" style="color:#999;font-size:.8rem;"><?php echo ($va["brief"]); ?></h5>
						<div class="content-info-num2 app-flex app-vertical-center">
							<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
							<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
						</div>
						</div>
					<?php else: ?>
						<div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="app-basis" style="width:1%">
							<div class="content-top app-flex app-vertical-center">
								<h4 class="app-basis ellipsis" style="color:#595959; font-size:.9rem;margin-right:1rem"><?php echo ($va["title"]); ?></h4>
								<h5>问答</h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4 style="font-size:.8rem">回答满意度 :  <span style="color:#999"><?php echo ($va["brief"]); ?></span></h4>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</div><?php endif; ?>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</article>
		<div class="data-text" v-text="data_text"></div>
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
			data_text:'没有更多了~'

		},
		methods:{
			change_tab:function(evt,index){
				this.cur_index = index;
			}
		}
	});
</script>
</html>