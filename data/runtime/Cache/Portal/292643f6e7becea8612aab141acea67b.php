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
	<script src="/public/libs/swiper.js"></script>
	<style>		
		body .reply-content p{font-size:14px}
		body .quiz-info img{max-width:90%}
		.weui-btn_primary{ background:#3cc8fe}
		.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
		
		.weui-cells .weui-cell__bd>p,.weui-cells .weui-cell__ft{ font-size:.8rem}
		body .weui-cell{border-bottom:1px solid #f0eff4}
		body .weui-cells:after{display:none}
	</style>
</head>
<body data-app="ChineseBang">
	<audio src="../media/9797.mp3" id="aud" controls></audio>
	<section id="app">
		<!--我的解答 未解答-->
		<section class="quiz-content">
			<article class="quiz-info">
				<div class="">
					<section class="lesson-detail-main app-basis weui-cells" style="padding:0">
						<div class="weui-cell">
							<div class="weui-cell__bd">
								<p>提问</p>
							</div>
							<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$qinfo["addtime"])); ?></div>
						</div>
						<!--<div class="weui-cell">
							<div class="weui-cell__bd">
								<p>问题</p>
							</div>
							<div class="weui-cell__ft"></div>
						</div>-->
						<div style="font-size:.8rem; padding: 10px 15px;color:#3cc8fe"><?php echo ($qinfo["title"]); ?></div>
						<!--问题描述-->
						<!--<h4 class="quiz-desc" style="text-align:center; font-size: 0.85rem; color: #595959; font-weight: bold;">问题：<?php echo ($qinfo["title"]); ?></h4>
						<div class="quiz-time" style="padding-top: 0; padding-bottom: 0.75rem;">
							<h4>提问时间：<span><?php echo (date('Y-m-d H:i',$qinfo["addtime"])); ?></span></h4>
						</div>-->
						<?php if(is_array($imgtaudio)): $i = 0; $__LIST__ = $imgtaudio;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;padding: 0 15px;margin-bottom:10px"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>" style="padding-bottom:10px">
								<span class="audio-item" style="font-size:1rem;color:#3cc8fe" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
							<img src="<?php echo ($va["text"]); ?>" alt="img" style="margin: 0 auto; margin-bottom: 10px;">
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section>
				</div>
				<div class="quiz-student-num">
					学生<span><?php echo ($username); ?></span>，第<span><?php echo ($qcount); ?></span>次向您提问~
				</div>
				<!--<div class="btm-btn pub-btm app-flex app-vertical-center app-hrizontal-center">
					<div class="save-to-draft">
						<a href="<?php echo U('Portal/Problem/answerline',array('id'=>$qinfo['id'],'isfree'=>1));?>">私密回答</a>
					</div>
					<div class="give-score">
						<a href="<?php echo U('Portal/Problem/answerline',array('id'=>$qinfo['id'],'isfree'=>0));?>">公开回答</a>
					</div>
				</div>-->
				<div class="weui-btn-area" style="padding:15px;margin:0">
					<a class="weui-btn weui-btn_primary" href="<?php echo U('Portal/Problem/answerline',array('id'=>$qinfo['id']));?>">解 答</a>
				</div>
				<!--<div class="btm-btn pub-btm app-flex app-vertical-center app-hrizontal-center">					
					<a href="<?php echo U('Portal/Problem/answerline',array('id'=>$qinfo['id']));?>">解 答</a>					
				</div>-->
			</article>
		</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var audio = document.querySelector("#aud");

	//监听语音控件是否处于暂停状态
	audio.addEventListener("pause",function(){
		//console.log(111);
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
	$("#app").on('click','img',function(evt){
		var preview = $.photoBrowser({
		  initIndex:0,
		  items: [
			$(this).attr("src")
		  ]
		});

		preview.open();
	})
</script>
</html>