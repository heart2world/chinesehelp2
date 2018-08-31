<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>问题详情</title>
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
	<style>
		.btm-btn{border-top:1px solid #3cc8fe}
		.btm-btn .btn-box div{ float:left;width:45%;}
		.weui-cell__bd>p{ font-size:.8rem}
		.weui-cell__ft{ font-size:.8rem}
		.btm-btn .btn-box div{ width:50%;height:100%}
		.quiz-btn-again a,.give-score a{border:none;height:100%;width:100%; line-height:100%;display:inline-block;font-size:.9rem;padding:0}
		.give-score{ background:#3cc8fe}
		.lesson-detail-main{ padding:10px 15px 0}
	</style>
</head>
<body data-app="ChineseBang">
	<section id="app" style="padding-bottom: 2.5rem;">
		<audio src="/public/media/9797.mp3" id="aud" controls></audio>
		<!--普通问题详情-->
		<!--教师头部信息-->
		<div v-if="show_layer2" class="cover-layer" @click="show_layer2='false'" v-cloak></div>
		<div v-if="show_layer2" class="charge-box" v-cloak style="position: fixed;">
			<h4>为TA充电</h4>
			<p @click="charge($event,'1');">小小心意（1元）</p>
			<p @click="charge($event,'5');">衷心感谢（5元）</p>
			<p @click="charge($event,'-1');">一生粉丝（自选金额）</p>
			<p @click="charge($event,'0');">下次再说</p>
		</div>
		<header class="teacher-hd-info del-border">
			<div class="teacher-hd-title color595959" style="font-size:.8rem;">指定答题老师</div>
			<div class="teacher-top app-flex app-vertical-center">
				<div class="teacher-image" style="align-self:flex-start">
					<img src="<?php echo ($uinfo["headimg"]); ?>" alt="img">
				</div>
				<div class="info-content tiwen app-basis">
					<h4 style="font-size:.8rem; color:#595959"><?php echo ($uinfo["truename"]); ?></h4>
					<p style="font-size:.8rem;"><?php echo ($uinfo["honors"]); ?></p>
					<p style="font-size:.8rem;">综合评分 : <span style="color:#999"><?php echo ($uinfo["star"]); ?></span></p>
					<div class="info-btm app-flex">
						<h4 class="dati" style="font-size:14px;"><?php echo ($uinfo["number"]); ?></h4>
						<h5 class="sc" style="font-size:14px;"><i id="collectnum"><?php echo ($uinfo["colcount"]); ?></i></h5>
					</div>
				</div>
				<!-- <div :class="{'favared':favared}" class="favar-btn" @click="add_favar_or_cancel($event);"></div> -->
				<?php if($iscollect == 1): ?><div class="favar-btn favared" @click="add_favar_or_cancel($event);"></div>
				<?php else: ?>
				<div class="favar-btn" @click="add_favar_or_cancel($event);"></div><?php endif; ?>
			</div>
		</header>
		<!--提问板块-->
		<section class="quiz-content">
			<article class="quiz-info">
				<div class="weui-cells">
					<div class="weui-cell" style="border-bottom:1px solid #f0eff4">
						<div class="weui-cell__bd">
							<p>提问</p>
						</div>
						<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$qinfo["addtime"])); ?></div>
					</div>
					<!--<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>问题</p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>-->
					<div style="padding: 10px 15px 0;font-size:.8rem; color:#3cc8fe;"><?php echo ($qinfo["title"]); ?></div>
					<!--<h4 class="title" style="width: auto; text-align: center; font-size: 0.95rem; color: rgb(89, 89, 89); font-weight: 400; margin: 0px auto 0.5rem;">
					<span style="color: #39c8ff;">学生提问</span>：<span style="word-wrap:break-word;word-break:break-all;"><?php echo ($qinfo["title"]); ?></span></h4>
					<div class="quiz-time" style="margin-bottom: 0.5rem;">
						<h4 style="font-size:14px;">提问时间：<span><?php echo (date('Y-m-d H:i',$qinfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">
						<!--问题描述-->
						<?php if(is_array($imgtaudio)): $i = 0; $__LIST__ = $imgtaudio;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;margin-bottom:10px"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>						
						<!--图片-->	
						<?php if($va['type'] == 'img'): ?><section class="reply-content resource-content" style="padding-bottom: 10px;">						
								<div class="img-wrap">
									<img src="<?php echo ($va["text"]); ?>" alt="img" style="max-width: 90%;">
								</div>	
							</section><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						
					</section>
				</div>
			</article>
		</section>
		<!--回答板块-->
		<?php if($aninfo['id'] != ''): ?><section class="quiz-content">
			<article class="quiz-info">
				<div class="weui-cells">
					<div class="weui-cell" style="border-bottom:1px solid #f0eff4">
						<div class="weui-cell__bd">
							<p>回答</p>
						</div>
						<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$aninfo["addtime"])); ?></div>
					</div>
					<!--<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>老师回答</p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>-->
					<!--<h4 class="title" style="width: auto; text-align: center; font-size: 0.95rem; color: rgb(89, 89, 89); font-weight: 400; margin: 0px auto 0.5rem;"><span style="color: #39c8ff;">老师回答：</span></h4>
					<div class="quiz-time" style="margin-bottom: 0.5rem;">
						<h4 style="font-size:14px;">回答时间：<span><?php echo (date('Y-m-d H:i',$aninfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">
						
						<!--语音板块-->
						<?php if(is_array($imgtaudio1)): $i = 0; $__LIST__ = $imgtaudio1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->						
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>	
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>								
						<!--图片-->	
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
						<img src="<?php echo ($va["text"]); ?>" alt="img" style="margin: 0 auto; margin-bottom: 10px;max-height:90%;">
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						
					</section>
				</div>
			</article>
		</section><?php endif; ?>
		<!--追问问题板块-->
		<?php if($agqinfo != ''): ?><section class="quiz-content">
			<article class="quiz-info">
				<div class="weui-cells">
					<div class="weui-cell" style="border-bottom:1px solid #f0eff4">
						<div class="weui-cell__bd">
							<p>追问</p>
						</div>
						<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$agqinfo["addtime"])); ?></div>
					</div>
					<!--<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>老师回答</p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>-->
					<!--<h4 class="title" style="width: auto; word-break: break-all; text-align: center; font-size: 0.95rem; color: rgb(89, 89, 89); font-weight: 400; margin: 0px auto 0.5rem;"><span style="color: #39c8ff;">追问问题：</span><?php echo ($agqinfo["title"]); ?></h4>
					<div class="quiz-time" style="margin-bottom: 0.5rem;">
						<h4 style="font-size:14px;">追问时间：<span><?php echo (date('Y-m-d H:i',$agqinfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">
						<!--问题描述-->
						<h4 class="quiz-desc" style="font-size:.8rem;padding:0 0 10px;color:#3cc8fe;margin:0"><?php echo ($agqinfo["title"]); ?></h4>
						<!--语音板块-->
						<?php if(is_array($imgtaudio2)): $i = 0; $__LIST__ = $imgtaudio2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;margin-bottom:10px"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>						
						<!--图片-->	
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
						<img src="<?php echo ($va["text"]); ?>" alt="img" style="margin: 0 auto; margin-bottom: 10px;max-width:90%;">
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section>
				</div>
			</article>
		</section><?php endif; ?>
		<!--追问回答板块-->
		<?php if($anaginfo != ''): ?><section class="quiz-content">
			<article class="quiz-info">
				<div class="weui-cells">
					<div class="weui-cell" style="border-bottom:1px solid #f0eff4">
						<div class="weui-cell__bd">
							<p>回答</p>
						</div>
						<div class="weui-cell__ft"><?php echo (date('Y-m-d H:i',$anaginfo["addtime"])); ?></div>
					</div>
					<!--<div class="weui-cell">
						<div class="weui-cell__bd">
							<p>回答</p>
						</div>
						<div class="weui-cell__ft"></div>
					</div>-->
					<!--<h4 class="title" style="width: auto; word-break: break-all; text-align: center; font-size: 0.95rem; color: rgb(89, 89, 89); font-weight: 400; margin: 0px auto 0.5rem;"><span style="color: #39c8ff;">追问回答：</span></h4>
					<div class="quiz-time" style="margin-bottom: 0.5rem;">
						<h4 style="font-size:14px;">回答时间：<span><?php echo (date('Y-m-d H:i',$anaginfo["addtime"])); ?></span></h4>
					</div>-->
					<section class="lesson-detail-main app-basis">
						
						<!--语音板块-->
						<?php if(is_array($imgtaudio3)): $i = 0; $__LIST__ = $imgtaudio3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i; if($va['type'] == 'text'): ?><h4 class="quiz-desc" style="font-size:.8rem;"><?php echo ($va["text"]); ?></h4><?php endif; ?>
						<!--语音板块-->
						<?php if($va['type'] == 'audio'): ?><section class="audio-wrap">							
							<div class="audio app-flex app-vertical-center app-hrizontal-center" data-resource-src="<?php echo ($va["text"]); ?>">
								<span class="audio-item" data-audio-src="<?php echo ($va["text"]); ?>">点击收听</span>
								<i><?php echo ($va["atime"]); ?>"</i>
							</div>					
						</section><?php endif; ?>						
						<!--图片-->	
						<?php if($va['type'] == 'img'): ?><div class="img-wrap">
							<img src="<?php echo ($va["text"]); ?>" alt="img" style="margin: 0 auto; margin-bottom:10px;max-width:90%">
						</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</section>
				</div>
				
				</div>
			</article>
		</section><?php endif; ?>		
		<?php if($qinfo['isend'] == 1): ?><!-- 打分完成显示-->
		<div class="satisfy-degree">
			<h4 style="font-size:.8rem;">回答满意度：<span><?php echo ($qinfo["star"]); ?></span></h4>
		</div><?php endif; ?>
		
		<!--第一次回答内容和追问问题 没有结束-->
		<?php if( $aninfo['id'] != '' && $agqinfo == '' && $qinfo['isend'] == 0 && $isuser == 1): if($atime>0 && $atime<7200){?>
			<p class="tips" style="padding: 0.75rem 0;">温馨提示：在教师首次回答后2小时内可发起一次追问</p>
			<?php }?>
		<div class="btm-btn">
			<div class="app-flex app-vertical-center app-content-justify" style="height: 2.5rem;">
				<?php if($atime > 0 && $atime < 7200): ?><div class="quiz-btn-again app-basis">
					<a style="margin:0" href="<?php echo U('Home/Problem/pub_question',array('id'=>$qinfo['teacherid'],'parentid'=>$qinfo['id']));?>">我要追问(剩余时间:<?php echo $lesstime;?>分)</a>
				</div><?php endif; ?>
				<?php if($qinfo['isend'] == 0): ?><div class="give-score">
					<a href="<?php echo U('Home/Problem/give_score',array('id'=>$qinfo['id']));?>" style="margin:0;min-width:6.5rem">结束打分</a>
				</div><?php endif; ?>
			</div>
		</div><?php endif; ?>
		<?php if($isquestion != 1 && $qinfo['isend'] == 1): ?><div class="tip-me" style="padding-bottom: 0;">
			<a href="<?php echo U('Home/Problem/tipoff',array('id'=>$qinfo['id'],'atype'=>0));?>">举报此内容</a>
		</div><?php endif; ?>
		<!--有追问问题-->
		<?php if($agqinfo != '' || $isuser != 1): ?><div class="btm-btn">
			<div class="app-flex app-vertical-center app-content-around btn-box" style="height: 2.5rem;">
				<div class="quiz-btn-again">
					<?php if($iscollect2 == 1): ?><a href="javascript:void(0);" style="margin: 0;" id="collectproblem1" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">取消收藏</a>
					<?php else: ?>
					<a href="javascript:void(0);" style="margin: 0;" id="collectproblem1" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">收藏问题</a><?php endif; ?>
				</div>
				<?php if($qinfo['isend'] == 0 && $isuser == 1): ?><div class="give-score" style="margin: 0;">
					<a href="<?php echo U('Home/Problem/give_score',array('id'=>$qinfo['id']));?>" style="margin:0">结束打分</a>
				</div><?php endif; ?>
				<?php if($qinfo['isend'] == 1): ?><div class="give-score" style="margin: 0;">
					<a href="javascript:void(0);" @click="pop_give_score($event);">为TA充电</a>
				</div><?php endif; ?>
			</div>
		</div><?php endif; ?>
		<?php if($qinfo['isend'] == 1 || $aninfo == ''): ?><div class="btm-btn">
				<?php if($isshowcss == 1): ?><div class="app-flex app-vertical-center app-content-justify" style="height: 2.5rem;">
				<div class="quiz-btn-again app-basis">
				<a href="javascript:void(0);" style="border:0;" id="collectproblem" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">取消收藏</a>
				</div><?php endif; ?>
				<?php if($isshowcss == 2): ?><div class="app-flex app-vertical-center app-content-justify" style="height: 2.5rem;">
				<div class="quiz-btn-again app-basis">
				<a href="javascript:void(0);" style="border:0;" id="collectproblem" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">收藏问题</a>
				</div><?php endif; ?>
				<?php if($isshowcss == 3): ?><div class="btn-box app-flex app-vertical-center app-content-around" style="height: 2.5rem;">
				<div class="quiz-btn-again">
				<a href="javascript:void(0);" style="margin: 0;" id="collectproblem" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">收藏问题</a>
				</div><?php endif; ?>
				<?php if($isshowcss == 4): ?><div class="btn-box app-flex app-vertical-center app-content-around" style="height: 2.5rem;">
				<div class="quiz-btn-again">
				<a href="javascript:void(0);" style="
margin: 0;" id="collectproblem" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">取消收藏</a>
				</div><?php endif; ?>
				
			    <?php if($qinfo['isend'] == 1): ?><div class="give-score">
					<a href="javascript:void(0);" style="margin: 0;" @click="pop_give_score($event);">为TA充电</a>
				</div>
			</div><?php endif; ?>
		</div><?php endif; ?>
		<?php if($qinfo['isend'] == 0 && $aninfo == '' ): ?><div class="btm-btn">
			<div class="app-flex app-vertical-center app-content-justify">
				<div class="quiz-btn-again app-basis"style="padding: 0 .5rem">
				 <?php if($iscollect2 == 1): ?><a href="javascript:void(0);" style="border:0;margin:0" id="collectproblem2" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">取消收藏</a>
				 <?php else: ?>
				 <a href="javascript:void(0);" style="border:0;margin:0" id="collectproblem2" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">收藏问题</a><?php endif; ?>
				</div>
			</div>
		</div><?php endif; ?>
		<!--<?php if($qinfo['isend'] == 0 && $aninfo == '' ): ?><div class="weui-btn-area">
			<?php if($iscollect2 == 1): ?><a class="weui-btn weui-btn_primary" href="javascript:" id="collectproblem2" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">取消收藏</a>
			<?php else: ?>
            <a class="weui-btn weui-btn_primary" href="javascript:" id="collectproblem2" @click="add_favar_or_cancel2($event,'<?php echo ($qinfo["id"]); ?>');">收藏问题</a><?php endif; ?>
        </div><?php endif; ?>-->
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/libs/weui/jquery-weui.js"></script>
<script>
	$.toast.prototype.defaults.duration = 3000;
	var audio = document.querySelector("#aud");
	
	//监听语音控件是否处于暂停状态
	audio.addEventListener("pause",function(){
		$("#app").find(".playing").removeClass("playing").text("点击收听")
	})
	var app = new Vue({
		el:'#app',
		data:{
			cur_index:1,
			show_layer:false,
			show_layer2:false,
			favared:false
		},
		methods:{
			pop_give_score:function(evt){
				this.show_layer2 = true;
			},
			add_favar_or_cancel:function(evt){
				var taskid ='<?php echo ($uinfo["id"]); ?>';
				if($(evt.target).hasClass('favared')){
					//数据操作
					$.ajax({
						url:"<?php echo U('Home/Problem/collect');?>",
						data:{taskid:taskid,type:2},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$(evt.target).removeClass("favared");
								$("#collectnum").html(data.collectnum);
								$.toast("你已取消对TA的收藏",3000);
                        	}
                        }
					})
					
				}else{
					//数据操作
					
					$.ajax({
						url:"<?php echo U('Home/Problem/collect');?>",
						data:{taskid:taskid,type:1},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$(evt.target).addClass("favared");
								$("#collectnum").html(data.collectnum);
								$.toast("你已成功收藏TA~",3000);
                        	}
                        }
					})
				}
			},
			add_favar_or_cancel2:function(evt,taskid){
				
				if($('#collectproblem').html()=='取消收藏'){
					//数据操作
					$.ajax({
						url:"<?php echo U('Home/Problem/collect2');?>",
						data:{taskid:taskid,type:2},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$("#collectproblem1").html('收藏问题');
								$("#collectproblem2").html('收藏问题');
								$("#collectproblem").html('收藏问题');
								$.toast("你已取消对TA的收藏",3000);
                        	}
                        }
					})
					
				}else{
					//数据操作					
					$.ajax({
						url:"<?php echo U('Home/Problem/collect2');?>",
						data:{taskid:taskid,type:1},
						type:'POST',
                        success: function (data) {
                        	if(data.status == 1)
                        	{
                        		$('#collectproblem').html('取消收藏');
								$('#collectproblem1').html('取消收藏');
								$("#collectproblem2").html('取消收藏');
								$.toast("你已成功收藏TA~",3000);
                        	}
                        }
					})
				}
			},
			charge:function(evt,award_num){
				//如果有奖赏金额 则调用微信支付 否则关闭
				var taskid ='<?php echo ($qinfo["id"]); ?>';			
				if(award_num == 0){
					this.show_layer2 = !this.show_layer2;					
					$.ajax({
						url:"<?php echo U('Home/Problem/dopay');?>",
						data:{price:award_num,id:taskid},
						type:'POST',
						success:function(data){
							if(data.status==1)
							{
								 //$.toast("非常感谢！您的支持是我们持续提升的动力","success");								
							}
						}
					})
				}
				else if(award_num == '-1'){
					//自选金额
					$.prompt({
						title:'打赏金额',
						text:'',
						input:'',
						empty:false,
						onOK:function(award_price){
							var id="<?php echo ($qinfo["id"]); ?>";
							$.showLoading("跳转支付...");
							$.ajax({
								url:"<?php echo U('Home/Problem/dopay');?>",
								data:{price:award_price,id:id},
								type:'POST',
								success:function(data){
									if(data.status==1)
									{
										location.href=data.url;
									}
								}
							})			
						},
						onCancel:function(){

						}
					});

				}
				else{
					//支付成功 返回
					var id="<?php echo ($qinfo["id"]); ?>";
					$.showLoading("跳转支付...");
					$.ajax({
						url:"<?php echo U('Home/Problem/dopay');?>",
						data:{price:award_num,id:id},
						type:'POST',
						success:function(data){
							if(data.status==1)
							{
								location.href=data.url;
							}
						}
					})					
				}
			}

		}
	});
	//播放语音控件
	$("#app").on('click','.audio-item',function(evt){
		console.log(audio.duration);
		console.log(audio.readyState);
		
		var that = $(this);
		var src = that.data("audio-src");
		that.parents('.audio-wrap').siblings().find(".audio-item").removeClass("playing").text("点击收听");
		$(this).parents('.quiz-content').siblings().find(".audio-item").removeClass("playing");
		$(this).parents('.quiz-content').siblings().find(".audio-item").text("点击收听");
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
	
	//图片预览
	$("#app").on('click','.img-wrap img',function(evt){
		//alert($(this).attr("src"));
		var preview = $.photoBrowser({
		  items: [
			$(this).attr("src")
		  ]
		});

		preview.open();
	})
</script>
</html>