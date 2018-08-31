<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo ($typename); ?>帮</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="<?php echo ($typename); ?>帮">
	<meta name="format-detection" content="telephone=no,address=no,email=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="renderer" content="webkit">
	<meta name="HandheldFriendly" content="true">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="full-screen" content="yes">
	<meta name="keywords" content="<?php echo ($typename); ?>帮学生端">
	<meta name="description" content="<?php echo ($typename); ?>帮学生端">
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
	<link rel="stylesheet" href="/public/style/base.min.css">
	<link rel="stylesheet" href="/public/libs/swiper/css/swiper.min.css">
	<link rel="stylesheet" href="/public/style/app.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/swiper/js/swiper.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<style>
	.index-nav{ overflow:hidden}
	.index-nav>a{ float:left; width:25%;}
	.title-panel{border-bottom:1px solid #f0eff4}
	.content-list .content-item a:before{display:none}
	.content-list .content-item a:after{left:0;right:0}
</style>
<body data-app="ChineseBang">
	<!--学生端首页-->
	<!--学生端头部-->
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
		<a href="<?php echo U('Home/Teacher/index',array('type'=>$type));?>">
			<img src="/public/assets/jiaoshiliebiao.png" alt="nav_icon">
			<p>教师列表</p>
		</a>
		<a href="<?php echo U('Home/Task/index',array('type'=>$type));?>">
			<img src="/public/assets/weikeliebiao.png" alt="nav_icon">
			<p>微课列表</p>
		</a>
		<a href="<?php echo U('Home/Resource/index',array('type'=>$type));?>">
			<img src="/public/assets/ziyuanliebiao.png" alt="nav_icon">
			<p>资源列表</p>
		</a>
		<a href="<?php echo U('Home/Zhuantis/index',array('type'=>$type));?>">
			<img src="/public/assets/zhuantiliebiao.png" alt="nav_icon">
			<p>专题列表</p>
		</a>
		<a href="<?php echo U('Home/Index/hotrecommend',array('type'=>$type));?>">
			<img src="/public/assets/remenliebiao.png" alt="nav_icon">
			<p>热门列表</p>
		</a>
		<a href="javascript:;">
			<img src="/public/assets/remenliebiao-1.png" alt="nav_icon">
			<p>敬请期待</p>
		</a>
	</nav>
	<!--主内容-->
	<!--平台精选-->
	<section class="plat-content">
		<div class="title-panel app-flex app-vertical-center app-content-justify">
			<h4 style="font-weight:normal;color:#595959;font-size:.9rem">平台精选</h4>
			<h5>
				<a href="<?php echo U('Home/Index/tasklist',array('type'=>$type));?>">查看全部</a>
			</h5>
		</div>
		<article class="content-panel">
			<ul class="content-list">
				<?php if(is_array($indexlist)): $i = 0; $__LIST__ = $indexlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == '微课'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Task/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] == '专题'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Zhuantis/ztinfo',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] == '资源'): ?><li class="content-item" data-type="mrolesson">
					<a href="<?php echo U('Home/Resource/lesson_info',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] == '问答'): ?><li class="content-item" data-type="requestion">
					<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id']));?>" class="app-flex"><?php endif; ?>
					<?php if($va['type'] != '问答'): ?><div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:.8rem"><?php echo ($va["username"]); ?></div>							
							<h4 class="ellipsis" style="font-size:.8rem;color:#999"><?php echo ($va["questiontype"]); ?></h4>
							<div class="ellipsis" style="font-size:.8rem"><?php echo ($va["title"]); ?></div>							
								<h5 style="font-size:.8rem;color:#999;"><?php if($va['type'] == '专题'): echo ($va["type"]); else: echo ($va["classtype"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($va["type"]); endif; ?></h5>
							<h5 class="Line2" style="color:#999;font-size:.8rem;"><?php echo ($va["brief"]); ?></h5>
							<div class="content-info-num3 app-flex app-vertical-center" style="margin-top:.5rem">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</div>
					<?php else: ?>					
						<div class="headImg">
							<img src="<?php echo ($va["headimg"]); ?>" alt="img">
						</div>
						<div class="app-basis" style="width:1%">
							<div style="font-size:.9rem"><?php echo ($va["username"]); ?> <span style="color:#999;font-size:0.8rem;">问答</span></div>
							<div class="content-top1 app-flex app-vertical-center">
								<h4 class="app-basis"><?php echo ($va["title"]); ?></h4>
							</div>
							<div class="content-inner-item app-flex">
								<h4>回答满意度:  <span><?php echo ($va["brief"]); ?></span></h4>
							</div>
							<div class="content-info-num3 app-flex app-vertical-center" style="margin-top:.5rem">
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
							</div>
						</div><?php endif; ?>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</article>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
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