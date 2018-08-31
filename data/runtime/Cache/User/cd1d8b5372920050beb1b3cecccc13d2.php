<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>我的收入</title>
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
	<link rel="stylesheet" href="/public/style/app.css">
	<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
	<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
	<script src="/public/libs/jq.min.js"></script>
	<script src="/public/libs/v.min.js"></script>
		<script type="text/javascript" src="/public/chhelp2/lib/weui/jquery-weui.js" ></script>
</head>
<style>
html{ font-size:17px}
body .weui-cells:after{border-bottom:none}
.weui-cell__bd>p{ color:#595959}
</style>
<body data-app="ChineseBang">
	<!--我的收入信息-->
	<section id="app">
		<section class="stuSec">
			<div class="tit">
				<div class="app-flex">
					<p class="app-basis" style="font-size:17px">我的余额</p>
					<p><a href="<?php echo U('User/center/yestixian');?>">明细</a></p>
				</div>
				<p class="count" style="font-size:25.5px"><?php echo ($totalin); ?></p>
			</div>
			<div class="weui-cells">
	            <a class="weui-cell weui-cell_access" href="<?php echo U('User/center/tixian');?>">
	                <div class="weui-cell__hd"><img src="/public/assets/tixian.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
	                <div class="weui-cell__bd">
	                    <p>立即提现</p>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </a>
	            <a class="weui-cell weui-cell_access" href="<?php echo U('User/center/tixianlog');?>">
	                <div class="weui-cell__hd"><img src="/public/assets/shouru.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
	                <div class="weui-cell__bd">
	                    <p>提现记录</p>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </a>
	        </div>
		</section>
		<!--头部信息-->
		<!--<header class="income-hd">
			<h4>收入总额：<span v-text="allmoney"></span>元</h4>
			<div class="income-info app-flex app-vertical-center app-content-justify">
				<div class="info-navitem app-basis">已提现：<span v-text="getmoney_all"></span>元</div>
				<div class="info-navitem app-basis">未提现：<span v-text="unmoney_all"></span>元</div>
			</div>
			<div class="more-note">
				<a href="<?php echo U('User/center/tixianlog');?>">查看提现记录</a>
			</div>			
			<?php if($unprice > 0): ?><div class="widthdrawals-btn" style="background:#ccc;">提现申请</div>	<!--@click="pop_alert($event);"-->
			<!--<?php else: ?>
			<div class="widthdrawals-btn" style="background:#ccc;">提现申请</div><?php endif; ?>
		</header>
		<aside class="filter-time app-flex app-vertical-center app-content-justify">
			<h4>收入记录</h4>
			<h5 class="app-flex app-vertical-center">
				<div class="input-date app-basis">
					<input type="text" id="date1" placeholder="日期" data-toggle='date' readonly v-model="datestart">
				</div>
				<div>至</div>
				<div class="input-date app-basis">
					<input type="text" id="date2" placeholder="日期" data-toggle='date' readonly v-model="enddate">
				</div>
			</h5>
			<input type="hidden" id="userid" value="<?php echo ($id); ?>">
		</aside>
		<!--提现记录-->
		<!--<section class="list-wrap">
			<ul class="getmoney-list" id="tixianlist">
				<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item app-flex app-vertical-center">
					<div class="list-info app-basis">
						<h4><?php echo ($va["type"]); ?>: <span>￥<?php echo ($va["tccoin"]); ?></span></h4>
						<p><?php echo ($va["title"]); ?></p>
						<p><?php echo (date('Y-m-d H:i',$va["addtime"])); ?></p>
					</div>
					<?php if($va['logid'] != 0): ?><div class="list-status">已提现</div>
					<?php else: ?>
					<div class="list-status in">未提现</div><?php endif; ?>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</section>
		<div v-if="show_layer" class="cover-layer" v-cloak></div>
		<div v-if="show_layer" class="apply-result" v-cloak>
			<span>提现成功！<br/>收入已提现到微信钱包~</span>
		</div>-->
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	var app = new Vue({
		el:'#app',
		data:{
			allmoney:'<?php echo ($totalin); ?>',
			getmoney_all:'<?php echo ($tixianprice); ?>',
			unmoney_all:'<?php echo ($unprice); ?>',
			datestart:'',
			enddate:'',
			starttimestape:'',
			endtimestape:'',
			show_layer:false
		},
		mounted:function(){
			var that = this;
			Vue.nextTick(function(){
				$("#date1").calendar({
					onChange:function(p,values,displayValues){
						that.datestart = values[0];
						that.starttimestape = displayValues[0];
						that.compara_each_date();
					}
				});
				$("#date2").calendar({
					onChange:function(p,values,displayValues){
						that.enddate = values[0];
						that.endttimestape = displayValues[0];
						that.compara_each_date();
					}
				});
			});
		},
		methods:{
			compara_each_date:function(){
				var time1 = Date.parse(new Date(app.datestart));
				var time2 = Date.parse(new Date(app.enddate));
				if(time1 != '' && time2 != ''){
					console.log(time1,time2);
					if(time1 >= time2){
						$.toast("结束日期应大于起始日期",'text');
						app.enddate = '';
						return;
					}
					if(time2 <= time1){
						$.toast("起始日期应小于结束日期",'text');
						app.datestart = '';
						return;
					}
					var userid =$("#userid").val();
					//筛选后显示金额
					$.ajax({
                        url: "<?php echo U('User/center/gettixianlog');?>",
                        data: {id:userid,starttime:app.datestart,endtime:app.enddate},
                        type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		document.getElementById('tixianlist').innerHTML=data.html;
                        	}
                        	
                        }
                    })
				}
			},
			pop_alert:function(evt){
				var that = this;
				var tprice ='<?php echo ($unprice); ?>';
				if(tprice > '0')
				{
					$.confirm({
						title:'提现金额：<?php echo ($unprice); ?>元',
						text:'确认提现到微信钱包！',
						onOK:function(){						
							$.ajax({
								url:"<?php echo U('User/Center/dotixianlog');?>",
								data:{price:tprice},
								type:'POST',
								success:function(data){
									if(data.status==1)
									{
										that.show_layer = true;
										//确认到账
										setTimeout(function(){
											that.show_layer = false;
											location.href=data.url;
										},3000);
									}else{
										$.toast(data.msg,"forbidden");
									}
								}
							})
						}
					});
				}else{
					$.toast("无法提现","forbidden");
					return;
				}
			}
		}
	});
	
</script>
</html>