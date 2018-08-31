<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>我要提问</title>
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
	.weui-btn-area{ padding:1rem; margin:0}
	.weui-btn_primary{ background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
	body .weui-cells:after{ border:none}
	.weui-label,.weui-cell__bd input::-webkit-input-placeholder{ font-size:.8rem !important}
	.weui-label{ width:100%}
</style>
<body data-app="ChineseBang">
	<section id="app">
		<audio src="/public/media/9797.mp3" id="aud" controls></audio>
		<!--教师头部信息-->
		<header class="teacher-hd-info del-border" style="padding:0">
			<div class="teacher-hd-title" style="padding:.5rem 1rem">指定答题老师</div>
			<div class="teacher-top app-flex app-vertical-center" style="padding:0 1rem .5rem;border-bottom:1px solid #f0eff4">
				<div class="teacher-image" style="align-self:flex-start">
					<img src="<?php echo ($tinfo["headimg"]); ?>" alt="img">
				</div>
				<div class="info-content tiwen app-basis">
					<h4 style="font-size:.8rem;color:#595959"><?php echo ($tinfo["truename"]); ?></h4>
					<p style="font-size:.7rem;color:#999"><?php echo ($tinfo["honors"]); ?></p>
					<p style="font-size:.7rem; color:#999">综合评分: <span style="color:#999"><?php echo ($tinfo["star"]); ?></span></p>
					<div class="info-btm app-flex">
						<h4 class="dati"><?php echo ($tinfo["qcount"]); ?></h4>
						<h5 class="sc"><?php echo ($tinfo["colcount"]); ?></h5>
					</div>
				</div>
			</div>
		</header>
		<!--提问板块-->
		<aside class="want-box" style="padding:0">
			<form id="tagforms" class="weui-cells weui-cells_form" method="post" enctype="multipart/form-data">
				<div class="weui-cell">
					<div class="weui-cell__hd" style="width:50px"><label class="weui-label">问题</label></div>
					<div class="weui-cell__bd">
						<input type="text" class="weui-input" name="qname" style="width:100%;height:100%" id="title" placeholder="请在此输入问题标题">
					</div>
				</div>
				<!--<div class="want-panel app-flex app-vertical-center">
					<label>问题：</label>
					<div class="input-control app-basis">
						<input type="text" name="qname" id="title" placeholder="请在此输入问题标题">
					</div>
				</div>-->
					<div class="weui-cell">
						<div class="weui-cell__hd"><label class="weui-label">描述</label></div>
						<div class="weui-cell__bd"></div>
					</div>
				<div class="want-panel">
					<div class="input-control app-basis richtext" style="padding:0;margin:0;border:0">
						<!--内容区域-->
						<div id="form-content-wrap" style="min-height:5rem;padding:0 1rem 1rem">
						<input type="hidden" id="cctype" value="1">	
						</div>
						<div class="pub-btns app-flex">
							<div class="app-basis text" @click="upload_content($event,2);"></div>
							<div class="app-basis voice" @click="upload_content($event,1);"></div>
							<div class="app-basis pic" @click="upload_content($event,3);"></div>
						</div>
					</div>
				</div>
				<input type="hidden" name="teacherid" value="<?php echo ($tinfo["id"]); ?>">
				<input type="hidden" name="parentid" value="<?php echo ($parentid); ?>">
				<div style="padding: 0.5rem 0 0.75rem; text-align: center; font-size: 0.55rem; color: #595959;">温馨提示：若文字编辑不便，您可将内容转化为图片上传</div>
				
				<!--<div class="subbtn" @click="question_baocun($event);">提问</div>-->
			</form>
			<div class="weui-btn-area">
				<a class="weui-btn weui-btn_primary" href="javascript:" @click="question_baocun($event);">提 问</a>
			</div>
		</aside>
			<div v-if="show_layer" class="cover-layer pop-layer" v-cloak></div>
			<div v-if="show_layer2" class="cover-layer pop-layer" v-cloak></div>
			<div v-if="show_layer3" class="cover-layer pop-layer" v-cloak></div>
			<!--上传编辑内容弹出-->
			<div v-if="show_layer" class="content-dialog" v-cloak>
				<!--语音-->
				<div v-if="pop_type == 1">
					<div v-if="type !=2" class="close-btn" @click="show_layer = false;"></div>
					<div class="audio-content">
						<h3 :class="{'recording':recording}" class="audio-icon"></h3>
						<h4 v-text="record_text"></h4>
						<div class="dialog-btns app-flex">
							<button class="app-basis" type="button" @click="start_record($event,type);" v-text="record_status_text"></button>
							
						</div>
					</div>
				</div>
				<!--文字描述-->
				<div v-if="pop_type == 2">
					<div class="close-btn" @click="show_layer = false;"></div>
					<div class="text-content">
						<div class="textarea">
							<textarea type="text" placeholder="输入文字描述内容" v-model="text"></textarea>
						</div>
						<div class="dialog-btns app-flex">
							<button class="app-basis" type="button" @click="show_layer = false;">取消</button>
							<button class="app-basis" type="button" @click="upload_text($event);">确定</button>
						</div>
					</div>
				</div>
			</div>
			<div v-show="show_layer2" class="select-panel" v-cloak>
				<div class="toolbar2 app-flex app-vertical-center">
					<h4 @click="show_layer2 = false;">取消</h4>
					<div class="app-basis">选择类型</div>
					<h5 @click="select_upload_type($event);">确定</h5>
				</div>
				<p :class="{'cur':type_index == 1}" @click="type_index = 1;">语音</p>
				<p :class="{'cur':type_index == 2}" @click="type_index = 2;">文字</p>
				<p :class="{'cur':type_index == 3}" @click="type_index = 3;">图片</p>
			</div>
			
			<div v-show="show_layer3" class="select-panel select-item-panel" v-cloak>
				<div class="toolbar2 app-flex app-vertical-center">
					<h4 @click="show_layer3 = false;">取消</h4>
					<div class="app-basis">选择编辑选项</div>
					<h5 @click="select_upload_type2($event);">确定</h5>
				</div>
				<p :class="{'cur':item_index == 1}" class="alternate2">编辑/替换</p>
				<p :class="{'cur':item_index == 2}" class="del">直接删除</p>
				<p :class="{'cur':item_index == 3}" class="append">在此后插入</p>
			</div>
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
			"startRecord",
			"stopRecord",
			"onVoiceRecordEnd",
			"playVoice",
			"pauseVoice",
			"stopVoice",
			"onVoicePlayEnd",
			"uploadVoice",
			"downloadVoice",
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
	var voice = { localId: '',serverId: '' };
	
	$.toast.prototype.defaults.duration = 3000;
	var $wrapper = $("#form-content-wrap");
	var audio = document.querySelector("#aud");
	var m=0;
	//监听语音控件是否处于暂停状态
	audio.addEventListener("pause",function(){
		$("#form-content-wrap").find(".playing").removeClass("playing").text("播放")
	})
	var app = new Vue({
		el:'#app',
		data:{
			type_index:1,
			show_layer:false,
			show_layer2:false,
			record_text:'',
			recording:false,
			record_status_text:'开始录音',
			type:1,
			pop_type:1,
			text:'',
			pend_type:1,
			obj:null,
			pend_other_rows:false,
			item_index:1,
			show_layer3:false
		},
		methods:{
			question_baocun:function(evt)
			{
				var title =$("#title").val();
				if(title == '')
				{
					$.toast("请输入问题标题","forbidden");
					return;
				}
				var cctype =$("#cctype").val();
				if(cctype == 0)
				{
					$.toast("请输入问题内容","forbidden");
					return;
				}
				$.showLoading("正在提交");
				var tagvals=$('#tagforms').serialize();
				$.ajax({
					url:"<?php echo U('Home/Problem/questionaddinfo');?>",
					data:tagvals,
					type:'POST',
					success:function(data)
					{
						if(data.status == 1)
						{
							setTimeout(function(){
								//提交信息成功
								$.hideLoading();
								$.toast("您的问题已提交成功，请耐心等待老师的回答~",'3000',function(){
									//回到首页
									location.href = "<?php echo U('Home/Center/mypub');?>";
								});
							},500);
						}
					}
				})
			},
			upload_content:function(evt,ctype,pend){
				//选择内容弹窗
				var self = this;
				self.pop_type = ctype;
				self.show_layer3 = false;
				if(arguments[2] == 'pend'){
					self.pend_type = 2;
				}else if(arguments[2] == 'pendto'){
					self.pend_type = 4;
				}else{
					self.pend_type = 1;
				}
				if(ctype == 1 || ctype == 2){
					//非图片
					self.show_layer = true;
				}
				
				//上传图片
				if(ctype == 3){
					console.log(ctype);
					if(self.pend_type == 2){
						 console.log(66);
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
										 url: "<?php echo U('Home/Problem/getimgpost');?>",
										 data: {"access_token":"<?php echo $signPackage['token'];?>","media_id":serverId},
										 success: function (res) {
											$.hideLoading();
										    if(res.status==1)
										    {
											
												  var img_hml2 = '<div class="picture">'+
														'<img src="'+res.strimgurl+'" alt="">'+
													'</div>'+
													'<div style="text-align:right">'+
													'<button class="alternate" type="button" data-type="picture"></button>'+
													'</div>'+
													'<input type="hidden" name="content[]" value="'+res.strimgurl+'">'+
													'<input type="hidden" name="atime[]" value="0">'+
													'<input type="hidden" name="atype[]" value="img">';	
												$(self.obj).parents('.picture-panel').html(img_hml2);
												m=m+1;
												$("#cctype").val(m);
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
					}else if(self.pend_type == 4){
						console.log(12);
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
										 url: "<?php echo U('Home/Problem/getimgpost');?>",
										 data: {"access_token":"<?php echo $signPackage['token'];?>","media_id":serverId},
										 success: function (res) {
											$.hideLoading();
										    if(res.status==1)
										    {
												 var img_hml3 = '<div class="picture-panel pub-box app-vertical-center app-content-justify">'+
															'<div class="picture">'+
																'<img src="'+res.strimgurl+'" alt="">'+
															'</div>'+
															'<div style="text-align:right">'+
															'<button class="alternate" type="button" data-type="picture"></button>'+
															'</div>'+
															'<input type="hidden" name="content[]" value="'+res.strimgurl+'">'+
															'<input type="hidden" name="atime[]" value="0">'+
															'<input type="hidden" name="atype[]" value="img">'+
															'</div>';
													$(self.obj).parents('.pub-box').after(img_hml3);
													m=m+1;
													$("#cctype").val(m);
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
					}else{
						console.log(34);
						wx.chooseImage({
						   count: 9, 
							 success: function (res) {
								var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片       
								syncUpload(localIds.reverse()); 
							 }
						});  
						var syncUpload = function(localIds){  
							var localId = localIds.pop();  
							wx.uploadImage({  
								localId: localId,  
								isShowProgressTips: 0,  
								success: function (res) {  
									var serverId = res.serverId; // 返回图片的服务器端ID  
									 $.ajax({
										 type: "POST",
										 url: "<?php echo U('Home/Center/getimgpost');?>",
										 data: {"access_token":"<?php echo $signPackage['token'];?>","media_id":serverId},
										 success: function (res) {
											
											if(res.status==1)
											{
												var img_hml = '<div class="picture-panel pub-box app-vertical-center app-content-justify">'+
														'<div class="picture">'+
															'<img src="'+res.strimgurl+'" alt="">'+
														'</div>'+
														'<div style="text-align:right">'+
														'<button class="alternate" type="button" data-type="picture"></button>'+
														'</div>'+
														'<input type="hidden" name="content[]" value="'+res.strimgurl+'">'+
														'<input type="hidden" name="atime[]" value="0">'+
														'<input type="hidden" name="atype[]" value="img">'+
													'</div>';		
												$("#form-content-wrap").append(img_hml);
												m=m+1;
												$("#cctype").val(m);
											}
										 }
									   });
									//其他对serverId做处理的代码  
									if(localIds.length > 0){  
										syncUpload(localIds);  
									}  
										 
								},
								fail: function (res) {
								  alert("图片上传失败"); 
								}
					 
							});
						}
					}
					//重置为默认
					self.pop_type = 1;
				}
				
			},
			upload_text:function(evt,isedit){
				//上传文字描述
				var self = this;
				var self = this;
				if(self.text.replace(/\s/g,'') == ''){
					$.toast("输入文字描述",'text');
					self.text = '';
					return;
				}
				var text_hml = '<section class="pub-text pub-box app-content-justify">'+
							'<div class="text">'+self.text+'</div>'+
							'<div style="text-align:right">'+
								'<button class="alternate" type="button" data-type="text"></button>'+
							'</div>'+
							'<input type="hidden" name="content[]" value="'+self.text+'">'+
							'<input type="hidden" name="atime[]" value="0">'+
							'<input type="hidden" name="atype[]" value="text">'+
						'</section>';
				if(self.pend_type == 2){
					$(self.obj).parents('.pub-text').find(".text").text(self.text);
					m=m+1;
				}else if(self.pend_type == 4){
					var text_hml2 = '<section class="pub-text pub-box app-content-justify">'+
					'<div class="text">'+self.text+'</div>'+
					'<div style="text-align:right">'+
						'<button class="alternate" type="button" data-type="text"></button>'+
					'</div>'+
					'<input type="hidden" name="content[]" value="'+self.text+'">'+
					'<input type="hidden" name="atime[]" value="0">'+
					'<input type="hidden" name="atype[]" value="text">'+
				'</section>';
					$(self.obj).parents('.pub-box').after(text_hml2);
					m=m+1;
				}else{
					$("#form-content-wrap").append(text_hml);
					m=m+1;
				}
				
				$("#cctype").val(m);
				self.text ='';
				self.show_layer = false;
				//重置为默认
				self.pop_type = 1;
			},
			start_record:function(evt,type){
				//点击开始录音 调用微信录音api接口wx.startRecord
				var self = this;
				if(type == 1){
					//可以录音
					self.record_text = "";
					self.recording = true;
					self.record_status_text = '结束并上传';
					
					event.preventDefault();
					START = new Date().getTime();
					recordTimer = setTimeout(function(){
						wx.startRecord({
							success: function(){
								localStorage.rainAllowRecord = 'true';
							},
							cancel: function () {
								alert('用户拒绝授权录音');
							}
						});
					},300);
					self.type = 2;//录音完毕 试听
					ttt=setTimeout(function(){
						self.show_layer = false;
						//初始化
						self.record_text = "";
						self.recording = false;
						self.record_status_text = '开始录音';
						self.type = 1;//继续录音
						self.upload_audio2(evt,self.pend_type);
					},60000);
				}else if(type == 2){
					//可以继续录音					
					self.record_text = "";
					self.upload_audio(evt,self.pend_type);					
				}
			},
			upload_audio2:function(evt,ispend){
				END = new Date().getTime();	
				var chatime =END-START;
				$.showLoading("上传中...");
				wx.stopRecord({
					  success: function (res) {						
						voice.localId = res.localId;
						wx.uploadVoice({
							localId: voice.localId, // 需要上传的音频的本地ID，由stopRecord接口获得
							isShowProgressTips: 0, // 默认为1，显示进度提示
							success: function (res) {
								
								//把录音在微信服务器上的id（res.serverId）发送到自己的服务器供下载。
								$.ajax({
									url: "<?php echo U('Home/Problem/getpost');?>",
									type: 'post',
									data: {"serverId":res.serverId,"access_token":"<?php echo $signPackage['token'];?>","chatime":chatime},
									success: function (data) {
										if(data.status == 0)
										{
											alert("文件下载失败");
										}else
										{
										    $.hideLoading();
											$.toast("上传成功",'text',function(){
												
												//追加语音
												var audio_hml = '<section class="audio-panel pub-box app-vertical-center app-content-justify">'+
													'<div class="app-flex app-vertical-center app-hrizontal-center">'+
													'<div class="audio-item" data-audio-src="'+data.strfileurl+'">播放</div>'+
													'<div class="time">'+data.chatime+'\"</div>'+
													'</div>'+
													'<div style="text-align:right">'+
													'<button class="alternate" type="button" data-type="audio"></button>'+
													'</div>'+
													'<input type="hidden" name="content[]" value="'+data.strfileurl+'">'+
													'<input type="hidden" name="atime[]" value="'+data.chatime+'">'+
													'<input type="hidden" name="atype[]" value="audio">'+
													'</section>';
												//判断是替换还是添加
												console.log(ispend);
												if(ispend == 1){
													$("#form-content-wrap").append(audio_hml);
													m=m+1;
													$("#cctype").val(m);
												}else if(ispend == 4){
													var audio_hml3 = '<section class="audio-panel pub-box app-vertical-center app-content-justify">'+
													'<div class="app-flex app-vertical-center app-hrizontal-center">'+
													'<div class="audio-item" data-audio-src="'+data.strfileurl+'">播放</div>'+
													'<div class="time">'+data.chatime+'\"</div>'+
													'</div>'+
													'<div style="text-align:right">'+
													'<button class="alternate" type="button" data-type="audio"></button>'+
													'</div>'+
													'<input type="hidden" name="content[]" value="'+data.strfileurl+'">'+
													'<input type="hidden" name="atime[]" value="'+data.chatime+'">'+
													'<input type="hidden" name="atype[]" value="audio">'+
													'</section>';
													$(self.obj).parents('.pub-box').after(audio_hml3);
												}else{
													var audio_hml2 ='<div class="app-vertical-center app-hrizontal-center">'+
													'<div class="audio-item" data-audio-src="'+data.strfileurl+'">播放</div>'+
													'<div class="time">'+data.chatime+'\"</div>'+
													'</div>'+
													'<div style="text-align:right">'+
													'<button class="alternate" type="button" data-type="audio"></button>'+
													'</div>'+
													'<input type="hidden" name="content[]" value="'+data.strfileurl+'">'+
													'<input type="hidden" name="atime[]" value="'+data.chatime+'">'+
													'<input type="hidden" name="atype[]" value="audio">';
													$(app.obj).parents('.audio-panel').html(audio_hml2);
													m=m+1;
													$("#cctype").val(m);
												}											
											});								
										}
									},
									error: function (xhr, errorType, error) {
										console.log(error);
									}
								});
							}
						});
					  },
					  fail: function (res) {
						$.hideLoading();
					  }
					});
			},
			upload_audio:function(evt,ispend){
				var self = this;
				if(self.type != 2){
					$.toast("请确定已经录音",'text');
					return;
				}
				event.preventDefault();
				clearTimeout(ttt);
				END = new Date().getTime();					
				if((END - START) < 1000){
					END = 0;
					START = 0;
					clearTimeout(recordTimer);	
					wx.stopRecord({
						success: function (res) {						
							voice.localId = res.localId;
						}
					})
					$.toast("录音无效，请重新录音",'forbidden');
					self.show_layer = false;
					//初始化
					self.record_text = "";
					self.recording = false;
					self.record_status_text = '开始录音';
					self.type = 1;//继续录音
					return;
				}else{
					//上传语音
					var chatime = END-START;
					if(chatime<60000){
					$.showLoading("上传中...");
					wx.stopRecord({
					  success: function (res) {						
						voice.localId = res.localId;
						wx.uploadVoice({
							localId: voice.localId, // 需要上传的音频的本地ID，由stopRecord接口获得
							isShowProgressTips: 0, // 默认为1，显示进度提示
							success: function (res) {
								//把录音在微信服务器上的id（res.serverId）发送到自己的服务器供下载。
								$.ajax({
									url: "<?php echo U('Home/Problem/getpost');?>",
									type: 'post',
									data: {"serverId":res.serverId,"access_token":"<?php echo $signPackage['token'];?>","chatime":chatime},
									success: function (data) {
										if(data.status == 0)
										{
											$.hideLoading();
											$.toast("文件下载失败",'forbidden');
										}else
										{
											$.hideLoading();
											if(data.chatime >100 || data.chatime == 0)
											{
												$.toast("录音无效，请重新录音",'forbidden');
												self.show_layer = false;
												//初始化
												self.record_text = "";
												self.recording = false;
												self.record_status_text = '开始录音';
												self.type = 1;//继续录音
											}else{										   
												setTimeout(function(){
													//$.hideLoading();
													$.toast("上传成功",'text',function(){
														self.show_layer = false;
														//初始化
														self.record_text = "";
														self.recording = false;
														self.record_status_text = '开始录音';
														self.type = 1;//继续录音
														//追加语音
														var audio_hml = '<section class="audio-panel pub-box app-vertical-center app-content-justify">'+
															'<div class="app-flex app-vertical-center app-hrizontal-center">'+
															'<div class="audio-item" data-audio-src="'+data.strfileurl+'">播放</div>'+
															'<div class="time">'+data.chatime+'\"</div>'+
															'</div>'+
															'<div style="text-align:right">'+
															'<button class="alternate" type="button" data-type="audio"></button>'+
															'</div>'+
															'<input type="hidden" name="content[]" value="'+data.strfileurl+'">'+
															'<input type="hidden" name="atype[]" value="audio">'+
															'<input type="hidden" name="atime[]" value="'+data.chatime+'">'+
															'</section>';
														//判断是替换还是添加
														console.log(ispend);
														if(ispend == 1){
															$("#form-content-wrap").append(audio_hml);
															m=m+1;
															$("#cctype").val(m);
														}else if(ispend == 4){
															var audio_hml3 = '<section class="audio-panel pub-box app-vertical-center app-content-justify">'+
															'<div class="app-flex app-vertical-center app-hrizontal-center">'+
															'<div class="audio-item" data-audio-src="'+data.strfileurl+'">播放</div>'+
															'<div class="time">'+data.chatime+'\"</div>'+
															'</div>'+
															'<div style="text-align:right">'+
															'<button class="alternate" type="button" data-type="audio"></button>'+
															'</div>'+
															'<input type="hidden" name="content[]" value="'+data.strfileurl+'">'+
															'<input type="hidden" name="atype[]" value="audio">'+
															'<input type="hidden" name="atime[]" value="'+data.chatime+'">'+
															'</section>';
															$(self.obj).parents('.pub-box').after(audio_hml3);
														}else{
															var audio_hml2 ='<div class="app-vertical-center app-hrizontal-center">'+
															'<div class="audio-item" data-audio-src="'+data.strfileurl+'">播放</div>'+
															'<div class="time">'+data.chatime+'\"</div>'+
															'</div>'+
															'<div style="text-align:right">'+
															'<button class="alternate" type="button" data-type="audio"></button>'+
															'</div>'+
															'<input type="hidden" name="content[]" value="'+data.strfileurl+'">'+
															'<input type="hidden" name="atime[]" value="'+data.chatime+'">'+
															'<input type="hidden" name="atype[]" value="audio">';
															$(app.obj).parents('.audio-panel').html(audio_hml2);
															m=m+1;
															$("#cctype").val(m);
														}
														//重置为默认
														self.record_text = "";
														self.recording = false;
														self.record_status_text = '开始录音';
														self.type = 1;//继续录音
														self.pop_type = 1;
													});
												},500);
											}
										}
									},
									error: function (xhr, errorType, error) {
										console.log(error);
									}
								});
							}
						});
					  },
					  fail: function (res) {
						$.hideLoading();
					  }
					});
					}
				}			
			},
			select_upload_type:function(evt){
				//选择继续追加类型
				var self = this;
				self.pop_type = self.type_index;
				self.pend_type = 4;
				self.upload_content(evt,self.pop_type,'pendto');
				self.show_layer2 = false;
			},
			select_upload_type2:function(evt){
				//确认编辑
				if(this.item_index == 1){
					//表示替换
					var data_type = $(app.obj).data("type");
					app.item_index = 1;
					//console.log(data_type);
					//根据data_type判断是删除哪种类型的数据
					app.pend_type = 2;
					if(data_type == 'audio'){
						app.upload_content(evt,1,'pend')
					}else if(data_type == 'picture'){
						app.upload_content(evt,3,'pend');
					}else if(data_type == 'text'){
						app.text = $(app.obj).parents('.pub-text').find('.text').text();
						app.pend_type = 3;
						app.upload_content(evt,2,'pend');
					}
					app.show_layer3 = false;			
				}
			if(this.item_index == 2){
				//删除
				var data_type = $(app.obj).data("type");
				if(data_type == 'text'){
					//删除文本描述
					$(app.obj).parents('.pub-text').remove();
				}
				if(data_type == 'audio'){
					//删除语音
					$(app.obj).parents('.audio-panel').remove();
				}
				if(data_type == 'picture'){
					//删除图片
					$(app.obj).parents('.picture-panel').remove();
				}
				app.show_layer3 = false;
			}
			if(this.item_index == 3){
				//插入一条
				//app.obj = $(app.obj).data('type') == 'text' ? $(app.obj).parents('.pub-text') :  $(app.obj).parent();
				app.show_layer3 = false;
				app.show_layer2 = true;
			}
			}
		}
	});

	//弹出编辑选项栏
	$("#form-content-wrap").on('click','.alternate',function(evt){
		app.obj = $(this);
		app.show_layer3 = true;
		audio.pause();
	})

	//根据具体类型替换相应的内容
	$(".select-item-panel").on('click','.alternate2',function(evt){
		//console.log(111);
		app.item_index = 1;
	})

	//操作语音dom
	//删除语音
	$(".select-item-panel").on('click','.del',function(){
		app.item_index = 2;
	});

	//当前追加其他类型的数据条目
	$(".select-item-panel").on('click','.append',function(evt){
		//选择类型
		app.item_index = 3;
	});
	//播放语音控件
	$("#form-content-wrap").on('click','.audio-item',function(evt){
		console.log(audio.duration);
		console.log(audio.readyState);
		var that = $(this);
		var src = that.data("audio-src");
		$(this).parent('.audio-panel').siblings().find(".audio-item").removeClass("playing");
		$(this).parent('.audio-panel').siblings().find(".audio-item").text("播放");
		audio.src= src;
		//判断语音是否可以正常播放
		audio.addEventListener("error",function(){
			$.toast("语音错误",'cancel');
			that.removeClass("playing");
			that.text("播放");
			audio.pause();
		});

		if($(this).hasClass('playing')){
			$(this).removeClass("playing");
			$(this).text("播放");
			audio.pause();
		}else{
			$(this).addClass("playing");
			$(this).text("暂停");
			audio.play();
		}
		audio.addEventListener("ended",function(){
			that.removeClass("playing");
			that.text("播放");
		});
		console.log(audio);
	});
	
});
</script>
</html>