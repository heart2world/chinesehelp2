<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>我的收藏</title>
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
	.teacher-list .list-item a:after{display:none}
	.content-list .content-item a:before{ display:none}
	.content-list .content-item a:after{ left:0;right:0}
	.teacher-list .list-item:last-child{border-bottom:1px solid #f0eff4}
</style>
<body data-app="ChineseBang">
	<section id="app">
		<nav class="top-nav app-flex">
			<div :class="{'cur':cur_index == 1}" class="nav-cell app-basis" @click="change_tab($event,'1');">收藏的老师</div>
			<div :class="{'cur':cur_index == 2}" class="nav-cell" @click="change_tab($event,'2');">收藏的回答/微课/资源/专题</div>
		</nav>
		<!--收藏的老师-->
		<ul class="teacher-list" v-if="cur_index == 1">
			<?php if(is_array($collectt)): $i = 0; $__LIST__ = $collectt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item">
				<a href="<?php echo U('Home/Teacher/teacher_info',array('id'=>$va['id']));?>" class="app-flex" style="width:100%">
					<div class="teacher-avatar">
						<img src="<?php echo ($va["headimg"]); ?>" alt="img">
					</div>
					<div class="teacher-info app-basis">
						<h4 style="font-size:.8rem;color:#333"><?php echo ($va["truename"]); ?></h4>
						<p style="font-size:.8rem;color:#999"><?php echo ($va["honors"]); ?></p>
						<p style="font-size:.8rem;color:#999">综合评分: <?php echo ($va["star"]); ?></p>
						<div class="teacher-attention-num app-flex">
							<h4><?php echo ($va["qcount"]); if($va['qcount'] > '999'): ?>+<?php endif; ?></h4>
							<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
						</div>
					</div>
					<div class="favar-btn favared" @click="add_favar_or_cancel($event,'<?php echo ($va["id"]); ?>',1);"></div>
				</a>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<!--收藏的回答/微课/资源-->
		<article class="content-panel hot-panel" v-if="cur_index == 2">
			<ul class="content-list">
				<?php if(is_array($collectelse)): $i = 0; $__LIST__ = $collectelse;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="mrolesson">
					<?php if($va['type'] == '微课'): ?><a href="<?php echo U('Home/Task/lesson_info',array('id'=>$va['id']));?>" class="app-flex">
					<?php else: ?>
					<a href="<?php echo U('Home/Resource/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
						<div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:.8rem; margin-bottom:.2rem"><?php echo ($va["nicename"]); ?></div>
							<div class="ellipsis" style="font-size:.8rem;color:#999; margin-bottom:.2rem"><?php echo ($va["questiontype"]); ?></div>
							<h4 class="app-basis ellipsis" style="font-size:.8rem; margin-bottom:.2rem"><?php echo ($va["title"]); ?></h4>
							<h4 style="font-size:.8rem;color:#999; margin-bottom:.2rem"><?php echo ($va["classtype"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($va["type"]); ?></h4>
							<h5 style="font-size:.8rem;color:#999; margin-bottom:.2rem" class="Line2"> <?php echo ($va["brief"]); ?></h5>
							<div class="content-inner-item app-flex">
								<h4 style="font-size:.8rem;">综合评分 :&nbsp;</h4>
								<h5 style="font-size:.8rem;color:#999" class="app-basis"> 4.8</h5>
							</div>
							<div class="content-info-num3 app-flex" style="overflow:hidden">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><span id="wycolcount"><?php echo ($va["colcount"]); ?></span></h5>
							</div>
						</div>
						<div class="favar-btn favared" @click="add_favar_or_cancel($event,'<?php echo ($va["id"]); ?>',2,'<?php echo ($va["type"]); ?>');"></div>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(is_array($collectzt)): $i = 0; $__LIST__ = $collectzt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="mrolesson">					
					<a href="<?php echo U('Home/Zhuantis/ztinfo',array('id'=>$va['id']));?>" class="app-flex">					
						<div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>">
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:.9rem; margin-bottom:.2rem"><?php echo ($va["nicename"]); ?></div>
							<div class="ellipsis" style="font-size:.8rem;color:#999; margin-bottom:.2rem"><?php echo ($va["questiontype"]); ?></div>
							<h4 class="app-basis ellipsis" style="font-size:.8rem; margin-bottom:.2rem"><?php echo ($va["title"]); ?></h4>							
							<h5 style="font-size:.8rem;color:#999; margin-bottom:.2rem" class="Line2"> <?php echo ($va["brief"]); ?></h5>
							<div class="content-inner-item app-flex">
								<h4 style="font-size:.8rem;">综合评分 :&nbsp;</h4>
								<h5 style="font-size:.8rem;color:#999" class="app-basis"> 4.8</h5>
							</div>
							<div class="content-info-num app-flex app-vertical-center" style="overflow:hidden">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5 id="ztcolcount"><?php echo ($va["colcount"]); ?></h5>
							</div>
						</div>
						<div class="favar-btn favared" @click="add_favar_or_cancel($event,'<?php echo ($va["id"]); ?>',2,'专题');"></div>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(is_array($collectqs)): $i = 0; $__LIST__ = $collectqs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="requestion">
					<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id']));?>" class="app-flex">
						<div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" >
						</div>
						<div class="app-basis" style="width:1%">
							<div class="content-top app-flex app-vertical-center">
								<h4 class="app-basis" style="color:#595959"><?php echo ($va["nicename"]); ?></h4>
								<h5>问答</h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4 class="app-basis" style="color:#595959"><?php echo ($va["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4>回答满意度:  <span><?php echo ($va["star"]); ?></span></h4>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5 id="wdcolcount"><?php echo ($va["colcount"]); ?></h5>
							</div>
						</div>
						<div class="favar-btn favared" @click="add_favar_or_cancel($event,'<?php echo ($va["id"]); ?>',2,'问答');"></div>
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
			},
			add_favar_or_cancel:function(evt,taskid,type,typename)
			{
				evt.preventDefault();
				if(type==1){    //收藏的老师
					if($(evt.target).hasClass('favared')){
						//数据操作
						$.ajax({
							url:"<?php echo U('Home/Problem/collect');?>",
							data:{taskid:taskid,type:2},
							type:'POST',
							success: function (data) {
								if(data.status == 1)
								{
									$(evt.target).removeClass("favared");
									$.toast("你已取消对TA的收藏",3000);
								}
							}
						})					
					}else{
						//数据操作					
						$.ajax({
							url:"<?php echo U('Home/Problem/collect');?>",
							data:{taskid:taskid,type:1},
							type:'POST',
							success: function (data) {
								if(data.status == 1)
								{
									$(evt.target).addClass("favared");
									$.toast("你已成功收藏TA~",3000);
								}
							}
						})
					}
				}
				else{    //收藏的回答/微课/资源/专题
					if($(evt.target).hasClass('favared')){
						//数据操作
						$.ajax({
							url:"<?php echo U('Home/Center/collect');?>",
							data:{taskid:taskid,type:2,typename:typename},
							type:'POST',
							success: function (data) {
								if(data.status == 1)
								{
									if(data.typename=='专题')
									{
										$("#ztcolcount").html(data.collectnum);
									}else if(data.typename =='问答')
									{
										$("#wdcolcount").html(data.collectnum);
									}else
									{
										$("#wycolcount").html(data.collectnum);
									}
									$(evt.target).removeClass("favared");
									$.toast("你已取消对TA的收藏",3000);
								}
							}
						})					
					}else{
						//数据操作					
						$.ajax({
							url:"<?php echo U('Home/Center/collect');?>",
							data:{taskid:taskid,type:1,typename:typename},
							type:'POST',
							success: function (data) {
								if(data.status == 1)
								{
									if(data.typename=='专题')
									{
										$("#ztcolcount").html(data.collectnum);
									}else if(data.typename =='问答')
									{
										$("#wdcolcount").html(data.collectnum);
									}else
									{
										$("#wycolcount").html(data.collectnum);
									}
									$(evt.target).addClass("favared");
									$.toast("你已成功收藏TA~",3000);
								}
							}
						})
					}
				}
				
			}
		}
	});
</script>
</html>