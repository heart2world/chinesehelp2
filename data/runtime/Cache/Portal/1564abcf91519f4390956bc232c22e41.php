<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title><?php echo ($info["title"]); ?></title>
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
	<link rel="stylesheet" href="public/style/base.min.css">
	<link rel="stylesheet" href="public/style/app.css">
	<link rel="stylesheet" href="public/libs/weui/weui.min.css">
	<link rel="stylesheet" href="public/libs/weui/jquery-weui.css">
	<script src="public/libs/jq.min.js"></script>
	<script src="public/libs/v.min.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<style>
		body .weui-dialog{ width:90%}
		body .weui-dialog__bd{ font-size:18px}
		.weui-dialog .weui-dialog__btn.default, .weui-toast .weui-dialog__btn.default{color:#999}
		body .weui-dialog__btn{ color:#999;font-size:18px}
		body #form-content-wrap img{ max-width:100%}
		body .toolbar .picker-button{ color:#3cc8fe;}
		body .weui-cells_checkbox .weui-check:checked+.weui-icon-checked:before{ color:#3cc8fe;}
		body .weui-picker-overlay, .weui-picker-container{ top:0;bottom:0; height:100%}
		.actionUl { position:absolute; top:100%;right:1rem;background:#fff;border:1px solid #e1e1e1;border-radius:3px;z-index:1001;display:none}
		.actionUl>li{ padding:.3rem 2rem;border-bottom:1px solid #e1e1e1;font-size:.8rem;text-align:center;color:#595959}
		.actionUl>li:last-child{border:0}
		.list-type h4{ min-width:65px}
		.weui-icon-success-no-circle:before{content:"\EA0B"}
	</style>
	
</head>
<body data-app="ChineseBang">
	<audio src="/public/media/9797.mp3" id="aud" controls></audio>
	<section id="app" style="padding-bottom: 2.65rem;">
		<!--某个专题内微课，资源列表-->
		<section class="mylesson" v-cloak style="padding-top:0">
			<ul class="listview">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li class="list-item" style="position:relative">
					<div class="list-top app-flex app-vertical-center app-content-justify" style="position:relative">
						<h4 style="font-size:.8rem;color:#595959"><?php echo (date('Y-m-d',$va["addtime"])); ?></h4>
						<h5 class="action">操作<i></i></h5>
						<ul class="actionUl" id="data_<?php echo ($va["id"]); ?>">
							<li @click="edit($event,'<?php echo ($va["id"]); ?>','<?php echo ($va["type"]); ?>')">编辑</li>
							<li @click="del($event,'<?php echo ($va["id"]); ?>','<?php echo ($va["type"]); ?>');">删除</li>
							<li onclick="move(this,1,'<?php echo ($va["id"]); ?>','<?php echo ($va["type"]); ?>')">向下移</li>
							<li onclick="move(this,2,'<?php echo ($va["id"]); ?>','<?php echo ($va["type"]); ?>')">向上移</li>
						</ul>
					</div>
					<?php if($va['type'] == '微课'): ?><a href="<?php echo U('Portal/Task/detail',array('id'=>$va['id']));?>"><?php endif; ?>
					<?php if($va['type'] == '资源'): ?><a href="<?php echo U('Portal/Resource/detail',array('id'=>$va['id']));?>"><?php endif; ?>
						<div class="list-middle">
							<div class="list-title app-flex app-vertical-center app-content-justify">
								<h4 style="font-size:.8rem"><?php echo ($va["title"]); ?></h4>
								<h5><?php if($va['status'] == 0): ?>未发布<?php else: ?>已发布<?php endif; ?></h5>
							</div>
							<div class="list-type app-flex">
								<h4><?php echo ($va["type"]); ?>类型 :</h4>
								<h5><?php echo ($va["classtype"]); ?></h5>
							</div>
							<div class="list-type app-flex">
								<h4>课程简介 :</h4>
								<h5 class="Line2"><?php echo ($va["brief"]); ?></h5>
							</div>
							<div class="list-type app-flex">
								<h4>综合评分 :</h4>
								<h5><?php if($va['star'] != '0.0'): echo ($va["star"]); else: ?>暂无<?php endif; ?></h5>
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
		<div class="btm-btn pub-btm app-flex app-vertical-center app-hrizontal-center">
			<div class="save-to-draft">
				<a href="<?php echo U('Portal/Task/index',array('ztid'=>$info['id']));?>" style="min-width:6rem">添加微课</a>
			</div>
			<div class="give-score">
				<a href="<?php echo U('Portal/Resource/index',array('ztid'=>$info['id']));?>" style="min-width:6rem">添加资源</a>
			</div>
		</div>
		<div class="meng1"></div>
		
		<!--没有内容时-->
		<?php if(count($list) == 0): ?><div style="padding-top:1rem" class="data-text" >暂无任何内容呢，赶快去添加吧~</div><?php endif; ?>
	</section>
</body>
<script src="public/libs/fixed.js"></script>
<script src="public/libs/weui/jquery-weui.js"></script>
<script>
$(function () {
	var app = new Vue({
		el:'#app',
		data:{
			cur_index:sessionStorage.getItem("status3") ? sessionStorage.getItem("status3") : 1,
			type_index:1,
			data_text:'没有更多了~',
			movedata:[],     //该用户已有的专题列表
			moveList:''   //移入的专题列表
		},
		mounted:function(){
			var self=this;
	
		},
		methods:{
			change_tab:function(evt,index){
				this.cur_index = index;
				sessionStorage.clear();
			},
			edit:function(evt,ids,typename)
			{
				if(typename =='微课')
				{
					window.location.href="<?php echo U('Portal/Task/index');?>"+"&id="+ids;
				}else
				{
					window.location.href="<?php echo U('Portal/Resource/index');?>"+"&id="+ids;
				}
				
			},
			del:function(evt,ids,typename)
			{				
				var ztid ='<?php echo ($info["id"]); ?>';
				if(typename=='微课')
				{
					var type=1;
				}else{
					var type=2;
				}
				$('.meng1').click();
				$.confirm({
					title:'',
					text:'<p style="color:#595959; font-size:1rem">温馨提示</p><br/><p style="font-size:.9rem; color:#595959">移除专题后<br/>该内容仍可在微课/资源列表中查看~</p>',
					onOK:function(){
						$.ajax({
							url:"<?php echo U('Portal/Zhuantis/delinfo');?>",
							data:{taskid:ids,ztid:ztid,type:type},
							type:'post',
							success:function(data)
							{
								if(data.status==0)
								{	
									$.toast("删除成功","text");
									$('.actionUl').hide();
									$('.meng1').hide();	
									$("#data_"+data.ids).parents('li').remove();
								}else
								{
									$.toast(data.msg,'forbidden');
								}
							}
						})
					}
				});
			},
		}
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
		$('.meng1').hide();
	})
});
	function move(obj,number,ids,typename)
		{	
			var len=$('.list-item').length;
			var index=$(obj).parents('.list-item').index();
			if(number==1&&index==len-1){   //向下移
				$.toast("当前元素已经是最后一项");
				return false;
			}
			if(number==2&&index==0){   //向上移
				$.toast("当前元素已经是第一项");
				return false;
			}
			//return false;
			var ztid ='<?php echo ($info["id"]); ?>';	
			if(typename=='微课')
			{
				var type=1;
			}else{
				var type=2;
			}				
			$.ajax({
				url:"<?php echo U('Portal/Zhuantis/domove');?>",
				data:{taskid:ids,ztid:ztid,number:number,type:type},
				type:'post',
				success:function(data)
				{
					if(data.status==0)
					{
						$('.meng1').click();
						//window.location.reload();
						if(number==1){   //向下移
							var thisBox=$(obj).parents('.list-item');
							thisBox.next().after(thisBox);
						}
						else{    //向上移
							var thisBox=$(obj).parents('.list-item');
							thisBox.prev().before(thisBox);
						}
						$.toast("操作成功","text");
					}else
					{
						$.toast(data.msg,'forbidden');
					}
				}
			})
			
		}
</script>
</html>