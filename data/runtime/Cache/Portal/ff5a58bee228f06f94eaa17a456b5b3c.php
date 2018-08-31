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
	<meta name="keywords" content="好问达教师端">
	<meta name="description" content="好问达教师端">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
	<style>
		body h1, body h2, body h3, body h4, body h5, body h6{font-size:.8rem !important;}
		body .reply-content p{font-size:.8rem}
		body .quiz-info img{width:100%;max-width:100%}
		.weui-cells .weui-cell__bd>p,.weui-cells .weui-cell__ft{ font-size:.8rem}
		body .weui-cell{border-bottom:1px solid #f0eff4}
		body .weui-cells:after{display:none}
		body .lesson-detail-main{ padding:10px 15px 0}
		body .quiz-info .quiz-desc{ margin-bottom:10px}
	</style>
</head>
<body data-app="ChineseBang">
	<audio src="../media/9797.mp3" id="aud" controls></audio>
	<section id="app">
		<!--我的解答 解答详情-->
		<section class="quiz-content">
			<article class="quiz-info">
				<div class="weui-cells">
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
					<div style="padding:  10px 15px 0;font-size:.8rem;color:#3cc8fe"><?php echo ($qinfo["title"]); ?></div>
					<!--<h4 class="quiz-desc" style="text-align:center; font-size: 0.85rem; font-weight: bold;"><span style="color: #39c8ff;">问题：</span><?php echo ($qinfo["title"]); ?></h4>
					<div class="quiz-time" style="padding-bottom: 0.75rem;">
						<h4>提问时间：<span><?php echo (date('Y-m-d H:i',$qinfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">						
						<!--问题描述-->
						<?php if(is_array($imgtaudio)): $i = 0; $__LIST__ = $imgtaudio;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="padding:0"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap" style="margin-top: 5px;">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>" style="padding-bottom:10px">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
							<a href="<?php echo ($va["text"]); ?>" target="_blank"><img src="<?php echo ($va["text"]); ?>" alt="img" style="margin: 0 auto; margin-bottom: 10px;"></a>
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section>

				</div>
				
			</article>
			<!--老师回答-->
			<?php if($aninfo['id'] != ''): ?><article class="quiz-info">
				<div class="weui-cells">
					<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>回答</p>
						</div>
						<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$aninfo["addtime"])); ?></div>
					</div>
					<!--<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>老师回答</p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>-->
					<!--<h4 class="title" style="text-align:center; margin: 0 auto 0.5rem; font-size: 0.85rem; font-weight: bold;color: #39c8ff;">老师回答：</h4>
					<div class="quiz-time" style="margin-bottom: 0.5rem;">
						<h4>回答时间：<span><?php echo (date('Y-m-d H:i',$aninfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">
						
						<?php if(is_array($imgtaudio1)): $i = 0; $__LIST__ = $imgtaudio1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;padding:0"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>" style="padding-bottom:10px">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>	
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
							<a href="<?php echo ($va["text"]); ?>" target="_blank"><img src="<?php echo ($va["text"]); ?>" alt="img" style="margin: 0 auto; margin-bottom: 10px;"></a>
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section>
				</div>
			</article><?php endif; ?>
			<?php if($agqinfo != ''): ?><!--追问问题-->
			<article class="quiz-info">
				<div class="weui-cells">
					<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>追问</p>
						</div>
						<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$agqinfo["addtime"])); ?></div>
					</div>
					<!--<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>追问题</p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>-->
					<div style="padding: 10px 15px 0;font-size:.8rem;color:#3cc8fe"><?php echo ($agqinfo["title"]); ?></div>
					<!--<h4 class="title" style="text-align:center; width: auto; word-break: break-all; margin: 0 auto 0.5rem; font-size: 0.85rem; font-weight: bold;color: #595959;"><span style="color: #39c8ff;">追问问题：</span><?php echo ($agqinfo["title"]); ?></h4>
					<div class="quiz-time" style="margin-bottom: 0.5rem;">
						<h4>追问时间：<span><?php echo (date('Y-m-d H:i',$agqinfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">
						<!--问题描述-->
						<!--语音板块-->
						<?php if(is_array($imgtaudio2)): $i = 0; $__LIST__ = $imgtaudio2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;padding:0px"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>" style="padding-bottom:10px">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>	
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
							<a href="<?php echo ($va["text"]); ?>" target="_blank"><img src="<?php echo ($va["text"]); ?>" alt="img" style="margin: 0 auto; margin-bottom: 10px;"></a>
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section>
				</div>
			</article><?php endif; ?>
			<!--老师回答-->
			<?php if($anaginfo != ''): ?><article class="quiz-info">
				<div class="weui-cells">
					<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>回答</p>
						</div>
						<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$anaginfo["addtime"])); ?></div>
					</div>
					<!--<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>老师回答</p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>-->
					<!--<h4 class="title" style="text-align:center; margin: 0 auto 0.5rem; font-size: 0.85rem; font-weight: bold;color: #39c8ff;">老师回答：</h4>
					<div class="quiz-time" style="margin-bottom: 0.5rem;">
						<h4>回答时间：<span><?php echo (date('Y-m-d H:i',$anaginfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">
						
						<!--语音板块-->
						<?php if(is_array($imgtaudio3)): $i = 0; $__LIST__ = $imgtaudio3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;padding:0"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>" style="padding-bottom:10px">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
							<a href="<?php echo ($va["text"]); ?>" target="_blank"><img src="<?php echo ($va["text"]); ?>" alt="img" style="margin-bottom: 10px;"></a>
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section>
				</div>
			</article><?php endif; ?>
			<?php if($qinfo['isend'] == 1): ?><div class="satisfy-degree">
				<h4>回答满意度：<span><?php echo ($qinfo["star"]); ?></span></h4>
			</div><?php endif; ?>
			<?php if($qinfo['isfree'] == 0 && $qinfo['isend'] == 1): ?><div id="freelist" class="btm-btn pub-btm app-flex app-vertical-center app-hrizontal-center">
				<div class="save-to-draft">
					<a href="javascript:;" @click="joinfree($event,'<?php echo ($qinfo["id"]); ?>',1)">私密回答</a>
				</div>
				<div class="give-score">
					<a href="javascript:;" @click="joinfree($event,'<?php echo ($qinfo["id"]); ?>',2)">公开回答</a>
				</div>
			</div><?php endif; ?>
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
			joinfree:function(evt,id,type)
			{
				console.log(id+'|'+type);
				$.ajax({
					url:"<?php echo U('portal/Problem/dofree');?>",
					data:{id,id,isfree:type},
					type:'post',
					success:function(data)
					{
						if(data.status==0)
						{
							$.toast('操作成功','text',function(){
							    setTimeout(function(){
								  $("#freelist").hide();
								})
							})
						}
					}
				})
			}
		}
	});
	//播放语音控件
	$("#app").on('click','.audio-item',function(evt){
		
		console.log(audio.duration);
		console.log(audio.readyState);
		evt.preventDefault();
		
		var that = $(this);
		var src = that.data("audio-src");
		that.parents('.audio-wrap').siblings().find(".audio-item").removeClass("playing").text("点击收听");
		$(this).parents('.quiz-content').siblings().find(".audio-item").removeClass("playing");
		$(this).parents('.quiz-content').siblings().find(".audio-item").text("点击收听");
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
</script>

</html>