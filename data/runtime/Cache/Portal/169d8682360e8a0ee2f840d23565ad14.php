<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
		.form-required{color:red;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/",
	    WEB_ROOT: "/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<style type="text/css">
.pic-list li {
	margin-bottom: 5px;
}
input[type="radio"], input[type="checkbox"]{margin:0px;vertical-align:middle}
</style>
</head>
<body>
	<div class="wrap js-check-wrap" id="app">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('AdminPost/index');?>"><?php echo L('PORTAL_ADMINPOST_INDEX');?></a></li>
			<li class="active"><a href="javascript:;" target="_self">新增</a></li>
		</ul>
		<form class="form-horizontal" id="tagforms" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group">
					<label class="control-label">类型：</label>
					<div class="controls">
						<select name="post_term" onchange="getshowContent(this.value)">
							<option value="1">公告</option>
							<option value="2">轮播图</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="form-required">*</span>标题：</label>
					<div class="controls">
						<input type="text" name="post_title" maxlength="20" placeholder="标题限制20字以内">
					</div>
				</div>
				<div id="termtype0">
					<div class="control-group">
						<label class="control-label"><span class="form-required">*</span>位置：</label>
						<div class="controls">
							<input type="checkbox" name="isterm[]" id="isterm" value="1"> 教师端 &nbsp;
							<input type="checkbox" name="isterm[]" id="isterm" value="2"> 学生端
						</div>					
					</div>
					<div class="control-group">
							<label class="control-label"><span class="form-required">*</span>图片：</label>
							<div class="controls">
								<input type="hidden" name="post_imgs" id="thumb0" value="">
								<a href="javascript:upload_one_image2('图片上传','#thumb0');">							
									<img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" id="thumb0-preview1" width="100" height="100" style="cursor: hand" />
								</a>
								<input type="button" class="btn btn-small" onclick="$('#thumb0-preview1').attr('src','/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png');$('#thumb0').val('');return false;" value="取消图片">
							</div><br/>
							<div style="margin-left: 180px;color: red;">建议图片尺寸：750*392</div>
					</div>
				</div>
				<div id="lunbotu" style="display:none;">
					<div class="control-group">
						<label class="control-label"><span class="form-required">*</span>位置：</label>
						<div class="controls">
							&nbsp;<input type="radio" name="isterm" id="isterms" value="1"> 教师端 &nbsp;	
							&nbsp;<input type="radio" name="isterm" id="isterms" value="2"> 学生端 &nbsp;							
						</div>
					</div>
					<div class="control-group" id="studentlist">
						<label class="control-label"></label>
						<div class="controls">
							学生端： 		<input type="checkbox" name="isterms[]" id="isterm" value="2"> 问学帮首页 &nbsp;	
											<input type="checkbox" name="isterms[]" id="isterm" value="3"> 语文帮 &nbsp;
											<input type="checkbox" name="isterms[]" id="isterm" value="4"> 数学帮 &nbsp;
											<input type="checkbox" name="isterms[]" id="isterm" value="5"> 英语帮 &nbsp;
											<input type="checkbox" name="isterms[]" id="isterm" value="6"> 物理帮 &nbsp;
											<input type="checkbox" name="isterms[]" id="isterm" value="7"> 化学帮 &nbsp;
											<input type="checkbox" name="isterms[]" id="isterm" value="8"> 政治帮 &nbsp;
											<input type="checkbox" name="isterms[]" id="isterm" value="9"> 历史帮 &nbsp;
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"><span class="form-required">*</span>图片：</label>
						<div class="controls">
							<input type="hidden" name="post_img" id="thumb" value="">
							<a href="javascript:upload_one_image('图片上传','#thumb');">							
								<img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" id="thumb-preview" width="100" height="100" style="cursor: hand" />
							</a>
							<input type="button" class="btn btn-small" onclick="$('#thumb-preview').attr('src','/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png');$('#thumb').val('');return false;" value="取消图片">
						</div><br/>
						<div style="margin-left: 180px;color: red;">建议图片尺寸：750*392</div>
					</div>
					<div class="control-group">
						<label class="control-label">链接：</label>
						<div class="controls">
							<input type="text" name="link_url" id="link_url" style="width:550px;" style="background:#1abc9c;" placeholder="须以http://开头">
							<input type="button" @click="dolink()" class="btn addlink" value="添加链接">
						</div><br/>
						<div style="margin-left: 180px;color: red;">公告请直接填链接；微课/问答/资源请点击"添加链接"进行选择</div>
					</div>
					<div id="selecttype" style="display:none;">
						<div class="control-group">
							<label class="control-label">类型</label>
							<div class="controls">
									<select name="gtype" id="gtype">
										<option value="">选择类型</option>
										<option value="问答">问答</option>
										<option value="资源">资源</option>
										<option value="微课">微课</option>
									</select>
									<input type="button" @click="selecttypelist()" class="btn" style="background:#1abc9c;" value="搜索结果">
							</div>
						</div>
						<div class="control-group" id="idtypelist" style="display:none;">
							<label class="control-label">选择文章</label>
							<div class="controls">
									<select name="ids" id="idlist" onchange="doinfo(this.value)">
										
									</select>
							</div>
						</div>
					</div>
				</div>
				<div id="concontent">
				
				<div class="control-group">
					<label class="control-label"><span class="form-required">*</span>内容简介：</label>
					<div class="controls">
						<textarea name="post_excerpt" style="width:400px;height:50px;"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="form-required">*</span>文章内容：</label>
					<div class="controls" style="width: 800px;">
						<script type="text/plain" id="content" name="post_content"></script>
					</div>
				</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<input type="button" @click="add()" class="btn btn-primary" value="保存"/>
				<a class="btn" href="javascript:history.back(-1);"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script src="/public/js/vue.js"></script>
	<script src="/public/js/content_addtop.js"></script>
	<script src="/public/js/define_my.js"></script>
	<script src="/public/js/artDialog/artDialog.js"></script>
	<script>
	$(function(){
		$('input:radio[name="isterm"]').click(function(){
			var isterm =$(this).val();
			if(isterm ==2)
			{
				$("#studentlist").show();
				$(".addlink").show();
			}
			else
			{
				$("#studentlist").hide();
				$(".addlink").hide();
			}
		})		
	})
	function doinfo(val)
	{
		var isterm =$('input:radio[name="isterm"]:checked').val();
		var gtype =$("#gtype").val();
		$.ajax({
			url:'<?php echo U("AdminPost/getopurl");?>',
			data:{id:val,gtype:gtype,isterm:isterm},
			type:"POST",
			dataType:"json",
			success:function (res) {							
				if(res.status==0){
					$("#link_url").val(res.url);						
				}					
			}
		});
	}
	</script>
	<script type="text/javascript">
		//编辑器路径定义
		var editorURL = GV.WEB_ROOT;
		function getshowContent(id)
		{
			if(id == 1)
			{
				$("#lunbotu").hide();
				$("#concontent").show();
				$("#termtype0").show();
			}else{
				$("#termtype0").hide();
				$("#lunbotu").show();
				$("#concontent").hide();
			}
		}
	</script>
	<script type="text/javascript" src="/public/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="/public/js/ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$(".js-ajax-close-btn").on('click', function(e) {
				e.preventDefault();
				Wind.use("artDialog", function() {
					art.dialog({
						id : "question",
						icon : "question",
						fixed : true,
						lock : true,
						background : "#CCCCCC",
						opacity : 0,
						content : "您确定需要关闭当前页面嘛？",
						ok : function() {
							setCookie("refersh_time", 1);
							window.close();
							return true;
						}
					});
				});
			});
			/////---------------------
			Wind.use('validate', 'ajaxForm', 'artDialog', function() {
				//javascript

				//编辑器
				editorcontent = new baidu.editor.ui.Editor();
				editorcontent.render('content');
				try {
					editorcontent.sync();
				} catch (err) {
				}
				//增加编辑器验证规则
				jQuery.validator.addMethod('editorcontent', function() {
					try {
						editorcontent.sync();
					} catch (err) {
					}
					return editorcontent.hasContents();
				});
				var form = $('form.js-ajax-forms');
				//ie处理placeholder提交问题
				if ($.browser && $.browser.msie) {
					form.find('[placeholder]').each(function() {
						var input = $(this);
						if (input.val() == input.attr('placeholder')) {
							input.val('');
						}
					});
				}

				var formloading = false;
				
			});
			////-------------------------
		});
	</script>
	<script>
		var app = new Vue({
			el:"#app",
			data:{
				info:{},				
			},
			created:function () {
			},
			methods:{
				selecttypelist:function(){
					var isterm =$('input:radio[name="isterm"]:checked').val();
					var gtype=$("#gtype").val();
					$.ajax({
						url:'<?php echo U("AdminPost/getoplist");?>',
						data:{isterm:isterm,gtype:gtype},
						type:"POST",
						dataType:"json",
						success:function (res) {							
							if(res.status==0){
								$("#idtypelist").show();
								$("#idlist").html(res.html);
							}					
						}
					});
				},				
				dolink:function(){
					
					$("#selecttype").show();
					
				},
				add:function () {	
				     var tagvals=$('#tagforms').serialize();				
					$.ajax({
						url:'<?php echo U("AdminPost/add_post");?>',
						data:tagvals,
						type:"POST",
						dataType:"json",
						success:function (res) {							
							if(res.status==0){
								$.dialog({id: 'popup', lock: true,icon:"succeed", content: res.msg, time: 2});
								setInterval(function(){
									location.href='<?php echo U("AdminPost/index");?>';
								},3000)
							}
							else {
								$.dialog({id: 'popup', lock: true,icon:"warning", content: res.msg, time: 2});
							}
						}

					})
				}
			}
		});	

	</script>
</body>
</html>