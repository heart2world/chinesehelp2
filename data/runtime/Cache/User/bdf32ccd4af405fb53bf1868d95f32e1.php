<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>提现</title>
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
		body .weui-cells:after{border-bottom:none}
	</style>
	<body>		
		<section class="tixianSec" id="app">
			<div class="weui-cells weui-cells_form">
	            <div class="weui-cell">
	                <div class="weui-cell__hd"><label class="weui-label">可提现金额</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="number" pattern="[0-9]*" value="<?php echo ($totalin); ?>" readonly>
	                </div>
	            </div>
	            <div class="weui-cell">
	                <div class="weui-cell__hd"><label class="weui-label">提现金额</label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" type="number" pattern="[0-9]*" v-model="txprice">
	                </div>
	            </div>
	        </div>
	        <div class="weui-btn-area">
	            <a class="weui-btn weui-btn_primary" href="javascript:" @click="pop_alert($event)">确定</a>
	        </div>
		</section>		
	</body>
</html>
<script>
	bgImg('ewmImg',1);
</script>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	var app = new Vue({
		el:'#app',
		data:{
			txprice:'',
			allprice:'<?php echo ($totalin); ?>',
			show_layer:false
		},
		methods:{
			pop_alert:function(evt){
				if(this.txprice == '' || this.txprice == '0')
				{
					$.toast("不满足提现条件","forbidden");
					return;
				}
				if(this.txprice > this.allprice)
				{
					$.toast("不满足提现条件","forbidden");
					return;
				}
				if(this.txprice < '1')
				{
					$.toast("最低1元提现","forbidden");
					return;
				}				
				$.ajax({
					url:"<?php echo U('User/Center/dotixianlog');?>",
					data:{price:this.txprice},
					type:'POST',
					success:function(data){
						if(data.status==1)
						{							
							//确认到账
							$.toast("提现成功！",'text',function(){
								setTimeout(function(){								
									location.href=data.url;
								},500);
							});
						}else{
							$.toast(data.msg,"forbidden");
						}
					}
				})					
			}
		}
	});
	
</script>