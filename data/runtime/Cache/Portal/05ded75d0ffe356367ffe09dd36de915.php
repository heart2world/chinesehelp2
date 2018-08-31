<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>微课</title>
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
	<script src="/public/libs/swiper.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	
	<style>
		body .weui-dialog__btn{ color:#3cc8fe}
		body #form-content-wrap img{ max-width:100%}
		body .toolbar .picker-button{ color:#3cc8fe;}
		body .weui-cells_checkbox .weui-check:checked+.weui-icon-checked:before{ color:#3cc8fe;}
		.actionUl { position:absolute; top:100%;right:1rem;background:#fff;border-radius:3px;z-index:1001;display:none}
		.actionUl>li{ padding:.3rem 2rem;border-bottom:1px solid #e1e1e1;font-size:.8rem}
		.actionUl>li:last-child{border:0}
		.ztList{ position:fixed;bottom:0;left:0;right:0;background:rgba(0,0,0,.1);z-index:9999;display:none}
		.ztList .content{ position:absolute; bottom:0; left:0;right:0; background:#fff;}
		.ztList .content .tit{height:2.2rem;line-height:2.2rem;background:#f1f1f1; padding:0 15px}
		.weui-cells_checkbox .weui-check:checked+.weui-icon-checked:before{ color:#3cc8fe}
		
	</style>
	
</head>
<body data-app="ChineseBang">
	<audio src="/public/media/9797.mp3" id="aud" controls></audio>
	<section id="app" style="padding-bottom: 3rem;">
		<nav class="top-nav app-flex">
			<div :class="{'cur':cur_index == 1}" class="nav-cell app-basis" @click="change_tab($event,'1');">发表微课</div>
			<div :class="{'cur':cur_index == 2}" class="nav-cell app-basis" @click="change_tab($event,'2');">我的微课</div>
		</nav>
		<!--发表微课-->
		<section v-show="cur_index == 1" class="pub-container form-container" v-cloak style="padding:2.25rem 0 1rem">
			<form class="weui-cells weui-cells_form" id="tagforms" method="post" enctype="multipart/form-data">
				<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label">课程名称</label></div>
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" name="title" placeholder="请输入课程名称" value="" maxlength="20" v-model="lesson_name">
					</div>
				</div>
				<div class="weui-cell" style="padding:1px 15px">
					<div class="weui-cell__hd"><label class="weui-label">课程类型</label></div>
					<div class="weui-cell__bd">
						<select name="lesson_type" class="weui-select" v-model="select_lesson_type" style="padding-left:0">
							<option value="">请选择课程类型</option>
							<?php if(is_array($qtypelist)): $i = 0; $__LIST__ = $qtypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["typename"]); ?>" <?php if($taskinfo['classtype'] == $va['typename']): ?>selected<?php endif; ?>><?php echo ($va["typename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label">设置价格</label></div>
					<div class="weui-cell__bd">
						<input type="number" name="price" value="" pattern="[0-9]*" placeholder="单位（元）；可为'0'" maxlength="5" v-model="lesson_price">
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd" style="align-self: flex-start;"><label class="weui-label">课程简介</label></div>
					<div class="weui-cell__bd">
						<textarea class="weui-textarea" rows="3" placeholder="请输入课程简介（最多50字）" name="brief" maxlength="50" v-model="lesson_desc" value="<?php echo ($taskinfo["brief"]); ?>"></textarea>
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label">课程内容</label></div>
					<div class="weui-cell__bd">
						
					</div>
				</div>
			
			<div class="input-cell" style="margin-bottom:0">
				<div class="input-control app-basis richtext" style="margin-bottom:0">
					<!--内容区域-->
					<div id="form-content-wrap" style="min-height:5rem;padding:0 15px 1rem">
						<?php if(is_array($imgtaudio)): $i = 0; $__LIST__ = $imgtaudio;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'audio'): ?><section class="audio-panel pub-box app-vertical-center app-content-justify">
						<div class="app-flex app-vertical-center app-hrizontal-center">
							<div class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</div>
							<div class="time"><?php echo ($va["atime"]); ?>"</div>
						</div>
						<div style="text-align:right">
							<button class="alternate" type="button" data-type="audio"></button>	
						</div>
											
						<input type="hidden" name="content[]" value="<?php echo ($va["text"]); ?>">
						<input type="hidden" name="atime[]" value="<?php echo ($va["atime"]); ?>">
						<input type="hidden" name="atype[]" value="audio">
						</section><?php endif; ?>
						<?php if($va['type'] == 'text'): ?><section class="pub-text pub-box app-vertical-center app-content-justify">
							<div class="text"><?php echo ($va["text"]); ?></div>
							<div style="text-align:right">
								<button class="alternate" type="button" data-type="text"></button>
							</div>						
						<input type="hidden" name="content[]" class="text0999" value="<?php echo ($va["text"]); ?>">
						<input type="hidden" name="atime[]" value="0">
						<input type="hidden" name="atype[]" value="text">
						</section><?php endif; ?>
						<?php if($va['type'] == 'img'): ?><div class="picture-panel pub-box app-vertical-center">
						<div class="picture"><img src="<?php echo ($va["text"]); ?>" alt=""></div>
						<div style="text-align:right">
							<button class="alternate" type="button" data-type="picture"></button>
						</div>
						<input type="hidden" name="content[]" value="<?php echo ($va["text"]); ?>">
						<input type="hidden" name="atime[]" value="0">
						<input type="hidden" name="atype[]" value="img">
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						<input type="hidden" id="cctype" value="<?php echo ($imgtaudiocount); ?>">
					</div>
					<div class="pub-btns">
						<div class="text" @click="upload_content($event,2);"></div>
						<div class="voice" @click="upload_content($event,1);"></div>
						<div class="pic" @click="upload_content($event,3);"></div>
					</div>
				</div>
			</div>			
			<input type="hidden" name="userid" value="<?php echo ($id); ?>">
			<input type="hidden" name="ztid" value="<?php echo ($ztid); ?>">
			<input type="hidden" name="acid" id="acid" value="<?php echo ($taskinfo["id"]); ?>">
			<input type="hidden" name="status" id="status" value="0">			
		</form>
		</section>
		<!--我的微课列表-->
		<section v-show="cur_index == 2" class="mylesson" v-cloak>
			<ul class="listview">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item" data-id='<?php echo ($va["id"]); ?>'>
					<div class="list-top app-flex app-vertical-center app-content-justify" style="position:relative;padding:.7rem 1rem .4rem">
						<h5><?php echo (date('Y-m-d',$va["addtime"])); ?></h5>
						<!--发布后显示移入专题，未发布显示操作-->
						<?php if($va['status'] == 0): ?><h5 class="action">操作<i></i></h5>						
						<ul class="actionUl">
							<li @click="jump_to_edit($event,'<?php echo ($va["id"]); ?>');">编辑</li>
							<li @click="pub2($event,'<?php echo ($va["id"]); ?>',false);">发布</li>
							<li @click="delFn($event,'<?php echo ($va["id"]); ?>');">删除</li>
						</ul>
						<?php else: ?>
						<h5 class="moveTo" @click="moveFn($event,'<?php echo ($va["id"]); ?>',1)">移入专题</h5>
						<div class="ztList">
							<div class="content">
								<div class="tit app-flex">
									<div class="app-basis" @click="moveChose($event,1)">取消</div>
									<div style="color:#3cc8fe" @click="moveChose($event,2,1)">确定</div>
								</div>
								<div class="weui-cells weui-cells_checkbox">
									<a class="weui-cell weui-check__label" href="<?php echo U('Portal/Zhuantis/addzt',array('istype'=>1,'atype'=>1));?>">
										<div class="weui-cell__bd">
											<p style="font-size:17px;color:#3cc8fe">新建专题</p>
										</div>
										<div class="weui-cell__hd" href="javascript:;">
										
										</div>
									</a>
									<?php if(is_array($ztlist)): $i = 0; $__LIST__ = $ztlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><label class="weui-cell weui-check__label">
										<div class="weui-cell__bd">
											<p><?php echo ($v["title"]); ?></p>
										</div>
										<div class="weui-cell__hd">
											<input type="checkbox" v-model="moveList" value="<?php echo ($v["value"]); ?>" class="weui-check" @change="choseFn($event)">
											<i class="weui-icon-checked"></i>
										</div>
									</label><?php endforeach; endif; else: echo "" ;endif; ?>
									
								</div>
							</div>
						</div><?php endif; ?>
					</div>
					<a href="<?php echo U('Portal/Task/detail',array('id'=>$va['id']));?>">
						<div class="list-middle">
							<div class="list-title app-flex app-vertical-center app-content-justify">
								<h4 style="font-size:.8rem"><?php echo ($va["title"]); ?></h4>
								<h5><?php if($va['status'] == 0): ?>未发布<?php else: ?>已发布<?php endif; ?></h5>
							</div>
							<div class="list-type app-flex">
								<h4>微课类型 :</h4>
								<h5 class="ellipsis app-basis"><?php echo ($va["classtype"]); ?></h5>
							</div>
							<div class="list-type app-flex">
								<h4>课程简介 :</h4>
								<h5 class="Line2 app-basis"><?php echo ($va["brief"]); ?></h5>
							</div>
							<div class="list-type app-flex">
								<h4>购买价格 :</h4>
								<h5><?php echo ($va["price"]); ?>元</h5>
							</div>
							<div class="app-flex countBtn">
								<h4 class="cksl"><?php echo ($va["clicknum"]); if($va['clicknum'] > '999'): ?>+<?php endif; ?></h4>
								<h4 class="scsl"><?php echo ($va["colcount"]); if($va['colcount'] > '999'): ?>+<?php endif; ?></h4>
							</div>
						</div>
					</a>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</section>
		<div v-if="cur_index == 1" style="padding: 0 1rem; text-align: center; font-size: 0.55rem; color: #8e8e8e;">温馨提示：若文字编辑不便，您可将内容转化为图片上传</div>
		<div v-if="cur_index == 1" class="price-desc" style="padding: 0 1rem;">学生付费后，平台将收取<span><?php echo ($option["wxpersent"]); ?>%</span>的资金用于教师奖励基金和系统维持，衷心感谢您的支持！</div>
		<div v-if="cur_index == 2" class="data-text" v-text="data_text"></div>
		<div v-if="cur_index == 1" class="btm-btn pub-btm app-flex app-vertical-center app-hrizontal-center">
			<div class="save-to-draft">
				<a href="javascript:void(0);" @click="save_to_draft($event);">保存到草稿箱</a>
			</div>
			<div class="give-score">
				<a href="javascript:void(0);" @click="pub($event,'2018',false);">直接发布</a>
			</div>
		</div>
		<div v-if="show_layer" class="cover-layer pop-layer" v-cloak></div>
		<div v-if="show_layer2" class="cover-layer pop-layer" v-cloak></div>
			<div v-if="show_layer3" class="cover-layer pop-layer" v-cloak></div>
		<!--上传编辑内容弹出-->
		<div v-if="show_layer" class="content-dialog" v-cloak>
			<!--语音-->
			<div v-if="pop_type == 1">
				<div v-if="type != 2" class="close-btn" @click="show_layer = false;"></div>
				<div class="audio-content">
					<h3 :class="{'recording':recording}" class="audio-icon"></h3>
					<h4 v-text="record_text"></h4>
					<div class="dialog-btns app-flex">
						<button class="app-basis" type="button" style="font-size:.8rem;color:#3cc8fe" @click="start_record($event,type);" v-text="record_status_text"></button>
						
					</div>
				</div>
			</div>
			<!--文字描述-->
			<div v-if="pop_type == 2">
				<!--<div class="close-btn" @click="show_layer = false;"></div>-->
				<div class="text-content">
					<div class="textarea">
						<textarea placeholder="输入文字描述内容" v-model="text"></textarea>
					</div>
					<div class="dialog-btns app-flex">
						<button class="app-basis" type="button" @click="show_layer = false;">取消</button>
						<button class="app-basis" type="button" @click="upload_text($event);">确定</button>
					</div>
				</div>
			</div>
		</div>
		<div v-if="show_layer2" class="select-panel" v-cloak>
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
		<div class="meng1"></div>
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
	var m =0;
	//监听语音控件是否处于暂停状态
	audio.addEventListener("pause",function(){
		$("#form-content-wrap").find(".playing").removeClass("playing").text("点击收听")
	})

	var app = new Vue({
		el:'#app',
		data:{
			cur_index:sessionStorage.getItem("status3") ? sessionStorage.getItem("status3") : 1,
			type_index:1,
			lesson_name:'<?php echo ($taskinfo["title"]); ?>',
			select_lesson_type:'<?php echo ($taskinfo["classtype"]); ?>',
			lesson_desc:'<?php echo ($taskinfo["brief"]); ?>',
			lesson_price:'<?php echo ($taskinfo["price"]); ?>',
			data_text:'没有更多了~',
			show_layer:false,
			show_layer2:false,
			show_layer3:false,
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
			movedata:'<?php echo ($ztlist); ?>',     //该用户已有的专题列表
			moveList:[],   //要移入的专题列表
			ids:'',
			typedata1:0
		},
		mounted:function(){
			var self=this;
		},
		methods:{
			change_tab:function(evt,index){
				this.cur_index = index;
				sessionStorage.clear();
			},
			savebox:function(evt)
			{
				//console.log(app.typedata1);
				//if(app.typedata1 == 0)
				//{
					tttt=setTimeout(function(){						
						app.save_to_draft5(evt);
						console.log(5555);
					},200);
				//	app.typedata1 =typedata;
				//}
			},
			save_to_draft5:function(evt)
			{
				var tagvals=$('#tagforms').serialize();
				$.showLoading("自动保存中");
				$.ajax({
						url: "<?php echo U('Portal/Task/fabu5');?>",
						data: tagvals,
						type:'POST',
						success: function (data) {
							$.hideLoading();
							if(data.status == 1)
							{
								$("#acid").val(data.id);
							}
					}
				})
			},
			moveFn:function(evt,ids,atype){
				var self=this;
				self.ids=ids;
				//self.movedata=<?php echo ($ztlist); ?>;
				console.log(self.movedata);
				console.log(self.movedata.length);
				if(self.movedata==''){   //没有专题列表，提示新建
					$.confirm({
						title:'',
						text:'您还没有专题，请先新建专题~',
						onOK:function(){
							window.location.href="<?php echo U('Portal/Zhuantis/addzt',array('istype'=>1,'atype'=>1));?>";
						}
					});
				}
				else{					
					//ajax请求已选择过的选项					
					$.ajax({
							url:"<?php echo U('Portal/Zhuantis/getmoveztlist');?>",
							data:{id:ids,type:atype},
							type:'post',
							success:function(data)
							{
								if(data.status==0)
								{
									$('.meng1').show();
									$('.ztList').show();
									app.moveList=data.result;
								}
							}
						})					
				}
			},
			moveChose:function(evt,type,atype){
				var self=this;
				console.log(self.ids+'|'+atype);
				if(type==1){    //点击的是取消
					self.moveList=[];
					$('.ztList').hide();
					$('.meng1').hide();
				}
				else{   //点击的是确定
					if(self.moveList.length<1){    //没有选择数据
						$.toast("请至少选择一个专题","text");
					}
					else{

						//ajax
						$.ajax({
							url:"<?php echo U('Portal/Zhuantis/addpostzt');?>",
							data:{id:self.ids,type:atype,ztlist:self.moveList},
							type:'post',
							success:function(data)
							{
								if(data.status==0)
								{
									$.toast("加入成功",'text',function(){
										setTimeout(function(){
											$('.ztList').hide();
											$('.meng1').hide();
											app.moveList=[];
										},500)
									})
								}
							}
						})
						
					}
				}				
			},
			choseFn:function(evt){
				var self=this;
				console.log(self.moveList);
				console.log(self.moveList.length);
			},
			
			jump_to_edit:function(evt,proid){
				//保存成功跳转至我的微课
				setTimeout(function(){
					//设置session信息
					try{
						sessionStorage.setItem("status3",1);
						if(sessionStorage.getItem("status3")){
							location.href='./index.php?g=Portal&m=Task&a=index&id='+proid;
						}
					}catch(e){
						console.warn(e);
					}
				},1500);
			},
			pub:function(evt,proid,fal,pub){
				if(pub == '' || pub == undefined){
					if(this.lesson_name == ''){
						$.toast("请填写课程名称",'text');
						return;
					}
					if(this.select_lesson_type == ''){
						$.toast("请选择课程类型",'text');
						return;
					}
					if(this.lesson_price == ''){
						$.toast("请填写课程价格",'text');
						return;
					}
					if(this.lesson_desc == ''){
						$.toast("请填写课程简介",'text');
						return;
					}
				}
				if($("#cctype").val()==0)
				{
					$.toast("请填写课程内容",'text');
					return;
				}
				$("#status").val('1');
				var tagvals=$('#tagforms').serialize();
				$.confirm({
					title:'',
					text:'发布之后不能再修改~',
					onOK:function(){
						$.showLoading("正在提交");						
						$.ajax({
	                        url: "<?php echo U('Portal/Task/fabu');?>",
	                        data: tagvals,
	                        type:'POST',
	                        success: function (data) {
								$.hideLoading();
	                        	if(data.status == 1)
	                        	{
	                        		//发布成功
									$.toast("发布成功~",'text',function(){
										setTimeout(function(){
											//设置session信息
											try{
												sessionStorage.setItem("status3",2);
												if(sessionStorage.getItem("status3")){													
													location.href=data.url;													
												}
											}catch(e){
												console.warn(e);
											}
										},500);
									});
	                        	}else
	                        	{
	                        		$.toast("发布失败","forbidden");
	                        	}
	                        }
	                    })
					}
				});
			},
			pub2:function(evt,proid,fal){
				$.confirm({
					title:'',
					text:'发布之后不能再修改~',
					onOK:function(){
						$.ajax({
		                    url: "<?php echo U('Portal/Task/fabu2');?>",
		                    data: {id:proid},
		                    type:'POST',
		                    success: function (data) {
		                    	if(data.status == 1)
		                    	{		                    		
									//发布成功
									$.toast("发布成功~",'text',function(){
										setTimeout(function(){
											//设置session信息
											try{
												sessionStorage.setItem("status3",2);
												if(sessionStorage.getItem("status3")){													
													//location.reload();
													location.href=data.url;
												}
											}catch(e){
												console.warn(e);
											}
										},500);
									});
										
		                    	}
		                    }
		                })
		            }
				});
			},
			delFn:function(evt,proid){
				var self=this;
				$(evt.target).parents('.actionUl').hide();
				$('.meng1').hide();
				$.confirm({
					title:'',
					text:'确定要删除该微课吗？',
					onOK:function(){
						$.ajax({
							url:"<?php echo U('Portal/Task/deltask');?>",
							data:{id:proid},
							type:'post',
							success:function(data)
							{
								if(data.status==0)
								{
									$(evt.target).parents('.list-item').remove();
									$('.meng1').hide();
								}
							}
						})
					}
				});
			},
			save_to_draft:function(evt){
				//保存成功跳转至我的资源页
				if(this.lesson_name == ''){
					$.toast("请填写课程名称",'text');
					return;
				}
				if(this.select_lesson_type == ''){
					$.toast("请选择课程类型",'text');
					return;
				}
				if(this.lesson_price == ''){
					$.toast("请填写课程价格",'text');
					return;
				}
				if(this.lesson_desc == ''){
					$.toast("请填写课程简介",'text');
					return;
				}
				$("#status").val('0');
				var tagvals=$('#tagforms').serialize();
				$.showLoading("正在提交");
				$.ajax({
						url: "<?php echo U('Portal/Task/fabu');?>",
						data: tagvals,
						type:'POST',
						success: function (data) {
							$.hideLoading();
							if(data.status == 1)
							{
								//保存成功跳转至我的资源页
								setTimeout(function(){
									//设置session信息
									try{
										sessionStorage.setItem("status3",2);
										if(sessionStorage.getItem("status3")){
											location.href=data.url;
										}
									}catch(e){
										console.warn(e);
									}
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
										 url: "<?php echo U('Portal/Problem/getimgpost');?>",
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
													'<input type="hidden" name="content[]"  value="'+res.strimgurl+'">'+
													'<input type="hidden" name="atime[]" value="0">'+
													'<input type="hidden" name="atype[]" value="img">';	
												$(self.obj).parents('.picture-panel').html(img_hml2);
												m=m+1;
												$("#cctype").val(m);
												app.savebox(evt);
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
										 url: "<?php echo U('Portal/Problem/getimgpost');?>",
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
															'<input type="hidden" name="content[]"  value="'+res.strimgurl+'">'+
															'<input type="hidden" name="atime[]" value="0">'+
															'<input type="hidden" name="atype[]" value="img">'+
															'</div>';
													$(self.obj).parents('.pub-box').after(img_hml3);
													m=m+1;
													$("#cctype").val(m);
												app.savebox(evt);
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
										 url: "<?php echo U('Portal/Problem/getimgpost');?>",
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
												app.savebox(evt);
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
				console.log(self.pend_type);
				var text_hml = '<section class="pub-text pub-box app-vertical-center app-content-justify">'+
							'<div class="text">'+self.text+'</div>'+
							'<div class="" style="text-align:right">'+
								'<button class="alternate" type="button" data-type="text"></button>'+
							'</div>'+
							'<input type="hidden" name="content[]" class="text0999" value="'+self.text+'">'+
							'<input type="hidden" name="atime[]" value="0">'+
							'<input type="hidden" name="atype[]" value="text">'+
						'</section>';
				if(self.pend_type == 2){
					$(self.obj).parents('.pub-text').find(".text").text(self.text);
					$(self.obj).parents('.pub-text').find(".text0999").val(self.text);
					m=m+1;
				}
				else if(self.pend_type == 4){
					var text_hml2 = '<section class="pub-text pub-box app-vertical-center app-content-justify">'+
					'<div class="text">'+self.text+'</div>'+
					'<div class="" style="text-align:right">'+
						'<button class="alternate" type="button" data-type="text"></button>'+
					'</div>'+
					'<input type="hidden" name="content[]" class="text0999" value="'+self.text+'">'+
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
				app.savebox(evt);
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
						self.pop_type = 1;
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
									url: "<?php echo U('Portal/Problem/getpost');?>",
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
													'<div class="audio-item" data-audio-src="'+data.strfileurl+'">点击收听</div>'+
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
													'<div class="audio-item" data-audio-src="'+data.strfileurl+'">点击收听</div>'+
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
													var audio_hml2 ='<div class="app-flex app-vertical-center app-hrizontal-center">'+
													'<div class="audio-item" data-audio-src="'+data.strfileurl+'">点击收听</div>'+
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
					app.savebox(evt);
				}
				if(data_type == 'audio'){
					//删除语音
					$(app.obj).parents('.audio-panel').remove();
					app.savebox(evt);
				}
				if(data_type == 'picture'){
					//删除图片
					$(app.obj).parents('.picture-panel').remove();
					app.savebox(evt);
				}
				app.show_layer3 = false;
			}
			if(this.item_index == 3){
				//插入一条
				//app.obj = $(app.obj).data('type') == 'text' ? $(app.obj).parents('.pub-text') :  $(app.obj).parent();
				app.show_layer3 = false;
				app.show_layer2 = true;
			}
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
					//小于300ms，不录音
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
					if(chatime <60000){
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
										url: "<?php echo U('Portal/Problem/getpost');?>",
										type: 'post',
										data: {"serverId":res.serverId,"access_token":"<?php echo $signPackage['token'];?>","chatime":chatime},
										success: function (data) {
											if(data.status == 0)
											{
												alert("文件下载失败");
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
															
															//追加语音
															var audio_hml = '<section class="audio-panel pub-box app-vertical-center app-content-justify">'+
																'<div class="app-flex app-vertical-center app-hrizontal-center">'+
																'<div class="audio-item" data-audio-src="'+data.strfileurl+'">点击收听</div>'+
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
																'<div class="audio-item" data-audio-src="'+data.strfileurl+'">点击收听</div>'+
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
																var audio_hml2 ='<div class="app-flex app-vertical-center app-hrizontal-center">'+
																'<div class="audio-item" data-audio-src="'+data.strfileurl+'">点击收听</div>'+
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
															app.savebox(evt);
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
		$(this).parent('.audio-panel').siblings().find(".audio-item").text("点击收听");
		audio.src= src;
		//判断语音是否可以正常播放
		audio.addEventListener("error",function(){
			$.toast("语音错误",'cancel');
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
			$(this).text("暂停");
			audio.play();
		}
		audio.addEventListener("ended",function(){
			that.removeClass("playing");
			that.text("点击收听");
		});
		console.log(audio);
	});
	$('.action').click(function(){
		var actionUl=$(this).siblings('.actionUl');
		if(actionUl.is(':hidden')){
			actionUl.show();
			$('.meng1').show();
		}
	})
	$('.meng1').click(function(){
		$('.actionUl').hide();
		//$(".moveTo").select("close");
		$('.ztList').hide();
		$('.meng1').hide();
	})
	//图片预览
	$("#app").on('click','img',function(evt){
		var preview = $.photoBrowser({
		  initIndex:0,
		  items: [
			$(this).attr("src")
		  ]
		});

		preview.open();
	})
});

</script>
</html>