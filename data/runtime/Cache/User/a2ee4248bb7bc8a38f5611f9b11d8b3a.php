<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>申请认证</title>
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
	<style>
	.app-vertical-center .upload-photo2{width: 4.9rem;line-height: 1.4rem;margin-left:15px;}
	.upImg{ margin: 0 15px 15px;}
	.upImg>img{ width:100%;margin:0 auto; max-height:10rem; object-fit:contain}
	.upImg>p{ font-size:1rem;color:#3cc8fe; text-align:center}
	.weui-btn_primary{ background:#3cc8fe}
	.weui-btn_primary:not(.weui-btn_disabled):active{ background:#3cc8fe}
	.weui-cells:after{border:none}
	</style>
</head>
<body data-app="ChineseBang">
	<!--教师登录-->
	<section class="form-container apply-container" id="app" style="padding:0;">
		
	<div class="weui-cells">
		<div class="weui-cell">
			<div class="weui-cell__hd">
				<img src="/public/assets/xingming-1.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">姓名</label>
			</div>
			<div class="weui-cell__bd">
				<input class="weui-input" style="width:100%" name="uname" placeholder="请输入真实姓名" maxlength="10" v-model="uname">
			</div>
		</div>
		<div class="weui-cell">
			<div class="weui-cell__hd">
				<img src="/public/assets/nicname.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">昵称</label>
			</div>
			<div class="weui-cell__bd">
				<input class="weui-input" style="width:100%" name="nickname" placeholder="请输入昵称" maxlength="10" v-model="nickname">
			</div>
		</div>
		<div class="weui-cell weui-cell_select weui-cell_select-after" style="padding:1px 15px">
			<div class="weui-cell__hd">
				<img src="/public/assets/xueke.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">学科</label>
			</div>
			<div class="weui-cell__bd">
				<select class="weui-select" v-model="xk" @change='xkChange($event)' data-id="<?php echo ($xk); ?>">
					<option value="0">请选择教学学科</option>
					<option value="1">语文</option>
					<option value="2">数学</option>
					<option value="3">英语</option>
					<option value="4">物理</option>
					<option value="5">化学</option>
					<option value="6">历史</option>
					<option value="7">政治</option>
				</select>
			</div>
		</div>
		<div class="weui-cell">
			<div class="weui-cell__hd">
				<img src="/public/assets/jiaolin.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">教龄</label>
			</div>
			<div class="weui-cell__bd">
				<input class="weui-input" name="teach_age" placeholder="请输入您的教龄" maxlength="2" v-model="teach_age">
			</div>
		</div>
		<div class="weui-cell weui-cell_select weui-cell_select-after" style="padding:1px 15px">
			<div class="weui-cell__hd">
				<img src="/public/assets/zhicheng.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">职称</label>
			</div>
			<div class="weui-cell__bd">
				<select class="weui-select" name="teacher" v-model="title">
					<option value="">请选择教师职称</option>
					<option value="初级教师">初级教师</option>
					<option value="中级教师">中级教师</option>
					<option value="高级教师">高级教师</option>
					<option value="特级教师">特级教师</option>
					<option value="研究员">研究员</option>
				</select>
			</div>
		</div>
		<div class="weui-cell weui-cell_select weui-cell_select-after" style="padding:1px 15px">
			<div class="weui-cell__hd">
				<img src="/public/assets/xuexiao.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">学校</label>
			</div>
			<div class="weui-cell__bd">
				<select class="weui-select" name="school" v-model="school">
					<option value="">请选择学校类型</option>
					<option value="区、县级普通中学">区、县级普通中学</option>
					<option value="区、县级重点中学">区、县级重点中学</option>
					<option value="市级重点中学">市级重点中学</option>
				</select>
			</div>
		</div>
		<div class="weui-cell">
			<div class="weui-cell__hd">
				<img src="/public/assets/shanchang.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">擅长</label>
			</div>
			<div class="weui-cell__bd" id="goodat" >
				<input type="text" name="goodat" style="width:100%"  placeholder="擅长题型（最多选5项）" v-model="goodat_name" readonly>
			</div>
		</div>
		<div class="weui-cell">
			<div class="weui-cell__hd">
				<img src="/public/assets/rongyu.png" alt="" style="width:20px;margin-right:5px;display:block">
			</div>
			<div class="weui-cell__hd">
				<label class="weui-label" style="width:75px">荣誉</label>
			</div>
			<div class="weui-cell__bd" id="honor">
				<input type="text" name="goodat" style="width:100%" placeholder="所获荣誉（最多3项）" v-model="honor_name" readonly>
			</div>
		</div>
		<div class="weui-cell">
			<div class="weui-cell__hd">
				<img src="/public/assets/xiangpian.png" alt="" style="width:23px;margin-right:2px;display:block">
			</div>
			<div class="weui-cell__bd">
				<p>教师资格证书或职称照片</p>
			</div>
			<div class="weui-cell__ft" @click="pop_preview(1);" style="color:#3cc8fe;font-size:.8rem;line-height:24px">查看示例</div>
		</div>
		<div class="upImg" id="titleimg">
			<?php if($titleimg != ''): ?><img src="<?php echo ($titleimg); ?>" alt="img" style="width:12rem; padding:2rem 0">
			<?php else: ?>
			<!--<div class="bgImg">点击上传</div>-->
			<img src="/public/assets/xiangpian1.png" style="width:7rem; padding:2rem 0 0">
			<p style="padding-bottom:2rem">点击上传</p><?php endif; ?>
		</div>
		<input type="hidden" id="titleimgval" value="<?php echo ($titleimg); ?>">
	</div>
		
		
		<div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" @click="apply_as($event);" href="javascript:;">申请认证</a>
        </div>
		<div class="apply-tips">以上信息仅供国安、教育等部门审核时备查<br>您的信息将绝对保密</div>
		<div v-if="show_layer" class="cover-layer" v-cloak></div>
		<div v-if="show_layer" class="apply-result" v-cloak style="padding: 1.25rem 1.35rem;">
			<span>您的资料已上传成功<br/>我们将在2个工作日内完成审核<br>感谢您的等待</span>
		</div>
		<input type="hidden" id="userid" value="<?php echo ($id); ?>">
		<?php if($isdo == 1 && $status == 0): ?><div class="cover-layer" ></div>
		<div class="apply-result" style="padding: 1.25rem 1.35rem;">
			<span>您的资料已上传成功<br/>我们将在2个工作日内完成审核<br>感谢您的等待</span>
		</div><?php endif; ?>
		<!--示例查看-->
		<div v-if="show_layer2" class="cover-layer" v-cloak></div>
		<div v-if="show_layer2" class="demo-picture-preview" v-cloak>
			<div class="close-btn" @click="show_layer2=false"></div>
			<img :src="preview_src" alt="book">
		</div>
	</section>
</body>
<script src="/public/libs/fixed.js"></script>
<script src="/public/script/common.js"></script>
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
			"chooseImage",
            "uploadImage",
            "downloadImage",
            "previewImage"
        ]
    });
	// 4. 通过ready接口处理成功验证
    wx.ready(function () {     
		$("#titleimg").click(function(){
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
									$("#titleimg img").attr('src',res.strimgurl).css("width","12rem");
									$("#titleimgval").val(res.strimgurl);
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
		});
	});
    // 5. 通过error接口处理失败验证
    wx.error(function (res) {
        alert(JSON.stringify(res));
    });
	$.toast.prototype.defaults.duration = 3000;
	var app = new Vue({
		el:'#app',
		data:{
			uname:'<?php echo ($nicename); ?>',
			nickname:'<?php echo ($truename); ?>',
			teach_age:'<?php echo ($seniority); ?>',
			title:'<?php echo ($title); ?>',
			school:'<?php echo ($schoolname); ?>',
			goodat_name:'<?php echo ($questiontype); ?>',
			honor_name:'<?php echo ($honors); ?>',
			goodat1:null,    //擅长（语文）
			goodat2:null,      //擅长（数学）
			goodat3:null,     //擅长（英语）
			goodat4:null,     //擅长（物理）
			goodat5:null,     //擅长（化学）
			goodat6:null,    //擅长（政治）
			goodat7:null,    //擅长（历史）
			honor:null,
			show_layer:false,
			show_layer2:false,
			preview_src:'/public/assets/book1.jpg',
			upload_title_img:'',
			upload_job_img:'',
			education:'',
			xk:<?php echo ($xk); ?>    //当前选择的学科编号
		},
		mounted:function(){
			var that = this;
			Vue.nextTick(function(){
				//封装擅长数据
				//语文
				that.goodat1 =[
				{
					title:'中国文化趣谈',
					value:'001'
				},
				{
					title:'西方文化趣谈',
					value:'002'
				},
				{
					title:'基础知识应试技巧',
					value:'003'
				},
				{
					title:'综合性学习应试技巧',
					value:'004'
				},
				{
					title:'记叙文小说应试技巧',
					value:'005'
				},
				{
					title:'说明文应试技巧',
					value:'006'
				},
				{
					title:'议论文应试技巧',
					value:'007'
				},
				{
					title:'作文应试技巧',
					value:'008'
				},
				{
					title:'课内现代文导读',
					value:'009'
				},
				{
					title:'课内古诗文导读',
					value:'010'
				},
				{
					title:'课外阅读指南',
					value:'011'
				},
				{
					title:'学科渗透及其他',
					value:'012'
				}];
				//数学
				that.goodat2 = [
				{
					title:'实数',
					value:'101'
				},
				{
					title:'代数',
					value:'102'
				},
				{
					title:'整式',
					value:'103'
				},
				{
					title:'分式',
					value:'104'
				},
				{
					title:'方程（组）与不等式',
					value:'105'
				},
				{
					title:'变量与函数',
					value:'106'
				},
				{
					title:'图形的认识',
					value:'107'
				},
				{
					title:'圆',
					value:'108'
				},
				{
					title:'空间与图形',
					value:'109'
				},
				{
					title:'统计与概率',
					value:'110'
				},
				{
					title:'其他',
					value:'111'
				}];
				//英语
				that.goodat3 = [
				{
					title:'听力',
					value:'201'
				},
				{
					title:'单选',
					value:'202'
				},
				{
					title:'完形',
					value:'203'
				},
				{
					title:'阅读',
					value:'204'
				},
				{
					title:'任务性阅读',
					value:'205'
				},
				{
					title:'正确形式填空',
					value:'206'
				},
				{
					title:'完成句子',
					value:'207'
				},
				{
					title:'短文填空',
					value:'208'
				},
				{
					title:'作文',
					value:'209'
				},
				{
					title:'口语交际',
					value:'210'
				},
				{
					title:'其他',
					value:'211'
				}];
				//物理
				that.goodat4 = [
				{
					title:'质量与密度',
					value:'301'
				},
				{
					title:'压力压强',
					value:'302'
				},
				{
					title:'浮力',
					value:'303'
				},
				{
					title:'简单机械',
					value:'304'
				},
				{
					title:'功率和机械效率',
					value:'305'
				},
				{
					title:'电学',
					value:'306'
				},
				{
					title:'光学',
					value:'307'
				},
				{
					title:'运动学',
					value:'308'
				},
				{
					title:'热学',
					value:'309'
				},
				{
					title:'其他',
					value:'310'
				}];
				//化学
				that.goodat5 = [
				{
					title:'空气与O2',
					value:'401'
				},
				{
					title:'碳和碳的氧化物',
					value:'402'
				},
				{
					title:'水及溶液',
					value:'403'
				},
				{
					title:'金属与金属材料',
					value:'404'
				},
				{
					title:'酸和碱',
					value:'405'
				},
				{
					title:'盐和化肥',
					value:'406'
				},
				{
					title:'常见气体的制取',
					value:'407'
				},
				{
					title:'化学式和化合价，构成物质的微粒',
					value:'408'
				},
				{
					title:'化学与生活，化学与能源',
					value:'409'
				},
				{
					title:'化学计算',
					value:'410'
				},
				{
					title:'其他',
					value:'411'
				}];
				//政治
				that.goodat6 = [
				{
					title:'尊重、宽容、理解',
					value:'501'
				},
				{
					title:'诚信、竞争、合作',
					value:'502'
				},
				{
					title:'个人、集体、责任、公平、正义',
					value:'503'
				},
				{
					title:'网络的利与弊',
					value:'504'
				},
				{
					title:'法律基本知识',
					value:'505'
				},
				{
					title:'公民的权利与义务',
					value:'506'
				},
				{
					title:'未成年人的特殊保护',
					value:'507'
				},
				{
					title:'国策、战略、理念',
					value:'508'
				},
				{
					title:'发展道路、理论体系、伟人旗帜',
					value:'509'
				},
				{
					title:'政治学科核心观点',
					value:'510'
				},
				{
					title:'其他',
					value:'511'
				}];
				//历史
				that.goodat7 = [
				{
					title:'古今中外文明交往',
					value:'601'
				},
				{
					title:'中国古代科技文化',
					value:'602'
				},
				{
					title:'大国关系',
					value:'603'
				},
				{
					title:'中华民族复兴',
					value:'604'
				},
				{
					title:'两次世界大战',
					value:'605'
				},
				{
					title:'省市本土历史',
					value:'606'
				},
				{
					title:'中共党史',
					value:'607'
				},
				{
					title:'重要历史人物',
					value:'608'
				},
				{
					title:'热点时事连线',
					value:'609'
				},
				{
					title:'其他',
					value:'610'
				}];

				//封装荣誉数据
				that.honor= [
				{
					title:'参与中考命题',
					value:'001'
				},
				{
					title:'参与中考阅卷',
					value:'002'
				},
				{
					title:'学校教研组长',
					value:'003'
				},
				{
					title:'年级备课组长',
					value:'004'
				},
				{
					title:'全国赛课获奖',
					value:'005'
				},
				{
					title:'全国论文比赛获奖',
					value:'006'
				},
				{
					title:'市级赛课获奖',
					value:'007'
				},
				{
					title:'市级论文比赛获奖',
					value:'008'
				},
				{
					title:'发表核心期刊论文',
					value:'009'
				},
				{
					title:'业内知名教师',
					value:'010'
				},
				{
					title:'学校教学骨干',
					value:'011'
				},
				{
					title:'中考成绩优秀',
					value:'008'
				}];

				
				//荣誉弹框
				$("#honor").select({
				  title:'选择荣誉选项',
				  multi: true,
				  items: that.honor,
				  onChange:function(data){
					
				  },
				  beforeClose:function(v,t){
					if(t.split(',').length > 3){
						$.toast("最多只能选择3个选项");
						return false;
					}
					 app.honor_name = t;
				  }
				})

			});
		},
		methods:{
			pop_preview:function(type){
				this.preview_src = type == 1 ? '/public/assets/book1.jpg' : '/public/assets/book2.jpg'
				this.show_layer2 = true;
			},
			xkChange:function(evt){
				var self=this;
				self.goodat_name='';
				self.goodatlist='';
				console.log(self.xk);	
				self.goodatlist=self.xk==1?self.goodat1:(self.xk==2?self.goodat2:(self.xk==3?self.goodat3:(self.xk==4?self.goodat4:(self.xk==5?self.goodat5:(self.xk==6?self.goodat7:self.goodat6)))));
				
				if(self.xk==0){    //未选择学科
					$.toast("请选择学科",'text');
				}
				else{
					//擅长弹框
					$("#goodat").select('update',{
					  title:'选择擅长选项',
					  multi: true,
					  items: self.goodatlist,
					  onChange:function(data){
						
					  },
					  beforeClose:function(v,t){
						if(t.split(',').length > 5){
							$.toast("最多只能选择5个选项",'text');
							return false;
						}
						 app.goodat_name = t;
					  }
					});
				}
					
			},
			apply_as:function(evt){
				if(this.uname == ''){
					$.toptip("输入姓名",1500,'warning');
					return;
				}
				if(this.nickname == ''){
					$.toptip("输入昵称",1500,'warning');
					return;
				}
				if(this.xk == '0'){
					$.toptip("选择学科",1500,'warning');
					return;
				}
				if(this.teach_age == ''){
					$.toptip("输入教龄",1500,'warning');
					return;
				}
				if(this.title == ''){
					$.toptip("选择教师职称",1500,'warning');
					return;
				}
				if(this.school == ''){
					$.toptip("选择学校类型",1500,'warning');
					return;
				}
				if(this.goodat_name == ''){
					$.toptip("选择擅长选项",1500,'warning');
					return;
				}
				if(this.honor_name == ''){
					$.toptip("选择荣誉选项",1500,'warning');
					return;
				}
				var titleimg =$("#titleimgval").val();
				if(titleimg == '')
				{
					$.toptip("上传职称照片",1500,'warning');
					return;
				}
				var profileInfo = {                       
                        "nicename" :this.uname,
						"truename" :this.nickname,
                        "seniority" : this.teach_age,
                        "title":this.title,
                        "schoolname":this.school,
                        "questiontype":this.goodat_name,
                        "honors":this.honor_name,
                        "userid":$("#userid").val(),
						"titleimg":titleimg,
						"xk":this.xk
                    };
				$.showLoading("提交中...");
				$.ajax({
                        url: "<?php echo U('User/center/doapply');?>",
                        data: profileInfo,
                        type:'POST',
                        success: function (data) {
                        	console.log(data.msg);
                            if (data.status==1) {                               
                                //数据提交成功后关闭提示
  								setTimeout(function(){
  									$.hideLoading();
  									app.show_layer = true;
  								},1500)
                            }
                            else {
                                //跳转到预定失败界面
                                $.hideLoading();
                                $.toast(data.msg,'forbidden');
                            }
                        }
                });		
			}
		}
	});
});
</script>
</html>