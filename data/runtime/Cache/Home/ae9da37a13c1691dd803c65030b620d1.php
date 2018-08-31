<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>平台精选</title>
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
		<article class="content-panel">
			<ul class="content-list">
				<?php if(is_array($indexlist)): $i = 0; $__LIST__ = $indexlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == '微课'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Task/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] == '专题'): ?><li class="content-item" data-type="mrolesson">
					<a href="#" class="app-flex"><?php endif; ?>					
					<?php if($va['type'] == '资源'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Resource/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] == '问答'): ?><li class="content-item" data-type="requestion">
					<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] != '问答'): ?><div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" />
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:0.9rem;margin-bottom:.2rem"><?php echo ($va["username"]); ?></div>
							<div class="ellipsis" style="color:#999;font-size:.8rem;margin-bottom:.2rem"><?php echo ($va["questiontype"]); ?></div>
							<h4 class="ellipsis" style="font-size:.8rem;margin-bottom:.2rem"><?php echo ($va["title"]); ?></h4>
							<h4 style="color:#999;font-size:.8rem;margin-bottom:.2rem"><?php echo ($va["classtype"]); ?>&nbsp;&nbsp;<?php echo ($va["type"]); ?></h4>
							<h5 class="Line2" style="color:#999;font-size:.8rem;margin-bottom:.2rem"><?php echo ($va["brief"]); ?></h5>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</div>
					<?php else: ?>
						<div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" />
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:0.9rem"><?php echo ($va["username"]); ?> <span style="color:#999;font-size:0.8rem;">问答</span></div>
							<h4 class="app-basis">《<?php echo ($va["title"]); ?>》</h4>
							<div class="content-inner-item app-flex">
								<h4>回答满意度:  <span><?php echo ($va["brief"]); ?></span></h4>
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
			cur_index:0,
			title:'课程类型',
			show_layer:false,
			keywords:'',
			data_text:'没有更多了~'

		},
		methods:{
			switch_tab:function(evt,index){
				if(this.cur_index == index){
					this.cur_index = 0;
					this.show_layer = false;
				}else{
					this.cur_index = index;
					this.show_layer = true;
				}
				
			},
			change_lesson:function(evt){
				evt.stopPropagation();
				var val = evt.currentTarget.dataset['item'];
				this.title = val;
				this.cur_index = 0;
				this.show_layer = false;
			},
			search:function(evt){
				$.showLoading("正在搜索...");

				//调用数据
				setTimeout(function(){
					$.hideLoading();
				},750);
			}
		}
	});
</script>
</html>