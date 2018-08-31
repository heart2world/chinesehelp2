<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>教师列表</title>
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
	.teacher-list .list-item a:after{background:#f0eff4; left:0;right:0}
</style>
<body data-app="ChineseBang">
	<section id="app">
		<!--头部筛选-->
		<header class="fixed-top app-vertical-center app-content-justify">
			<!--<div class="filter-item app-flex app-vertical-center">
				<span class="" @click="switch_tab($event,'1');" style="max-width: 2rem;">职称</span><i></i>
				<ul v-if="cur_index == 1" class="filter-list" v-cloak>
					<li @click="change_honor($event);" data-item="初级教师">初级教师</li>
					<li @click="change_honor($event);" data-item="中级教师">中级教师</li>
					<li @click="change_honor($event);" data-item="高级教师">高级教师</li>
					<li @click="change_honor($event);" data-item="特级教师">特级教师</li>
					<li @click="change_honor($event);" data-item="研究员">研究员</li>
				</ul>
			</div>-->
			<div class="filter-item app-flex app-vertical-center">
				<span class="ellipsis app-basis" @click="switch_tab($event,'2');" v-text="grade"></span><i></i>
				<ul v-if="cur_index == 2" class="filter-list" v-cloak>
					<li @click="change_grade($event);" data-item="市级重点中学">市级重点中学</li>
					<li @click="change_grade($event);" data-item="区、县级普通中学">区、县级普通中学</li>
					<li @click="change_grade($event);" data-item="区、县级重点中学">区、县级重点中学</li>
				</ul>
			</div>
			<div class="filter-item app-flex app-vertical-center">
				<span class="ellipsis app-basis" @click="switch_tab($event,'3');" v-text="goodat">教师擅长</span><i></i>
				<ul v-if="cur_index == 3" class="filter-list" v-cloak>
					<?php if(is_array($qtypelist)): $i = 0; $__LIST__ = $qtypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li @click="change_goodat($event);" data-item="<?php echo ($val["typename"]); ?>"><?php echo ($val["typename"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<div class="filter-item app-flex app-vertical-center lastBox">
				<span class="ellipsis app-basis" @click="switch_tab($event,'4');"v-text="qnum">本周答题数</span><i></i>
				<ul v-if="cur_index == 4" class="filter-list" v-cloak>
					<li @click="change_qnum($event);" data-item="20-200">20以上</li>
					<li @click="change_qnum($event);" data-item="15-20">15-20</li>
					<li @click="change_qnum($event);" data-item="11-15">11-15</li>
					<li @click="change_qnum($event);" data-item="6-10">6-10</li>
					<li @click="change_qnum($event);" data-item="0-5">0-5</li>
				</ul>
			</div>
			<input type="hidden" id="type" value="<?php echo ($type); ?>">
		</header>
		<!--教师列表-->
		<ul class="teacher-list" id="teacherlist">
			<?php if(is_array($tlist)): $i = 0; $__LIST__ = $tlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item">
				<a href="<?php echo U('Home/Teacher/teacher_info',array('id'=>$va['id']));?>" class="app-flex" style="width:100%">
					<?php if($va['isonline'] == 1): ?><div class="teacher-avatar"><?php endif; ?>
					<?php if($va['isonline'] == 2): ?><div class="teacher-avatar busy"><?php endif; ?>
					<?php if($va['isonline'] == 3): ?><div class="teacher-avatar offline"><?php endif; ?>
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
					<?php if($va['iscollect'] == 0): ?><div class="favar-btn" @click="add_favar_or_cancel($event,'<?php echo ($va["id"]); ?>');"></div>
					<?php else: ?>
					<div class="favar-btn favared" @click="add_favar_or_cancel($event,'<?php echo ($va["id"]); ?>');"></div><?php endif; ?>
				</a>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<div class="data-text" id="data_text">没有更多了~</div>
		<div v-if="show_layer" class="cover-layer transparent" @click="show_layer=false;cur_index = '0'"></div>
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
			title:'职称',
			grade:'学校等级',
			goodat:'教师擅长',
			qnum:'本周答题数',
			show_layer:false
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
			change_honor:function(evt){
				evt.stopPropagation();
				var val = evt.currentTarget.dataset['item'];
				this.title = val;
				this.cur_index = 0;
				this.show_layer = false;
				$.showLoading("加载中...");
				$.ajax({
					url: "<?php echo U('Home/Teacher/getteacherlist');?>",
                    data: {title:this.title,schoolname:this.grade,questiontype:this.goodat,number:this.qnum,type:$("#type").val()},
                    type:'POST',
                    success: function (data) {
                    	if(data.status==1)
                    	{
							$.hideLoading();
                    		document.getElementById('teacherlist').innerHTML =data.html;
                    	}
                    }
				})
			},
			change_grade:function(evt){
				evt.stopPropagation();
				var val = evt.currentTarget.dataset['item'];
				this.grade = val;
				this.cur_index = 0;
				this.show_layer = false;
				$.showLoading("加载中...");
				$.ajax({
					url: "<?php echo U('Home/Teacher/getteacherlist');?>",
                    data: {title:this.title,schoolname:this.grade,questiontype:this.goodat,number:this.qnum,type:$("#type").val()},
                    type:'POST',
                    success: function (data) {
                    	if(data.status==1)
                    	{
							$.hideLoading();
							console.log(data);
                    		document.getElementById('teacherlist').innerHTML =data.html;
                    	}
                    }
				})
			},
			change_goodat:function(evt){
				evt.stopPropagation();
				var val = evt.currentTarget.dataset['item'];
				this.goodat = val;
				this.cur_index = 0;
				this.show_layer = false;
				$.showLoading("加载中...");
				$.ajax({
					url: "<?php echo U('Home/Teacher/getteacherlist');?>",
                    data: {title:this.title,schoolname:this.grade,questiontype:this.goodat,number:this.qnum,type:$("#type").val()},
                    type:'POST',
                    success: function (data) {
                    	if(data.status==1)
                    	{
							$.hideLoading();
                    		document.getElementById('teacherlist').innerHTML =data.html;
                    	}
                    }
				})
			},
			change_qnum:function(evt){
				evt.stopPropagation();
				var val = evt.currentTarget.dataset['item'];
				this.qnum = val;
				this.cur_index = 0;
				this.show_layer = false;
				$.showLoading("加载中...");
				$.ajax({
					url: "<?php echo U('Home/Teacher/getteacherlist');?>",
                    data: {title:this.title,schoolname:this.grade,questiontype:this.goodat,number:this.qnum,type:$("#type").val()},
                    type:'POST',
                    success: function (data) {
                    	if(data.status==1)
                    	{
							$.hideLoading();
                    		document.getElementById('teacherlist').innerHTML =data.html;
                    	}
                    }
				})
			},
			add_favar_or_cancel:function(evt,teacherid){
				console.log(evt);
				evt.preventDefault();
				evt.stopPropagation();
				if($(evt.target).hasClass('favared')){
					//数据操作
					$.ajax({
						url:"<?php echo U('Home/Problem/collect');?>",
						data:{taskid:teacherid,type:2},
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
						data:{taskid:teacherid,type:1},
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
		}
	});
</script>
</html>