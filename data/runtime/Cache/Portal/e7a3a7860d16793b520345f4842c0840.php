<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>我的专题</title>
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/jquery-weui.css" />
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/weui.min.css" />
		<link rel="stylesheet" href="/public/style/app.css">
		<link rel="stylesheet" href="/public/chhelp2/css/public.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/style.css" />
		<script type="text/javascript" src="/public/chhelp2/lib/jq/jquery-1.10.2.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/lib/weui/jquery-weui.js" ></script>
	</head>
	<style>
		.weui-cells{ overflow:visible}
		.weui-btn-area{ margin: 15px;}
		.weui-btn_primary{ background: #3CC8FE;}
		.weui-btn_primary:not(.weui-btn_disabled):active{ background: #3CC8FE;}
		.actionUl { position:absolute; top:100%;right:0;background:#fff;border-radius:3px;z-index:1001;display:none}
		.actionUl>li{padding:.3rem 2rem;border-bottom:1px solid #e1e1e1;font-size:.8rem}
		.actionUl>li:last-child{border:0}
		body .weui-cells:after{ display:none}
		body .weui-cell{ border-bottom:1px solid #f0eff4}
		body .weui-btn_primary{ font-size:1rem !important}
	</style>
	<body>		
		<section class="ztListSec">
			<?php if(count($ztlist) > 0): ?><div class="weui-cells">
				<?php if(is_array($ztlist)): $i = 0; $__LIST__ = $ztlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Portal/Zhuantis/ztinfo',array('id'=>$va['id']));?>" style="display:block">
					<div class="weui-cell">
						<div class="weui-cell__bd" style="width: 100%;">
							<div class="disbox" style="position:relative">
								<p class="disflex" style="line-height:1.5rem;font-size:1rem"><?php echo ($va["title"]); ?></p>
								<p class="action">操作<i></i></p>
								<ul class="actionUl">
									<li onclick="edit(this,'<?php echo ($va["id"]); ?>')">编辑</li>
									<li onclick="deletezt(this,'<?php echo ($va["id"]); ?>')">删除</li>
								</ul>
							</div>
							<p class="ellipsis desc" style="font-size:.9rem"><?php echo ($va["desc"]); ?></p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
        	</div>
			<?php else: ?>
			<!--没有专题是显示-->
			<div style="padding-top:1rem" class="data-text" >暂无专题~</div><?php endif; ?>
        	<div class="weui-btn-area">
	            <a class="weui-btn weui-btn_primary" href="<?php echo U('Portal/Zhuantis/addzt');?>">添加专题</a>
	        </div>
		</section>
		<div class="meng1"></div>
	</body>
</html>

<script>
function edit(obj,id){
	event.preventDefault();
	location.href="<?php echo U('Portal/zhuantis/edit');?>"+"&ztid="+id;
}
function deletezt(obj,id)
{	
	event.preventDefault();
	$('.meng1').click();
	$.confirm({
		title:'',
		text:'确定要删除该专题吗？',
		onOK:function(){
			$.ajax({
				url:"<?php echo U('Portal/Zhuantis/delzt');?>",
				data:{id,id},
				type:'post',
				success:function(data)
				{
					if(data.status==0)
					{
						// 删除成功
						$('.meng1').hide();
						$('.actionUl').hide();
						$(obj).parents('a').remove();
					}
				}
			})
		}
	});
}
$(function(){
	$('.action').click(function(){
		event.preventDefault();
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
	
})
	
	
</script>