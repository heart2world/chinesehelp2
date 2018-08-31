<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>好问达</title>
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
	<link rel="stylesheet" href="/public/libs/swiper/css/swiper.min.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/swiper/js/swiper.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<style>
	.point{ position:absolute; top:-5px; right:5px; width: 15px; height: 15px; text-align:center; line-height:15px; border-radius: 50%; background: #f00; color:#fff;font-size:.7rem}
</style>
<body data-app="ChineseBang">
	<!--教师端首页-->
	<!--教师端头部-->
	<header class="index-top">
		<section class="swiper-container">
			<div class="swiper-wrapper">
				<?php if(is_array($imgs)): $i = 0; $__LIST__ = $imgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a class="swiper-slide" href="<?php echo ($vo["link_url"]); ?>">
					<img src="<?php echo ($vo["post_img"]); ?>" alt="picture">
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<div class="swiper-pagination"></div>
		</section>
	</header>
	<!--首页导航板块-->
	<nav class="index-nav4">
		<a href="<?php echo U('Home/Index/getbang',array('type'=>3));?>">
			<img src="/public/assets/yuwenbang.png" alt="img">
			<p>语文帮</p>
		</a>
		<a href="<?php echo U('Home/Index/getbang',array('type'=>4));?>">
			<img src="/public/assets/shuxuebang.png" alt="img">
			<p>数学帮</p>
		</a>
		<a href="<?php echo U('Home/Index/getbang',array('type'=>5));?>">
			<img src="/public/assets/yingyubang.png" alt="img">
			<p>英语帮</p>
		</a>
		<a href="<?php echo U('Home/Index/getbang',array('type'=>6));?>">
			<img src="/public/assets/wulibang.png" alt="img">
			<p>物理帮</p>
		</a>
		<a href="<?php echo U('Home/Index/getbang',array('type'=>7));?>">
			<img src="/public/assets/huaxuebang.png" alt="img">
			<p>化学帮</p>
		</a>
		<a href="<?php echo U('Home/Index/getbang',array('type'=>8));?>">
			<img src="/public/assets/zhengzhibang.png" alt="img">
			<p>政治帮</p>
		</a>
		<a href="<?php echo U('Home/Index/getbang',array('type'=>9));?>">
			<img src="/public/assets/lishibang.png" alt="img">
			<p>历史帮</p>
		</a>
		<a href="<?php echo U('Home/Center/mypub');?>">
			<img src="/public/assets/wdwt.png" alt="img">
			<p>我的问题 <?php if($qcount > 0): ?><i class="point"><?php echo ($qcount); ?></i><?php endif; ?></p>
		</a>
	</nav
	<!--平台公告-->
	<section class="notice-content">
		<div class="title-panel app-flex app-vertical-center app-content-justify" style="border:0">
			<h4 style="font-weight:normal;font-size:.9rem">平台公告</h4>
			<h5>
				<a href="<?php echo U('Home/Index/articlelist');?>" style="color:#999">查看全部</a>
			</h5>
		</div>
		<ul class="notice-list">
			<?php if(is_array($article)): $i = 0; $__LIST__ = $article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="notice-item">
				<a href="<?php echo ($va["link_url"]); ?>" title="<?php echo ($va["post_title"]); ?>" class="app-flex">
					<div class="notice-img">
						<img src="<?php echo ($va["post_img"]); ?>" >
					</div>
					<div class="app-basis" style="width:1%">
						<h4><?php echo ($va["post_title"]); ?></h4>
						<p class="Line2"><?php echo ($va["post_excerpt"]); ?></p>
					</div>
				</a>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>

	<!--应用固定导航-->
	<section class="app-nav app-flex">
		<a class="app-basis active" href="./" data-home>
			<p>首页</p>
		</a>
		<a class="app-basis" href="<?php echo U('Home/Problem/pub');?>" data-twen>
			<p>我要提问</p>
		</a>
		<a class="app-basis" href="<?php echo U('Home/Center/index');?>" data-centre>
			<p>个人中心</p>
		</a>
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