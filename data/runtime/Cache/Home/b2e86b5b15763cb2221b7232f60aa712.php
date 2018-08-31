<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>资源详情</title>
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
	<script src="/public/libs/swiper.js"></script>
	<style>
		body h1, body h2, body h3, body h4, body h5, body h6{font-size:.8rem;}
		body .reply-content p{font-size:.8rem;padding-bottom:.75rem}
		body .resource-content img{max-width:90%}
		.weui-btn-area{border-top:1px solid #3cc8fe; position:fixed;left:0; right:0;bottom:0;padding:0;margin:0; background:#fff}
		.weui-btn_primary{ background:#3cc8fe;font-size:1rem}
		.teacher-hd-info{ border:none}
		.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
		.weui-btn:after{ display:none}
		.weui-btn-area>div{ font-size:.9rem; float:left;width:50%;text-align:center;margin-top:0 !important;border-radius:0}
		.weui-btn-area>div.nopay{ font-size:.9rem;width:100%;text-align:center;margin-top:0 !important;border-radius:0;background:#3cc8fe !important;color:#fff !important}
		.weui-btn-area>div:first-child{ background:#fff; color:#3cc8fe}
		.reply-content{ padding:0}
	</style>
</head>
<body data-app="ChineseBang">
	<audio src="" id="aud" controls></audio>
	<section id="app">
		<!--教师头部信息-->
		<?php if($info['userid'] != 0): ?><header class="teacher-hd-info" style="padding:0">
			<div class="teacher-top app-flex app-vertical-center" style="padding:.5rem 1rem 0">
				<div class="teacher-image">
					<img src="<?php echo ($uinfo["headimg"]); ?>" alt="img">
				</div>
				<div class="info-content app-basis">
					<h4><?php echo ($uinfo["truename"]); ?></h4>
					<div class="info-btm app-flex">
						<h4 class="dati"><?php echo ($uinfo["qcount"]); ?></h4>
						<h5 class="sc"><i id="collectnum"><?php echo ($uinfo["colcount"]); ?></i></h5>
					</div>
				</div>
				<?php if($iscollect2 == 1): ?><div class="favar-btn favared" @click="add_favar_or_cancel($event,'<?php echo ($uinfo["id"]); ?>');"></div>
				<?php else: ?>
				<div class="favar-btn" @click="add_favar_or_cancel($event,'<?php echo ($uinfo["id"]); ?>');"></div><?php endif; ?>
			</div>
			<aside class="teacher-detail-info" style="padding:.5rem 1rem">
				<div class="info-cell app-flex">
					<h4>教<span class="zhanwei">占位</span>龄 :  </h4>
					<h5><?php echo ($uinfo["seniority"]); ?>年</h5>
				</div>
				<div class="info-cell app-flex">
					<h4>职<span class="zhanwei">占位</span>称 :  </h4>
					<h5><?php echo ($uinfo["title"]); ?></h5>
				</div>
				<div class="info-cell app-flex">
					<h4>所在学校 : </h4>
					<h5 class="app-basis"><?php echo ($uinfo["schoolname"]); ?></h5>
				</div>
				<div class="info-cell app-flex">
					<h4>擅长题型 : </h4>
					<h5 class="app-basis"><?php echo ($uinfo["questiontype"]); ?></h5>
				</div>
				<div class="info-cell app-flex">
					<h4>所获荣誉 : </h4>
					<h5 class="app-basis"><?php echo ($uinfo["honors"]); ?></h5>
				</div>
			</aside>
		</header>
		<?php else: ?>
		<!--官方发布显示-->
		<header class="official-release-hd">
			<img src="./data/upload/logo.png" alt="official">
			<p style="color:#3cc8fe;font-size:.8rem">本资源由“问学帮”官方发布</p>
		</header><?php endif; ?>
		<!--内容板块-->
		<section class="content-module" style="padding-bottom: 0;">
			<article class="content-panel">
				<ul class="content-list">
					<li class="content-item" data-type="mrolesson">
						<a href="javascript:void(0);" style="display:block">
							<div class="content-top app-flex app-vertical-center">
								<h4 class="app-basis" style="color:#595959;font-size:.9rem"><?php echo ($info["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4><?php echo ($info["type"]); ?>类型 :&nbsp;</h4>
								<h5 class="app-basis"><?php echo ($info["classtype"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4><?php echo ($info["type"]); ?>简介 :&nbsp;</h4>
								<h5 class="app-basis"><?php echo ($info["brief"]); ?></h5>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($info["clicknum"]); if($info['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($info["colcount"]); if($info['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</a>
					</li>
				</ul>
				<?php if($ismall == 1 || $info['price'] == '0'): if($info['userid'] == '0'): ?><section class="lesson-detail-main">
					<section class="reply-content">						
							<p><?php echo (htmlspecialchars_decode($info["content"])); ?></p>
						</section>
					</section>
					<?php else: ?>
					<section class="lesson-detail-main">
						<!--语音板块-->
						<?php if(is_array($imgaudio)): $i = 0; $__LIST__ = $imgaudio;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'audio'): ?><section class="audio-wrap">
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>						
						</section><?php endif; ?>
						<!--问题解答-->
						<?php if($va['type'] == 'text'): ?><section class="reply-content">						
							<p><?php echo ($va["text"]); ?></p>
						</section><?php endif; ?>					
						<?php if($va['type'] == 'img'): ?><section class="reply-content resource-content" style="padding-bottom: 0;">						
							<div class="img-wrap">
								<img src="<?php echo ($va["text"]); ?>" alt="img" style="margin-bottom: 0.75rem;">
							</div>	
						</section><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section><?php endif; endif; ?>
			</article>
		</section>
		<!--平台公告-->
		
		<section class="notice-content" style="padding-bottom:2.5rem">
			<?php if(count($relatelist) != 0): ?><div class="title-panel app-flex app-vertical-center app-content-justify">
				<h4 style="font-weight:normal; font-size:1rem">相关推荐</h4>
			</div>
			<ul class="content-list">
				<?php if(is_array($relatelist)): $i = 0; $__LIST__ = $relatelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Resource/lesson_info',array('id'=>$va['id']));?>" style="display:block">
						<div class="content-top app-flex app-vertical-center">
							<h4 class="app-basis" style="color:#595959; font-size:.9rem"><?php echo ($va["title"]); ?></h4>
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
							<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
						</div>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<div class="more">
				<a href="<?php echo U('Home/Resource/index',array('type'=>$studenttype));?>">查看更多</a>
			</div><?php endif; ?>
			<?php if($showpay == 0): ?><div class="tip-me">				
				<a href="<?php echo U('Home/Problem/tipoff',array('id'=>$info['id'],'atype'=>2));?>">举报此内容</a>
			</div><?php endif; ?>
		</section>
		
		<!--价格不为0，且未购买-->
		<div class="weui-btn-area">
			<?php if($showpay == 1): ?><div class="weui-btn weui-btn_primary nopay" @click="pay($event);" <?php if($ismall == 1): ?>style="display:none;"<?php endif; ?>>查看资源需支付<?php echo ($info["price"]); ?>元，立即支付</div>
			<?php else: ?>	
				
				<?php if($isscoreed == 1): ?><div class="weui-btn weui-btn_primary nopay" @click="add_favar_or_cancel2($event,'<?php echo ($info["id"]); ?>');">	
				<?php else: ?>
				<div class="weui-btn weui-btn_primary" @click="add_favar_or_cancel2($event,'<?php echo ($info["id"]); ?>');"><?php endif; ?>								
					<div id="iscollection"><?php if($iscollect == 1): ?>取消收藏<?php else: ?>收藏资源<?php endif; ?></div>
				</div>	
				<?php if($isscoreed == 0): ?><div class="weui-btn weui-btn_primary">							
				<a href="<?php echo U('Home/Resource/give_score',array('id'=>$info['id']));?>">	
					<div id="iscollection"  style="height: 2.5rem;color:#fff;font-size:.9rem">
						立即打分
					</div>
				</a>
				</div><?php endif; endif; ?>		
		</div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var audio = document.querySelector("#aud");

	//监听语音控件是否处于暂停状态
	audio.addEventListener("pause",function(){
		console.log(111);
		$("#app").find(".playing").removeClass("playing").text("点击收听");
	})
	var app = new Vue({
		el:'#app',
		data:{
			cur_index:1,
			data_text:'没有更多了~~',
			show_layer:false

		},
		methods:{
			pay:function(evt){
				//这里调用微信支付接口 支付成功后跳转至相应的详情展示页
				$.showLoading("跳转支付...");
				location.href="<?php echo ($payurl); ?>";
			},
			add_favar_or_cancel:function(evt,userid){
				
				if($(evt.target).hasClass('favared')){
					//数据操作
					$.ajax({
						url:"<?php echo U('Home/Problem/collect');?>",
						data:{taskid:userid,type:2},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$(evt.target).removeClass("favared");
								$("#collectnum").html(data.collectnum);
								$.toast("你已取消对TA的收藏",3000);
                        	}
                        }
					})					
				}else{
					//数据操作					
					$.ajax({
						url:"<?php echo U('Home/Problem/collect');?>",
						data:{taskid:userid,type:1},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$(evt.target).addClass("favared");
								$("#collectnum").html(data.collectnum);
								$.toast("你已成功收藏TA~",3000);
                        	}
                        }
					})
				}
			},
			add_favar_or_cancel2:function(evt,taskid){
				console.log(evt);				
				if($("#iscollection").html()=='取消收藏'){					
					//数据操作
					$.ajax({
						url:"<?php echo U('Home/Resource/collect');?>",
						data:{taskid:taskid,type:2},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$("#iscollection").html('收藏资源');
								$.toast("你已取消对TA的收藏",3000);
                        	}
                        }
					})					
				}else{
					//数据操作					
					$.ajax({
						url:"<?php echo U('Home/Resource/collect');?>",
						data:{taskid:taskid,type:1},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$("#iscollection").html('取消收藏');
								$.toast("你已成功收藏TA~",3000);
                        	}
                        }
					})
				}
			}
		},
		preview_photo:function(evt,src){
			//图片预览
			evt.preventDefault();
			var preview = $.photoBrowser({
			  items: [
				src
			  ]
			});

			preview.open();
		}
	});
	//播放语音控件
	$("#app").on('click','.audio-item',function(evt){
		console.log(audio.duration);
		console.log(audio.readyState);
		evt.preventDefault();
		var that = $(this);
		var src = that.data("audio-src");
		that.parent().siblings().find(".audio-item").removeClass("playing").text("点击收听");
		$(this).parents('.audio-wrap').siblings().find(".audio-item").removeClass("playing");
		$(this).parents('.audio-wrap').siblings().find(".audio-item").text("点击收听");
		audio.src= src;
		//判断语音是否可以正常播放
		audio.addEventListener("error",function(){
			$.toast("语音错误",'cancel');
			that.removeClass("playing");
			that.text("点击收听");
			audio.pause();
		});

		if($(this).hasClass('playing')){
			$(this).removeClass("playing");
			$(this).text("点击收听");
			audio.pause();
		}else{
			$(this).addClass("playing");
			$(this).text("暂停");
			audio.play();
		}
		audio.addEventListener("ended",function(){
			that.removeClass("playing");
			that.text("点击收听");
		});
		console.log(audio);
	});
	
	//图片预览
	$("#app").on('click','.img-wrap img',function(evt){
		//alert($(this).attr("src"));
		var preview = $.photoBrowser({
		  items: [
			$(this).attr("src")
		  ]
		});

		preview.open();
	})
</script>
</html>