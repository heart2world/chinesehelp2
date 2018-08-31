<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>修改个人资料</title>
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
</head>
<style>
	.weui-select{ height:24px;line-height:24px}
	.weui-btn_primary{background-color:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{background-color:#3cc8fe}
	.weui-select{ padding-left:0}
</style>
<body data-app="ChineseBang">
	<!--提交个人资料-->
	<section id="app">
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><img src="/public/assets/nicheng.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
                <div class="weui-cell__hd" style="min-width:66px">
                    <p>昵称</p>
                </div>
                <div class="weui-cell__bd">
					<input type="text" name="nicename" placeholder="请输入昵称" maxlength="10" v-model="uname" >
				</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><img src="/public/assets/xingbie.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
                <div class="weui-cell__hd" style="min-width:66px">
                    <p>性别</p>
                </div>
                <div class="weui-cell__bd">
					<select class="weui-select" name="gender" v-model="gender">
						<option value="0">请选择性别</option>
						<option value="男">男</option>
						<option value="女">女</option>
						<option value="其他">其他</option>
                    </select>
				</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><img src="/public/assets/nianlin.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
                <div class="weui-cell__hd" style="min-width:66px">
                    <p>年龄</p>
                </div>
                <div class="weui-cell__bd">
					<select class="weui-select" name="gender" v-model="nl">
					    <option value="">请选择年龄</option>
					    <option value="10">10</option>
					    <option value="11">11</option>
					    <option value="12">12</option>
					    <option value="13">13</option>
					    <option value="14">14</option>
					    <option value="15">15</option>
					    <option value="16">16</option>
					    <option value="17">17</option>
					</select>
				</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><img src="/public/assets/nianji.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
                <div class="weui-cell__hd" style="min-width:66px">
                    <p>年级</p>
                </div>
                <div class="weui-cell__bd">
					<select class="weui-select" name="gender" v-model="grade">
					    <option value="">请选择年级</option>
					    <option value="五年级">五年级</option>
					    <option value="六年级">六年级</option>
					    <option value="初一">初一</option>
					    <option value="初二">初二</option>
					    <option value="初三">初三</option>
					</select>
				</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><img src="/public/assets/xuexiao.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
                <div class="weui-cell__hd" style="min-width:66px">
                    <p>学校</p>
                </div>
                <div class="weui-cell__bd">
					<input type="text" name="school" placeholder="请输入学校名称" maxlength="20" v-model="school" >
				</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><img src="/public/assets/shouji.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
                <div class="weui-cell__hd" style="min-width:66px">
                    <p>手机</p>
                </div>
                <div class="weui-cell__bd">
					<input type="phone" style="width:100%" name="phone" placeholder="教师回答问题后将短信通知您" maxlength="11" v-model="phone" >
				</div>
            </div>
        </div>
		<div class="weui-btn-area" style="margin:15px">
			<input type="hidden" id="userid" value="<?php echo ($member["id"]); ?>">
            <a class="weui-btn weui-btn_primary" @click="save($event);" id="showTooltips">提 交</a>
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
			uname:'<?php echo ($member["nicename"]); ?>',
			gender:'<?php echo ($member["sex"]); ?>',
			nl:'<?php echo ($member["age"]); ?>',
			grade:'<?php echo ($member["classname"]); ?>',
			school:'<?php echo ($member["schoolname"]); ?>',
			phone:'<?php echo ($member["mobile"]); ?>'
		},
		methods:{
			save:function(evt){
				if(this.uname == ''){
					$.toptip("请输入昵称",1500,'warning');
					return;
				}
				if(this.gender == '0'){
					$.toptip("请选择性别",1500,'warning');
					return;
				}
				if(this.nl == ''){
					$.toptip("请选择年龄",1500,'warning');
					return;
				}
				if(this.grade == ''){
					$.toptip("请选择年级",1500,'warning');
					return;
				}
				if(this.school == ''){
					$.toptip("请输入学校",1500,'warning');
					return;
				}
				if(this.phone == ''){
					$.toptip("请输入手机号",1500,'warning');
					return;
				}
				if(!comJs._validateIsPhoneNum(this.phone)){
					$.toptip("手机格式有误",1500,'warning');
					return;
				}
				
				var sinfo ={
					"nicename":this.uname,
					"sex" :this.gender,
					"age" :this.nl,
					"classname":this.grade,
					"schoolname":this.school,
					"mobile":this.phone,
					"id":$("#userid").val()
				};
				$.showLoading("正在保存");
				$.ajax({
					 	url: "<?php echo U('Home/Center/doedit');?>",
                        data: sinfo,
                        type:'POST',
                        success: function (data) {
                        	if(data.status ==1)
                        	{
                        		setTimeout(function(){
									//保存成功
									$.hideLoading();
									$.toast("保存成功",'1500',function(){
										//返回个人中心
										location.href=data.url;
									});
								},1500);
                        	}else{
                        		$.hideLoading();
                        		$.toast(data.msg,"forbidden");
                        	}
                        }
				})
				
			}
		}
	});
</script>
</html>