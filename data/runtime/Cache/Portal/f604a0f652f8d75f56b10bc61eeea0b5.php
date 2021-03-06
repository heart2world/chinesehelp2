<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>编辑专题</title>
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/jquery-weui.css" />
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/weui.min.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/public.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/style.css" />
		<link rel="stylesheet" href="/public/style/base.min.css">
		<link rel="stylesheet" href="/public/style/app.css">
		<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
		<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
		<script type="text/javascript" src="/public/chhelp2/lib/jq/jquery-1.10.2.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/lib/weui/jquery-weui.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/js/common.js" ></script>
		<script src="/public/libs/jq.min.js"></script>
		<script src="/public/libs/v.min.js"></script>
	</head>
	<style>
		.weui-btn-area{ margin: 15px;}
		.weui-btn_primary{ background: #3CC8FE;}
		.weui-btn_primary:not(.weui-btn_disabled):active{ background: #3CC8FE;}
		.weui-toast_content{color:white;}
	</style>
	<body>		
		<section class="ztSec" id="app">
			<div class="weui-cells">
	            <div class="weui-cell">
	                <div class="weui-cell__hd"><label class="weui-label">专题名称</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="text" placeholder="请输入专题名称" v-model="title">
	                </div>
	            </div>
	            <div class="weui-cell">
	                <div class="weui-cell__hd"><label class="weui-label">专题简介</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="text" placeholder="请输入专题简介" v-model="desc">
	                </div>
	            </div>
        	</div>
        	<div class="weui-btn-area">
				<input type="hidden" id="ztid" value="<?php echo ($info["id"]); ?>">
	            <a class="weui-btn weui-btn_primary" href="javascript:" @click="addzhuanti($event)">确定</a>
	        </div>
		</section>		
	</body>
	<script src="/public/libs/fixed.js"></script>
	<script src="/public/libs/weui/jquery-weui.js"></script>
	<script>
		var app = new Vue({
			el:'#app',
			data:{
				title:'<?php echo ($info["title"]); ?>',
				desc:'<?php echo ($info["desc"]); ?>'
			},
			methods:{
				addzhuanti:function(evt){
					if(this.title == '')
					{
						$.toast("输入专题名称","forbidden");
						return;
					}
					if(this.desc =='')
					{
						$.toast("输入专题简介","forbidden");
						return;
					}
					$.showLoading("修改中...");					
					$.ajax({
						url:"<?php echo U('Portal/Zhuantis/edit_post');?>",
						data:{title:this.title,desc:this.desc,id:$("#ztid").val()},
						type:'POST',
						success:function(data){
							$.hideLoading();
							if(data.status==1)
							{								
								setTimeout(function(){
									location.href=data.url;
								},1000);
							}else{
								$.toast(data.msg,"forbidden");
							}
						}
					})					
				}
			}
		});
		
	</script>
</html>