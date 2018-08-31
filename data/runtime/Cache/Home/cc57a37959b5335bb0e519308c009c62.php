<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>微课列表</title>
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
#noclass{padding:3.5rem 0 1rem;font-size:.8rem;border-bottom:1px solid #f0eff4}
</style>
<body data-app="ChineseBang">
	<section id="app">
		<!--头部筛选-->
		<header class="fixed-top lesson-top app-flex app-vertical-center app-content-justify" style="background:#f2f2f2">
			<div class="filter-item app-flex app-vertical-center del-line" style="background:#fff;padding:3px 5px 2px;border-radius:20px;width:auto !important; height:auto;max-width:5rem">
				<span class="ellipsis app-basis" @click="switch_tab($event,'1');" v-text="title"></span><i style="margin-left:5px; margin-right:0"></i>
				<ul v-if="cur_index == 1" class="filter-list" v-cloak>
					<?php if(is_array($qtypelist)): $i = 0; $__LIST__ = $qtypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li @click="change_lesson($event);" data-item="<?php echo ($val["typename"]); ?>"><?php echo ($val["typename"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<div class="search-item app-basis">
				<input type="text" placeholder="请输入微课名称" v-model="keywords" />
				<div v-if="keywords !=''" class="clear" @click="keywords=''" v-cloak></div>
			</div>
			<div class="search-btn" @click="search($event);">立即搜索</div>
		</header>
		<!--微课列表-->			
			<div class="lesson-null app-flex app-flex-y app-vertical-center app-hrizontal-center" id="noclass" <?php if(count($list) > 0): ?>style="display: none;"<?php endif; ?>>
				<h4>暂无该课程讲解~</h4>
				<p>你可向在线老师发起提问</p>
			</div>		
		<section class="online-teacher" <?php if(count($list) > 0): ?>style="display: none;"<?php endif; ?>>
			<div class="title-panel app-flex app-vertical-center app-content-justify">
				<h4 style="font-size:.9rem">直接向在线老师提问</h4>
			</div>
			<ul class="teacher-list" style="padding-top: 0;">
				<?php if(is_array($tlist)): $i = 0; $__LIST__ = $tlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item app-flex app-vertical-center">
					<a href="<?php echo U('Home/Teacher/teacher_info',array('id'=>$va['id']));?>" class="app-basis app-flex app-vertical-center">
						<div class="teacher-avatar">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="teacher-info app-basis">
							<h4 style="font-size:.8rem; color:#595959" ><?php echo ($va["truename"]); ?></h4>
							<p style="font-size:.8rem; color:#999"><?php echo ($va["honors"]); ?></p>
							<p style="font-size:.8rem">综合评分 :&nbsp;<span style="color:#999"><?php echo ($va["star"]); ?></span></p>
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
		</section>
		<ul class="content-list ptop" id="weikelist" <?php if(count($list) == 0): ?>style="display: none;"<?php endif; ?>>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="mrolesson">
				<a href="<?php echo U('Home/Task/lesson_info',array('id'=>$va['id']));?>" class="app-basis app-flex app-vertical-center">					
					<div class="headImg" style="align-self:flex-start">
						<img src="<?php echo ($va["headimg"]); ?>" alt="img">
					</div>
					<div class="app-basis" style="width:1%">
						<div style="font-size:.8rem"><?php echo ($va["username"]); ?></div>							
						<h4 class="ellipsis" style="font-size:.8rem;color:#999"><?php echo ($va["questiontype"]); ?></h4>
						<div class="ellipsis" style="font-size:.8rem"><?php echo ($va["title"]); ?></div>							
						<h5 style="font-size:.8rem;color:#999;"><?php echo ($va["classtype"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($va["type"]); ?></h5>
						<h5 class="Line2" style="color:#999;font-size:.8rem;"><?php echo ($va["brief"]); ?></h5>
						<div class="content-info-num3 app-flex app-vertical-center" style="margin-top:.5rem">
							<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
							<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
						</div>
					</div>
				</a>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<div class="data-text" id="searchlist" v-text="data_text"></div>
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
				
				if(this.keywords == '' && this.title == '课程类型')
				{
					$.toast("输入微课名称","forbidden");
					return false;
				}else{
					$.showLoading("正在搜索...");
					$.ajax({
						url: "<?php echo U('Home/Task/getweikelist');?>",
	                    data: {classtype:this.title,keywords:this.keywords},
	                    type:'POST',
	                    success: function (data) {
	                    	if(data.status ==1)
	                    	{
	                    		if(data.html!='')
	                    		{
	                    			$(".app-hrizontal-center").css("display","none");
	                    			$(".online-teacher").css("display","none");
	                    			$("#weikelist").css("display","block");
									$("#searchlist").show();
	                    			//调用数据
									setTimeout(function(){
										$.hideLoading();
										document.getElementById('weikelist').innerHTML=data.html;
									},750);
	                    		}else{
	                    			$.hideLoading();
									$("#searchlist").hide();
	                    			$(".app-hrizontal-center").css("display","flex");
	                    			$(".online-teacher").css("display","block");
	                    			$("#weikelist").css("display","none");
	                    		}
	                    		
	                    	}
	                    }
					})
				}				
				
			}
		}
	});
</script>
</html>