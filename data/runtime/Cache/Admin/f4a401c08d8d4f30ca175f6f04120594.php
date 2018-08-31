<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
		.form-required{color:red;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/",
	    WEB_ROOT: "/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	jQuery( document ).ready(function( $ ) {
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<style type="text/css">
.form-horizontal .control-group{margin-bottom: 10px;}
</style>
<style type="text/css">
		html {
			-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
		}
		.db {
			display: block;
		}
		.weixinAudio {
			line-height: 1.5;
		}
		.audio_area {
			display: inline-block;
		    width: 100%;
		    vertical-align: top;
		    margin: 0px 1px 0px 0;
		    font-size: 0;
		    position: relative;
		    font-weight: 400;
		    text-decoration: none;
		    -ms-text-size-adjust: none;
		    -webkit-text-size-adjust: none;
		    text-size-adjust: none;
		}
		.audio_wrp {
			border: 1px solid #ebebeb;
			background-color: #fcfcfc;
			overflow: hidden;
			padding: 12px 20px 12px 12px;
			border-radius: 15px;
		}
		.audio_play_area {
			float: left;
		    margin: -7px 18px 3px 3px;
		    font-size: 0;
		}
		.playing .audio_play_area .icon_audio_default {
			display: block;
		}
		.audio_play_area .icon_audio_default {
			background: transparent url(/public/images/iconloop.png) no-repeat 0 0;
			width: 18px;
			height: 25px;
			vertical-align: middle;
			display: inline-block;
			-webkit-background-size: 54px 25px;
			background-size: 54px 25px;
			background-position: -36px center;
		}
		.audio_play_area .icon_audio_playing {
			background: transparent url(/public/images/iconloop.png) no-repeat 0 0;
			width: 18px;
			height: 25px;
			vertical-align: middle;
			display: inline-block;
			-webkit-background-size: 54px 25px;
			background-size: 54px 25px;
			-webkit-animation: audio_playing 1s infinite;
			background-position: 0px center;
			display: none;
		}
		.audio_area .pic_audio_default {
			display: none;
			width: 18px;
		}
		.tips_global {
			color: #8c8c8c;
		}
		.audio_area .audio_length {
			float: right;
		    font-size: 14px;
		    /* margin-top: 3px; */
		    /* margin-left: 1em; */
		    line-height: 13px;
		}
		.audio_info_area {
			overflow: hidden;
		}
		.audio_area .audio_title {
			font-weight: 400;
			font-size: 14px;
		}
		.audio_area .audio_source {
			font-size: 14px;
		}
		.audio_area .progress_bar {
			position: absolute;
			left: 0;
			bottom: 0;
			background-color: #0cbb08;
			height: 2px;
		}
		.playing .audio_play_area .icon_audio_default {
			display: none;
		}
		.playing .audio_play_area .icon_audio_playing {
			display: inline-block;
		}
		@-webkit-keyframes audio_playing {
			30% {
				background-position: 0px center;
			}
			31% {
				background-position: -18px center;
			}
			61% {
				background-position: -18px center;
			}
			61.5% {
				background-position: -36px center;
			}
			100% {
				background-position: -36px center;
			}
		}
</style>
<body>
	<div class="wrap">
		<audio src="" id="media" width="1" height="1"></audio>
		<ul class="nav nav-tabs">
			<li class="active"><a>资源详情</a></li>
			<li><a href="javascript:history.go(-1);">返回</a></li>
		</ul>
		<form class="form-horizontal js-ajax-form" method="post">
			<?php if($info['userid'] != 0): ?><fieldset>
				<div class="control-group">
					<label class="control-label"><img src="<?php echo ($uinfo["headimg"]); ?>"  width="100" height="100" style="cursor: hand" /></label>
					<div class="controls">
						<label style="margin-top: 40px;"><?php echo ($uinfo["nicename"]); ?><br/><?php echo ($ancount); ?>次答题，<?php echo ($collectcount); ?>人关注</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">职称：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($uinfo["title"]); ?></label>
					</div>
				</div>				
				<div class="control-group">
					<label class="control-label">所在学校：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php echo ($uinfo["schoolname"]); ?></label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">擅长题型：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php echo ($uinfo["questiontype"]); ?></label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">所获荣誉：</label>
					<div class="controls">						
						<label style="margin-top: 5px;"><?php echo ($uinfo["honors"]); ?></label>
					</div>
				</div>	
			</fieldset>
			<hr/>
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-left: -90px;position: absolute;font-weight: bold;">《<?php echo ($info["title"]); ?>》</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">课程类型：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["classtype"]); ?></label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">课程简介：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["brief"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">查看次数：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["clicknum"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">时间：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo (date('Y-m-d H:i',$info["addtime"])); ?></label>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">内容：</label>
					<div class="controls">
						<label style="margin-top: 5px;">
						<?php if(is_array($imgaudio)): foreach($imgaudio as $key=>$vo): if($vo['type'] == 'text'): ?><p><?php echo ($vo["text"]); ?></p><?php endif; ?>
							<?php if($vo['type'] == 'audio'): ?><p class="weixinAudio">
								<span id="audio_area" class="db audio_area">
									<span class="audio_wrp db" style="width: 220px;height: 12px;">
										<span class="audio_play_area">
											<i class="icon_audio_default"></i>
											<i class="icon_audio_playing"></i>
										</span>
										<span id="audio_length" class="audio_length tips_global"></span>
										<span class="db audio_info_area" style="line-height: 13px;">
											<strong class="db audio_title" data-src="<?php echo ($vo["text"]); ?>">点击收听</strong>		            
										</span>
									</span>
								</span>
							</p><?php endif; ?>
							<?php if($vo['type'] == 'img'): ?><p><a href="<?php echo ($vo["text"]); ?>" target="_blank"><img src="<?php echo ($vo["text"]); ?>" width="100px"></a></p><?php endif; endforeach; endif; ?>
						</label>
					</div>
				</div>								
			</fieldset>
			<?php else: ?>
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;margin-left: -80px;"><img src="../data/upload/logo.png" style="margin-left: -60px;" width="100" height="100" style="cursor: hand" /><br/><br/>
							此资源由“问学帮”官方发布
						</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-left: -90px;position: absolute;font-weight: bold;">《<?php echo ($info["title"]); ?>》</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">资源类型：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["classtype"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">资源简介：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["brief"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<label style="margin-top: 5px;">查看次数：<?php echo ($info["clicknum"]); ?>，收藏次数：<?php echo ($collectcount); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">内容：</label>
					<div class="controls">
						<label style="margin-top: 5px;">
						
						<?php echo (htmlspecialchars_decode($info["content"])); ?>
						</label>
					</div>
				</div>		
			</fieldset><?php endif; ?>
		</form>
</div>
<script src="/public/js/common.js"></script>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script>
var audio = document.getElementById("media");
$(".wrap").on("click",".audio_title",function(evt){
	evt.preventDefault();
	var that = $(this);
	var src = that.data("src");
	that.parents(".audio-item").find(".audio_title").removeClass("playing").text("点击收听")
	audio.src=src;
	//判断语音是否可以正常播放
	audio.addEventListener("error",function(){
		//$.toast("语音错误",'cancel');
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
		$(this).text("暂停播放");
		audio.play();
	}
	audio.addEventListener("ended",function(){
		that.removeClass("playing");
		that.text("点击收听");
	});
})
</script>
</body>
</html>