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
  <meta name="keywords" content="好问达教师端">
  <meta name="description" content="好问达教师端">
  <link rel="stylesheet" href="/public/style/base.min.css">
  <link rel="stylesheet" href="/public/style/app.css">
  <link rel="stylesheet" href="/public/libs/weui/weui.min.css">
  <link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
  <script src="/public/libs/jq.min.js"></script>
  <script src="/public/libs/v.min.js"></script>
  <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>
<style>
	.weui-btn_primary{ background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
	.weui-cell_access{ color:#595959;font-size:.8rem}
	.point{ position:absolute; top:-5px; right:-20px; min-width: 11px; padding:0 2px; height: 15px; text-align:center; line-height:15px; border-radius: 20px; background: #f00; color:#fff;font-size:.7rem}
	.shuoming{display:inline-block; width:20px;height:20px; margin-left: 0.4rem; font-size: 0.7rem;background:url(/public/assets/shuoming.png) no-repeat; background-size:contain;}
	.xiugai{position:absolute; display:inline-block; width:19px;height:19px; margin-left: 0.4rem; font-size: 0.7rem;background:url(/public/assets/xiugai.png) no-repeat; background-size:contain;}
	.centre-info select{ font-size:.8rem; padding:0 1.15rem 0 .5rem}
	</style>
<body data-app="ChineseBang">
  <!--个人中心-->
  <!--个人中心头部-->
  <!--<header class="centre-hd app-flex app-vertical-center" id="app" style="background-image:url(<?php echo ($headimg); ?>)">-->
  <header class="centre-hd app-flex app-vertical-center" id="app" style="background:rgba(60,200,254,.5)">
    <!--<div class="meng"></div>-->
	<div class="centre-avatar">
      <img :src="avatar_url" alt="avatar" @click="upload_avatar($event);">
    </div>
    <div class="centre-info app-basis" style="z-index:999">
      <p class="app-flex app-vertical-center">状态：
        <select name="status" id="isonline" @change="change_online_status($event);">
          <option value="1" <?php if($isonline == 1): ?>selected<?php endif; ?>>在线</option>
          <option value="2" <?php if($isonline == 2): ?>selected<?php endif; ?>>忙碌</option>
          <option value="3" <?php if($isonline == 3): ?>selected<?php endif; ?>>离线</option>
        </select>
		<span class="shuoming" @click="show_status = !show_status"></span>
      </p>
      <p>姓名：<i id="truenameids"><?php echo ($nicename); ?></i> 
	  </p>
      <p style="position:">昵称：<i id="truenameid"><?php echo ($truename); ?></i> <span class="xiugai" @click="show_layer = !show_layer"></span></p>
      <p>教龄：<?php echo ($seniority); ?>年</p>
      <p>职称：<?php echo ($title); ?></p>
      <input type="hidden" id="userid" value="<?php echo ($id); ?>">
    </div>
    <!--<div class="setting" style="z-index:1000">
      <a href="<?php echo U('User/Center/update_pwd');?>">设置</a>
    </div>-->
	<div v-show="show_status || show_layer" class="cover-layer"></div>
	<div v-show="show_status" class="status-desc" v-cloak>
		<div class="close-btn" @click="show_status = false;"></div>
		<p>在线-已准备好为学生答疑</p>
		<p>忙碌-正在答疑，暂不接受新的问题</p>
		<p>离线-下次再答疑</p>
	</div>
	<div v-show="show_layer" class="content-dialog" v-cloak>
			<div class="text-content">
				<div class="textarea">
					<textarea placeholder="输入昵称" v-model="text"></textarea>
				</div>
				<div class="dialog-btns app-flex">
					<button class="app-basis" type="button" @click="show_layer = false;">取消</button>
					<button class="app-basis" type="button" @click="update_text($event);">确定</button>
				</div>
			</div>
		</div>
  </header>

  <!--个人中心导航-->
	<div class="weui-cells">
		<a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/mystudent');?>">
			<div class="weui-cell__hd"><img src="/public/assets/xs.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>我的学生</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
		<?php if($isdaili == 1): ?><a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/myteacher');?>">
			<div class="weui-cell__hd"><img src="/public/assets/jiaoshi.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>我的教师</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a><?php endif; ?>
		<a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/certify_info');?>">
			<div class="weui-cell__hd"><img src="/public/assets/renzheng.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>认证资料</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/myincome');?>">
			<div class="weui-cell__hd"><img src="/public/assets/sr.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>
					<span style="position:relative">我的收入
					<?php if($ordercount > 0){?><i class="point"><?php echo $ordercount ?></i><span><?php }?>
					</span>
				</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="<?php echo U('User/Center/msg');?>">
			<div class="weui-cell__hd"><img src="/public/assets/xiaoxi.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>
					<span style="position:relative">消息提醒
					<?php if($msgcount > 0){?><i class="point"></i><span><?php }?>
					</span>
				</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="http://wpa.qq.com/msgrd?v=3&uin=1510065842&site=qq&menu=yes">
			<div class="weui-cell__hd"><img src="/public/assets/kefu.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
			<div class="weui-cell__bd">
				<p>在线客服</p>
			</div>
			<div class="weui-cell__ft"></div>
		</a>
	</div>
  <!--<nav class="centre-nav">
    <a href="<?php echo U('User/Center/mystudent');?>">我的学生</a>
	<?php if($isdaili == 1): ?><a href="<?php echo U('User/Center/myteacher');?>">我的教师</a><?php endif; ?>
    <a href="<?php echo U('User/Center/certify_info');?>">认证资料</a>
    <a href="<?php echo U('User/Center/myincome');?>"><span style="position:relative">我的收入<?php if($ordercount > 0){?><i class="point"></i><span><?php }?></a>
    <a href="<?php echo U('User/Center/msg');?>"><span style="position:relative">消息提醒<?php if($msgcount > 0){?><i class="point"></i><span><?php }?></a>
    <a href="http://wpa.qq.com/msgrd?v=3&uin=1510065842&site=qq&menu=yes">在线客服</a>
  </nav>-->
  <!--<div class="weui-btn-area">
		<a class="weui-btn weui-btn_primary" href="<?php echo U('User/index/logout');?>" target="_blank">退出</a>
	</div>-->
  <!--应用固定导航-->
  <section class="app-nav app-flex">
    <a class="app-basis" href="<?php echo U('portal/index/index');?>"  data-home>
      <p>首页</p>
    </a>
    <a class="app-basis active" href="<?php echo U('User/center/index');?>"  data-centre>
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
        //alert(JSON.stringify(res));
    });
  $.toast.prototype.defaults.duration = 3000;
  var app = new Vue({
    el:'#app',
    data:{
      isonline:'',
      avatar_url:'<?php echo ($headimg); ?>',
	  show_status:false,
	  show_layer: false,
	  text:'<?php echo ($truename); ?>'
    },
    methods:{
      upload_avatar:function(evt){
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
							 url: "<?php echo U('User/Center/getimgpost');?>",
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
      },
      change_online_status:function(evt){
        //状态更改成功 教师状态更改为对应的状态
        var isonline =$("#isonline").val();
        var userid =$("#userid").val();
        $.ajax({
            url: "<?php echo U('User/center/changeline');?>",
            data: {userid:userid,isonline:isonline},
            type:'POST',
            success: function (data) {
              if(data.status == 0)
              {
                $.toast("切换成功",'success');
              }              
            }
        })
      },
	  update_text:function(evt){
		//修改昵称
		var userid =$("#userid").val();
		if(this.text == '')
		{
			$.toast("请输入昵称","forbidden");
			return;
		}
		$.ajax({
			url: "<?php echo U('User/center/changetruename');?>",
            data: {userid:userid,truename:this.text},
            type:'POST',
            success: function (data) {
              if(data.status == 0)
              {
				var self =this;
				$("#truenameid").html(data.namestr);
				app.show_layer = false;
              }              
            }
		})		
	  }
    }
  });
});
</script>
</html>