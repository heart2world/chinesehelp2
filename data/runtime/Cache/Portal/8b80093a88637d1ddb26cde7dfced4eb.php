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
</style>
</head>
<body>
	<div class="wrap js-check-wrap" id="app">
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;" target="_self">详情</a></li>
			<li><a href="javascript:history.back(-1);"><?php echo L('BACK');?></a></li>
		</ul>
		<form class="form-horizontal" id="tagforms" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group">
					<label class="control-label">类型：</label>
					<div class="controls">
					  <label style="margin-top: 5px;"><?php if($post['post_term'] == 1): ?>公告<?php else: ?>轮播图<?php endif; ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="form-required">*</span>标题：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($post["post_title"]); ?></label>
					</div>
				</div>
				<div id="lunbotu" <?php if($post['post_term'] == 1): ?>style="display:none;"<?php endif; ?>>
					<div class="control-group">
						<label class="control-label"><span class="form-required">*</span>图片：</label>
						<div class="controls">

								<?php if($post['post_img'] != ''): ?><img src="<?php echo ($post["post_img2"]); ?>" id="thumb-preview" width="120" height="80" style="cursor: hand" />			
								<?php else: ?>		
								<img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" id="thumb-preview" width="100" height="100" style="cursor: hand" /><?php endif; ?>
						</div><br/>
						<div style="margin-left: 180px;color: red;">建议图片尺寸：750*392</div>
					</div>
					<div class="control-group">
						<label class="control-label"><span class="form-required">*</span>链接：</label>
						<div class="controls">
							<label style="margin-top: 5px;"><?php echo ($post["link_url"]); ?></label>
						</div>
					</div>

				</div>
				<div id="concontent" <?php if($post['post_term'] == 2): ?>style="display:none;"<?php endif; ?>>
				<div class="control-group">
					<label class="control-label"><span class="form-required">*</span>开放端：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php if($post['isterm'] == 1): ?>教师端<?php else: ?>学生端<?php endif; ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="form-required">*</span>内容简介：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($post["post_excerpt"]); ?></label>
					</div>
				</div>
				<div class="control-group">
				<div class="control-group" >
					<label class="control-label"><span class="form-required">*</span>文章内容：</label>
					<div class="controls" style="width: 800px;">
						<label style="margin-top: 5px;"><?php echo ($post["post_content"]); ?></label>
					</div>
				</div>
				</div>
			</fieldset>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script src="/public/js/vue.js"></script>
	<script src="/public/js/content_addtop.js"></script>
	<script src="/public/js/define_my.js"></script>
	<script src="/public/js/artDialog/artDialog.js"></script>
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
				add:function () {	
				     var tagvals=$('#tagforms').serialize();				
					$.ajax({
						url:'<?php echo U("AdminPost/edit_post");?>',
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