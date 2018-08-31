<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>我的问题</title>
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
	<link rel="stylesheet" href="/public/libs/swiper/css/swiper.min.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/swiper/js/swiper.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
</head>
<style>
	.content-list .content-item a:before{ display:none}
	.content-list .content-item a:after{ left:0;right:0}
</style>
<body data-app="ChineseBang">
	<section class="plat-content">
		<article class="content-panel">
			<ul class="content-list">
				<?php if(is_array($qlist)): $i = 0; $__LIST__ = $qlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="content-item" data-type="requestion">
						<a href="<?php echo U('Home/Problem/detail',array('id'=>$va['id']));?>" style="display:block">
							<div class="content-top app-flex app-vertical-center">
								<h4 class="app-basis" style="font-size:.8rem;color:#595959"><?php echo ($va["title"]); ?></h4>
								<div style="font-size:.8rem;color:#999"><?php echo (date('Y-m-d',$va["addtime"])); ?></div>
							</div>
							<div class="content-inner-item app-flex">
								<h4 style="font-size:.7rem;color:#999">回答满意度 : <?php echo ($va["star"]); ?></h4>
							</div>
							<div class="content-info-num2 app-flex app-vertical-center">
							<!--<div class="app-basis">-->
								<h4><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h5><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h5>
								</div>
								<!--<div style="font-size:.8rem"><?php echo (date('Y-m-d',$va["addtime"])); ?></div>-->
							<!--</div>-->
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>				
			</ul>
		</article>
		<div class="data-text">没有更多了~</div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
</html>