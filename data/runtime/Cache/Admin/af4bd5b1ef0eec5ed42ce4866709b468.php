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
</head>
<style type="text/css">
.form-horizontal .control-group{margin-bottom: 10px;}
.row-fluid12{
        display:none;position: absolute;  top: 25%;border-radius: 3px;  left: 34%; width: 350px; overflow:hidden; overflow-y: auto;  padding: 8px;  border: 1px solid #E8E9F7;  background-color: white;  z-index:10003;
    }
.row-fluid123{
        display:none;position: absolute;  top: 25%;border-radius: 3px;  left: 34%; width: 350px; overflow:hidden; overflow-y: auto;  padding: 8px;  border: 1px solid #E8E9F7;  background-color: white;  z-index:10003;
    }
#bg{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}
</style>
<body>
	<div class="wrap" id="app">
		<ul class="nav nav-tabs">
			<li class="active"><a>用户详情</a></li>
			<li><a href="javascript:history.go(-1);">返回</a></li>
		</ul>
		<form class="form-horizontal" id="tagforms" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group">
					<label class="control-label" >姓名：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["nicename"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-birthday">教龄：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["seniority"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">账号：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["mobile"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">学科：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["xueke"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">TA的代理：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php if($info['parentname'] != ''): echo ($info["parentname"]); ?>/<?php echo ($info["parentmobile"]); else: ?>暂无<?php endif; ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">职称：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["title"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">学校：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["schoolname"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">教师资格证或职称照片：</label>
					<div class="controls">
						<?php if($info["titleimg"] != ''): ?><label style="margin-top: 5px;"><a href="<?php echo U('Teacher/img',array('id'=>$info['id']));?>"><img src="<?php echo ($info["titleimg"]); ?>" width="120"></a></label>
						<?php else: ?>
						<label style="margin-top: 5px;"><img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" width="120"></label><?php endif; ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">擅长题型：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["questiontype"]); ?></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-user_url">所获荣誉：</label>
					<div class="controls">
						<label style="margin-top: 5px;"><?php echo ($info["honors"]); ?></label>
					</div>
				</div>
			</fieldset>
			<?php if($info['status'] == 0): ?><div class="form-actions">				
				<input type="button" onclick="showadd(<?php echo ($info["id"]); ?>)" class="btn btn-primary" value="驳回"/>	
				<input type="button" onclick="showadd2(<?php echo ($info["id"]); ?>)" class="btn btn-primary" value="通过审核"/>				
			</div><?php endif; ?>
			<?php if($info['status'] == 1): ?><div class="tab-content">
					<div class="control-group" style="margin-left: 90px;"><?php echo ($ancount); ?>人答题，<?php echo ($collectcount); ?>人关注</div>
				    <div class="control-group">
					<label class="control-label" style="font-weight: bold"><span><a>发布记录</a></span></label>
        			<HR width="100%" color=#987cb9 SIZE=1 />
						<table class="table table-hover table-bordered" id="A" >
						<thead>
							<tr>
								<th style="text-align: center;width: 50px;">ID</th>
								<th style="text-align: center;width: 100px;">发布时间</th>
								<th style="text-align: center;width: 200px;">发布类型</th>
								<th style="text-align: center;width: 200px;">发布标题</th>							
								<th style="text-align: center;width: 100px;">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
								<td style="text-align: center;"><?php echo ($key+1); ?></td>
								<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
								<td style="text-align: center;"><?php echo ($vo["type"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["title"]); ?></td>							
								<td style="text-align: center;">
									<?php if($vo['type'] != '专题'): ?><a href="<?php echo U('Wclass/detail',array('id'=>$vo['id']));?>" style="padding: 2px 15px;background-color:  #bfc6cb;" class="btn btn-primary">查看详情</a>
									<?php else: ?>
									<a href="<?php echo U('Zhuanti/detail',array('id'=>$vo['id']));?>" style="padding: 2px 15px;background-color:  #bfc6cb;" class="btn btn-primary">查看详情</a><?php endif; ?>
								</td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-content">
				    <div class="control-group">
					<label class="control-label" style="font-weight: bold;width: 380px;text-align: center;"><span><a>TA的学生</a></span>&nbsp;&nbsp;<span>合计人数：<?php echo ($totalscount); ?>人</span></label>
        			<HR width="100%" color=#987cb9 SIZE=1 />
						<table class="table table-hover table-bordered" id="A" >
						<thead>
							<tr>
								<th style="text-align: center;width: 50px;">ID</th>
								<th style="text-align: center;width: 100px;">成为时间</th>
								<th style="text-align: center;width: 100px;">姓名</th>
								<th style="text-align: center;width: 100px;">年龄</th>
								<th style="text-align: center;width: 100px;">年级</th>
								<th style="text-align: center;width: 100px;">性别</th>
								<th style="text-align: center;width: 100px;">学校</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($slist)): foreach($slist as $key=>$vo): ?><tr>
								<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
								<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
								<td style="text-align: center;"><?php echo ($vo["nicename"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["age"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["classname"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["sex"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["schoolname"]); ?></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-content">
				    <div class="control-group">
					<label class="control-label" style="font-weight: bold"><span><a>TA的教师</a></span></label>
        			<HR width="100%" color=#987cb9 SIZE=1 />
						<table class="table table-hover table-bordered" id="A" >
						<thead>
							<tr>
								<th style="text-align: center;width: 50px;">ID</th>
								<th style="text-align: center;width: 100px;">成为时间</th>
								<th style="text-align: center;width: 100px;">姓名</th>
								<th style="text-align: center;width: 100px;">电话</th>
								<th style="text-align: center;width: 100px;">学科</th>
								<th style="text-align: center;width: 100px;">职称</th>
								<th style="text-align: center;width: 100px;">当前学校</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($tlist)): foreach($tlist as $key=>$vo): ?><tr>
								<td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
								<td style="text-align: center;"><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
								<td style="text-align: center;"><?php echo ($vo["nicename"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["mobile"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["xueke"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["title"]); ?></td>
								<td style="text-align: center;"><?php echo ($vo["schoolname"]); ?></td>
							</tr><?php endforeach; endif; ?>
						</tbody>
					</table>
				
				</div>
			</div><?php endif; ?>
		</form>
	</div>
	<div class="row-fluid12">
		<div style="text-align: center;"><span id="reason">驳回原因</span></div>
		<div><textarea name="content" id="content" style="width: 95%;height: 100px;margin-top: 8px;"></textarea></div>
		<div><input type="button" class="btn btn-primary" style="margin-left: 50px;margin-top: 5px;background-color: #bfc6cb;" onclick="close_div()" value="取消"/>
			 <input type="button" class="btn btn-primary" onclick="addconfirm(<?php echo ($info["id"]); ?>)" style="float: right;margin-right: 50px;margin-top: 5px;background-color: #bfc6cb;" value="确定"/></div>
	</div>
	<div class="row-fluid123">
		<div style="text-align: center;margin-top: 50px;"><span>审核通过后，该教师可以在平台发布信息~</span></div>
		<div style="height: 65px;"></div>
		<div><input type="button" class="btn btn-primary" style="margin-left: 50px;margin-top: 5px;background-color: #bfc6cb;" onclick="close_div2()" value="取消"/>
			 <input type="button" class="btn btn-primary" onclick="addconfirm2(<?php echo ($info["id"]); ?>)" style="float: right;margin-right: 50px;margin-top: 5px;background-color: #bfc6cb;" value="确定"/></div>
	</div>
	<div id="bg" onclick="close_div()"></div>
	<script src="/public/js/common.js"></script>
	<script src="/public/js/vue.js"></script>
	<script src="/public/js/content_addtop.js"></script>
	<script src="/public/js/define_my.js"></script>
	<script src="/public/js/artDialog/artDialog.js"></script>
	<script>
		var app = new Vue({
			el:"#app",
			data:{
				info:{},				
			},
			created:function () {
			},
			methods:{
				add2:function (id) {
					close_div2();	
				  // $.dialog({id: 'popup', lock: true,icon:"question", content: "审核通过后，该教师可以在平台发布信息~",cancel: true, ok: function () {
                    $.getJSON("<?php echo U('donechange');?>",{id:id},function (data) {
                        $.dialog({id: 'popup', lock: true, content: data.msg, time: 2});
                        if(data.status == 1){
                            setInterval(function(){
									location.href='<?php echo U("Teacher/index");?>';
								},3000)
                        }
                    })
                 // }})
				},
				add:function (id,content) {	
				    close_div();
                    $.getJSON("<?php echo U('donechange2');?>",{id:id,content:content},function (data) {
                        $.dialog({id: 'popup', lock: true, content: data.msg, time: 2});
                        if(data.status == 1){
                            setInterval(function(){
									location.href='<?php echo U("Teacher/index");?>';
								},3000)
                        }
                    })                  
				}
			}
		});	
	function close_div() {
        $('.row-fluid12').css('display','none');
        $('#bg').css('display','none');
    }
    function close_div2() {
        $('.row-fluid123').css('display','none');
        $('#bg').css('display','none');
    }
    function showadd(id)
    {
    	$("#bg").css('display','block');			       
        $('.row-fluid12').css('display','block');
        $('.row-fluid12').css('position','fixed');
        $('.row-fluid12').css('height','200px');
    }
    function showadd2(id)
    {
    	$("#bg").css('display','block');			       
        $('.row-fluid123').css('display','block');
        $('.row-fluid123').css('position','fixed');
        $('.row-fluid123').css('height','200px');
    }
    function addconfirm(id)
    {
    	var content =$("#content").val();
	    if(content == '')
	    {
	    	$("#reason").text('请填写驳回原因');
	    	return false;
	    }
	    app.add(id,content);
    }
    function addconfirm2(id)
    {
	    app.add2(id);
    }
	</script>
</body>
</html>