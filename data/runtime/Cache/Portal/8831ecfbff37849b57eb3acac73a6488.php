<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>我的解答</title>
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
<body data-app="ChineseBang">
	
	<section id="app">
		<nav class="top-nav app-flex">
			<div :class="{'cur':cur_index == 1}" class="nav-cell app-basis" @click="change_tab($event,'1');">待解答</div>
			<div :class="{'cur':cur_index == 2}" class="nav-cell app-basis" @click="change_tab($event,'2');">我的解答</div>
		</nav>	
		<!--待解答-->
		<section v-if="cur_index == 1" class="problem-container" v-cloak>
			<ul class="problem-ull">
				<?php if(is_array($unlist)): $i = 0; $__LIST__ = $unlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="problem-item">
					<a href="<?php echo U('Portal/Problem/answerinfo',array('id'=>$va['id']));?>">
						<div class="problem-top app-flex">
							<h4 class="app-basis" style="font-size:.8rem;line-height:1.7rem;color:#595959"><?php echo (date('Y-m-d',$va["addtime"])); ?></h4>
							<h5>待解答</h5>
						</div>
						<div class="problem-info">
							<p class="ellipsis" style="font-size:.8rem"><?php echo ($va["title"]); ?></p>
						</div>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</section>
		<!--我的解答-->
		<section v-if="cur_index == 2" class="problem-container" v-cloak>
			<ul class="problem-ull">
				<?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="problem-item">
					<a href="<?php echo U('Portal/Problem/detail',array('id'=>$va['id']));?>">
						<div class="problem-top app-flex">
							<h4 class="app-basis" style="font-size:.8rem;line-height:1.7rem;color:#595959"><?php echo (date('Y-m-d',$va["addtime2"])); ?></h4>
							<h5><?php if($va['isfree'] == 1): ?>私密回答<?php endif; if($va['isfree'] == 2): ?>公开回答<?php endif; if($va['isfree'] == 0): ?>请选择<?php endif; ?></h5>
						</div>
						<div class="problem-info">
							<p style="font-size:.8rem"><?php echo ($va["title"]); ?></p>
							<p style="font-size:.8rem;">回答满意度 : <span style="color:#999"><?php echo ($va["star"]); ?></span></p>
							<p class="problem-info-num">
								<span class="ck"><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></span>
								<span class="sc"><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></span>
							</p>
						</div>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>				
			</ul>
		</section>	
		<div v-if="cur_index == 1" class="data-text" v-text="data_text"></div>
		<div v-if="cur_index == 2" class="data-text" v-text="data_text"></div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			cur_index:sessionStorage.getItem("status") ? sessionStorage.getItem("status") : 1,
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