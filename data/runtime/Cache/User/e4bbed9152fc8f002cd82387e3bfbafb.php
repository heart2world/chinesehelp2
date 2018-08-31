<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>登录</title>
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
</head>
<style>
	.weui-btn_primary{ background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
	.getCode.active{ color: #ccc !important; }
	.weui-cells:after{border:none}
</style>
<body data-app="ChineseBang">
	<!--教师登录-->
	<section class="form-container" id="app" style="padding:0;">
		<div class="weui-cells weui-cells_form">
            <div class="weui-cell">
				<div class="weui-cell__hd">
					<img src="/public/assets/shoujiduan.png" alt="" style="width:20px;margin-right:5px;display:block">
				</div>
                <div class="weui-cell__hd">
                    <label class="weui-label" style="width:60px">手机号</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" id="telInput" type="phone" name="phonenum" placeholder="请输入手机号" maxlength="11" v-model="phonenum">
                </div>
            </div>
			<div class="weui-cell weui-cell_vcode">
				<div class="weui-cell__hd">
					<img src="/public/assets/yanzhengma.png" alt="" style="width:20px;margin-right:5px;display:block">
				</div>
                <div class="weui-cell__hd">
                    <label class="weui-label" style="width:60px">验证码</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="code" v-model="code" placeholder="请输入验证码">
                </div>
                <div class="weui-cell__ft">
                    <button class="weui-vcode-btn on getCode" id="yzCxmAndCxmm" style="color:#3cc8fe;font-size:14px">获取验证码</button>
                </div>
            </div>
        </div>
		
		<div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" @click="login($event);">保 存</a>
        </div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/script/common.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			phonenum:'',
			code:'',
		},
		methods:{
			login:function(evt){
				if(this.phonenum == ''){
					$.toptip("输入手机号",1500,'warning');
					return;
				}
				if(!comJs._validateIsPhoneNum(this.phonenum)){
					$.toptip("手机格式有误",1500,'warning');
					return;
				}
				if(this.code == ''){
					$.toptip("输入验证码",1500,'warning');
					return;
				}

				$.showLoading("登录中...");
				$.ajax({
                        url: "<?php echo U('User/Center/dologinmobile');?>",
                        data: {mobile:this.phonenum,yzcode:this.code},
                        type:'POST',
                        success: function (data) {
                        	console.log(data.msg);
                            if (data.status==0) {                               
                                //数据提交成功后关闭提示
  								setTimeout(function(){
  									$.hideLoading();
  									$.toast("登录成功！",'text',function(){
  										setTimeout(function(){
  											//跳转会员中心
  											location.href=data.url;
  										},500);
  									})
  								},1500)
                            }
                            else {
                                //跳转到预定失败界面
                                $.hideLoading();
                                $.toast(data.msg,'forbidden');
                            }
                        }
                });		
			}
		}
	});
//获取验证码
var bj = 0;
var countdown = 60;
function settime(val) {
	if(countdown == 0) {
		$('.getCode').text('获取验证码').addClass('on');
		$('.getCode').removeClass("active");
		countdown = 60;
		bj = 0;
		return;
	} else {
		$('.getCode').text(countdown + 's后重新发送');
		$('.getCode').addClass("active");
		countdown--;
	}
	setTimeout(function() {
		settime(val)
	}, 1000)
}
$(function(){
	$('.getCode').click(function(){
		if($(this).hasClass("on")){
			var phone=$('#telInput').val();
			console.log(phone);
			if(!comJs._validateIsPhoneNum(phone))
			{
				$.toptip("输入正确的手机号",1500,'warning');
				return false;
			}else{
				$('#yzCxmAndCxmm').attr("disabled","disabled");
				$.ajax({
					url: "<?php echo U('Api/Mobileverify/send_msg');?>",
					data: {send_address:phone,send_type:0},
					type:'POST',
					success: function (data) {
						$("#yzCxmAndCxmm").removeAttr("disabled"); 
						if (data.state==1) { 								
							$.toast(data.error, 'forbidden');
							return;
						}else{								
							settime(countdown);
							$(this).removeClass('on').addClass('active');
							 
						}
					}
				});		
				
			}			
		}
	})
})

</script>
</html>