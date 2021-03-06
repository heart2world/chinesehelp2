<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>个人中心</title>
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
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>
<style>
	.weui-cell_access{ color:#595959;font-size:.8rem}
	.point{ position:absolute; top:-5px; right:-10px; width: 15px; height: 15px; text-align:center; line-height:15px; border-radius: 50%; background: #f00; color:#fff;font-size:.7rem}
</style>
<body data-app="ChineseBang">
	<!--个人中心-->
	<!--个人中心头部-->
	<!--<header class="centre-hd app-flex app-vertical-center" id="app" style="background-image:url(<?php echo ($member["headimg"]); ?>)">
		<div class="meng"></div>-->
	<header class="centre-hd app-flex app-vertical-center" id="app" style="background:rgba(60,200,254,.5)">
		<div class="centre-avatar">
			<img :src="avatar_url" alt="avatar" @click="upload_avatar($event);">
		</div>
		<div class="centre-info app-basis" style="z-index:1">
			<p>昵称：<?php echo ($member["nicename"]); ?></p>
			<p>性别：<?php echo ($member["sex"]); ?></p>
			<p>年龄：<?php echo ($member["age"]); ?>岁</p>
			<p>年级：<?php echo ($member["classname"]); ?></p>
			<p>学校：<?php echo ($member["schoolname"]); ?></p>
		</div>
		<div class="setting" style="z-index:999">
			<a href="<?php echo U('Home/Center/setting_profile');?>">设置</a>
		</div>
	</header>

	<!--个人中心导航-->
	<div class="weui-cells">
		<a class="weui-cell weui-cell_access" href="<?php echo U('Home/Center/mypub');?>">
			<div class="weui-cell__hd"><img src="/public/assets/wenti.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>
					<span style="position:relative">我的问题
					<?php if($qcount > 0): ?><i class="point"><?php echo ($qcount); ?></i><?php endif; ?>
					</span>
				</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="<?php echo U('Home/Center/myfavar');?>">
			<div class="weui-cell__hd"><img src="/public/assets/sc.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>我的收藏</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="<?php echo U('Home/Center/consume_note');?>">
			<div class="weui-cell__hd"><img src="/public/assets/xiaofei.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>消费记录</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
	</div>
	<!--<nav class="centre-nav">
		<a href="<?php echo U('Home/Center/mypub');?>">我的问题 <?php if($qcount > 0): ?><i class="point" style="margin-left:5px;margin-top:2.5px;"></i><?php endif; ?></a>
		<a href="<?php echo U('Home/Center/mypub');?>"><span class="qpoint">我的问题 <?php if($qcount > 0): ?><i class="point"><?php echo ($qcount); ?></i><?php endif; ?></span></a>
		<a href="<?php echo U('Home/Center/myfavar');?>">我的收藏</a>
		<a href="<?php echo U('Home/Center/consume_note');?>">消费记录</a>
	</nav>-->
	<!--应用固定导航-->
	<section class="app-nav app-flex">
		<a class="app-basis" href="./" data-home>
			<p>首页</p>
		</a>
		<a class="app-basis" href="<?php echo U('Home/Problem/pub');?>" data-twen>
			<p>我要提问</p>
		</a>
		<a class="app-basis active" href="<?php echo U('Home/Center/index');?>" data-centre>
			<p>个人中心</p>
		</a>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
$(function () {
	// 3. 通过config接口注入权限验证配置
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "<?php echo $signPackage['appId'];?>", // 必填，公众号的唯一标识
        timestamp: <?php echo $signPackage['timestamp'];?>, // 必填，生成签名的时间戳
        nonceStr: "<?php echo $signPackage['nonceStr'];?>", // 必填，生成签名的随机串
        signature: "<?php echo $signPackage['signature'];?>", // 必填，签名，见附录1
        jsApiList: [
			"chooseImage",
            "uploadImage",
            "downloadImage",
            "previewImage"
        ]
    });
	// 4. 通过ready接口处理成功验证
    wx.ready(function () {     	
    });
    // 5. 通过error接口处理失败验证
    wx.error(function (res) {
        alert(JSON.stringify(res));
    });
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			avatar_url:'<?php echo ($member["headimg"]); ?>'
		},
		methods:{
			upload_avatar:function(evt){
				//微信上传图片修改头像
				 //微信上传图片修改头像
		wx.chooseImage({
			   count: 1, 
				 success: function (res) {
					 var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片       
					 $.showLoading("上传中...");
					 wx.uploadImage({
						 localId: localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
						 isShowProgressTips: 0, // 默认为1，显示进度提示
						 success: function (res) {
						  var serverId = res.serverId; // 返回图片的服务器端ID 									
						   $.ajax({
							 type: "POST",
							 url: "<?php echo U('Home/Center/getimgpost');?>",
							 data: {"access_token":"<?php echo $signPackage['token'];?>","media_id":serverId},
							 success: function (res) {
								$.hideLoading();
								if(res.status==1)
								{	
									app.avatar_url = res.strimgurl;									
								}
							 }
						   });
						 },
						  fail: function (res) {
						  alert("图片上传失败");           

					   }
					});
				 }
			 });        
			}
		}
	});
});
</script>
</html>