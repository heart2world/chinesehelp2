<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>教师端-全部文章</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="语文帮">
	<meta name="format-detection" content="telephone=no,address=no,email=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="renderer" content="webkit">
	<meta name="HandheldFriendly" content="true">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="full-screen" content="yes">
	<meta name="keywords" content="语文帮教师端">
	<meta name="description" content="语文帮教师端">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<link rel="stylesheet" href="/public/libs/swiper/css/swiper.min.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/swiper/js/swiper.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<body data-app="ChineseBang">
<section class="notice-content">
		<ul class="notice-list">
			<?php if(is_array($article)): $i = 0; $__LIST__ = $article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="notice-item">
				<a href="<?php echo ($va["link_url"]); ?>" title="<?php echo ($va["post_title"]); ?>" class="app-flex">
					<div class="notice-img">
						<img src="<?php echo ($va["post_img"]); ?>" >
					</div>
					<div class="nt-top app-basis app-vertical-center" style="width:1%">
						<h4><?php echo ($va["post_title"]); ?></h4>
						<p class="Line2"><?php echo ($va["post_excerpt"]); ?></p>
						<!--<h5><?php echo ($va["addtime"]); ?></h5>-->
					</div>
				</a>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>	
</body>
<script src="/public/libs/fixed.js"></script>
<script>
	//轮播图展示
	var swiper_config = {
			speed:700,
			autoplay:3500,
			pagination:'.swiper-pagination',
			loop:true,
			autoplayDisableOnInteraction : false,

		}
		try{
			var mySwiper = new Swiper('.swiper-container',swiper_config);
		}catch(e){
			console.warn(e);
		}
</script>
</html>