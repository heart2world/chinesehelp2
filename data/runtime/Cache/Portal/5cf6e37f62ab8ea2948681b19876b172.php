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
		body h1, body h2, body h3, body h4, body h5, body h6{font-size:.8rem !important;}
		body .reply-content p{font-size:.8rem}
		body .resource-content img{max-width:90%}
	</style>
</head>
<body data-app="ChineseBang">
	<audio src="/public/media/9797.mp3" id="aud" controls></audio>
	<section id="app" style="padding-bottom: 0.5rem;">
		<!--内容板块-->
		<section class="content-module" style="padding-bottom: 2rem;">
			<!--资源详情-->
			<article class="content-panel">
				<ul class="content-list" style="margin-bottom: 0;">
					<li class="content-item" data-type="mrolesson">
						<a href="javascript:void(0);" style="display:block">
							<div class="content-top app-flex app-vertical-center">
								<h4 class="app-basis" style="font-sze:.9rem;color:#595959;font-weight:700"><?php echo ($info["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4>资源类型 :&nbsp;</h4>
								<h5 class="app-basis"><?php echo ($info["classtype"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4>资源简介 :&nbsp;</h4>
								<h5 class="app-basis"><?php echo ($info["brief"]); ?></h5>
							</div>
							<div class="content-inner-item app-flex">
								<h4>购买价格 :&nbsp;</h4>
								<h5 class="app-basis"><?php echo ($info["price"]); ?>元</h5>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
								<h4><?php echo ($info["clicknum"]); if($info['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($info["colcount"]); if($info['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</a>
					</li>
				</ul>
				<!--微克具体详情内容 语音、图片、文字-->
				<section class="lesson-detail-main">
					<!--语音板块-->
					<?php if(is_array($imgtaudio)): $i = 0; $__LIST__ = $imgtaudio;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'audio'): ?><section class="audio-wrap">
						<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>">
							<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
							<i><?php echo ($va["atime"]); ?>"</i>
						</div>
					</section><?php endif; ?>
					<!--问题解答-->
					<?php if($va['type'] == 'text'): ?><section class="reply-content resource-content" style="padding-bottom: 0rem;">						
						<p><?php echo ($va["text"]); ?></p>	
					</section><?php endif; ?>
					<?php if($va['type'] == 'img'): ?><section class="reply-content resource-content" style="padding-bottom: 0rem;">						
						<div class="img-wrap">
							<img src="<?php echo ($va["text"]); ?>" alt="img">
						</div>	
					</section><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</section>
			</article>
		</section>
		<!--发布成功不再显示-->
		<?php if($info['status'] == '0'): ?><div class="btm-btn pub-btm app-flex app-vertical-center app-hrizontal-center">
			<div class="save-to-draft">
				<a href="javascript:void(0);" @click="jump_to_edit($event);">编辑</a>
			</div>
			<div class="give-score">
				<a href="javascript:void(0);" @click="pub($event,'<?php echo ($info["id"]); ?>');">直接发布</a>
			</div>
		</div><?php endif; ?>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var audio = document.querySelector("#aud");
	var url = '<?php echo ($localurl); ?>';
	//监听语音控件是否处于暂停状态
	audio.addEventListener("pause",function(){
		//console.log(111);
		$("#app").find(".playing").removeClass("playing").text("点击收听");
	})
	var app = new Vue({
		el:'#app',
		data:{
			show_layer:false

		},
		methods:{
			jump_to_edit:function(evt){
				setTimeout(function(){
					//设置session信息
					try{
						sessionStorage.setItem("status2",1);
						if(sessionStorage.getItem("status2")){
							location.href=url;
						}
					}catch(e){
						console.warn(e);
					}
				},500);
			},
			pub:function(evt,proid){
				$.confirm({
					title:'',
					text:'发布之后不能再修改~',
					onOK:function(){
						$.ajax({
		                    url: "<?php echo U('Portal/Resource/fabu2');?>",
		                    data: {id:proid},
		                    type:'POST',
		                    success: function (data) {
		                    	if(data.status == 1)
		                    	{		
									//发布成功
									$.toast("发布成功~",'text',function(){
										setTimeout(function(){
											//设置session信息
											try{
												sessionStorage.setItem("status2",2);
												if(sessionStorage.getItem("status2")){
													location.reload();
												}
											}catch(e){
												console.warn(e);
											}
										},500);
									});
								}
							}
						})
					}
				});
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