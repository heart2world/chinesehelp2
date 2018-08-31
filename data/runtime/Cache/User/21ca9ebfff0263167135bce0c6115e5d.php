<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>收入明细</title>
		<link rel="stylesheet" href="/public/style/base.min.css">
		<link rel="stylesheet" href="/public/style/app.css">
		<link rel="stylesheet" href="/public/libs/weui/weui.min.css">
		<link rel="stylesheet" href="/public/libs/weui/jquery-weui.css">
		<link rel="stylesheet" href="/public/chhelp2/css/style.css" />
		<script type="text/javascript" src="/public/chhelp2/lib/jq/jquery-1.10.2.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/lib/weui/jquery-weui.js" ></script>
		<script src="/public/libs/jq.min.js"></script>
		<script src="/public/libs/v.min.js"></script>
	</head>
	<style>
		.meng{ position: fixed; left: 0; right: 0; top: 0; bottom: 0; background: rgba(0,0,0,0); z-index: 0; display: none;}
		body{ color:#595959}
	</style>
	<body>
		
		<section class="stuListSec" id="app">
			<div class="selsetBox disbox weui-cell" style="border-bottom:1px solid #e1e1e1">
				<div class="disflex lxBox" style="min-width: 4.5rem;border-right:1px solid #f0eff4">
					<span class="lxName" style="min-width: 3.5rem; display: inline-block; text-align: center;">收入类型</span>
					<i></i>
					<ul class="lxUl shoppay" style="display: none;">
						<li>收入类型</li>
						<li>为TA充电</li>
						<li>购买微课</li>
						<li>购买资源</li>
						<li>消费分红</li>
						<li>代理分红</li>
					</ul>
					<input type="hidden" id="typename" value="">
				</div>
				<div class="disflex">
					<input class="weui-input dateInput" style="text-align: center;" type="text" id="choseDate1" placeholder="年/月/日" data-toggle='date' readonly v-model="datestart" >
					<i></i>
				</div>
				<div class="disflex" style="min-width: 15px;">~</div>
				<div class="disflex">
					<input class="weui-input dateInput" style="text-align: center;" type="text" id="choseDate2" placeholder="年/月/日" data-toggle='date' readonly v-model="enddate" >
					<i></i>
				</div>
			</div>
			<div class="weui-cells" id="loglist">
				<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p style="color:#595959"><?php echo ($va["title"]); ?></p>
	                    <p style="color: #999;"><?php echo (date('Y-m-d H:i',$va["addtime"])); ?></p>
	                </div>
	                <div class="weui-cell__ft">
	                	<p style="font-size: .9em;"><?php echo ($va["type"]); ?></p>
	                	<p style="color: #3CC8FE; font-size: .8rem;">￥<?php echo ($va["coin"]); ?></p>
	                </div>
	            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        	</div>
        	<div class="meng"></div>
		</section>
		
	</body>
</html>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
var app = new Vue({
		el:'#app',
		data:{
			datestart:'',
			enddate:'',
			starttimestape:'',
			endtimestape:''
		},
		mounted:function(){
			var that = this;
			Vue.nextTick(function(){
				$("#choseDate1").calendar({
					onChange:function(p,values,displayValues){
						that.datestart = values[0];
						that.starttimestape = displayValues[0];
						that.compara_each_date();
					}
				});
				$("#choseDate2").calendar({
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
					
					$.ajax({
						url:"<?php echo U('User/center/gettypeorders');?>",
						data:{typename:$("#typename").val(),starttime:time1,endtime:time2},
						type:'post',
						success:function(data)
						{
							if(data.status==0)
							{								
								$("#loglist").html(data.html);
							}
						}
					})
				}
			}
		}
	});
	$(function(){		
		$('.lxBox').click(function(){
			if($('.lxUl').is(':hidden')){
				$('.lxUl').show();
				$('.meng').show();
			}
			else{
				$('.lxUl').hide();
				$('.meng').hide();
			}
		})
		$('.lxUl li').click(function(){
			$('.lxName').html($(this).html());
			$("#typename").val($(this).html());
			
			$.ajax({
				url:"<?php echo U('User/center/gettypeorders');?>",
				data:{typename:$(this).html(),starttime:app.datestart,endtime:app.enddate},
				type:'post',
				success:function(data)
				{
					if(data.status==0)
					{
						$("#loglist").html(data.html);
					}
				}
			})
		})
		$('.meng').click(function(){
			$('.meng').hide();
			$('.lxUl').hide();
		})
	})
</script>