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
<style>
    .row-fluid{
        display:none;position: absolute;  top: 50%;border-radius: 3px;  left: 28%; width: 44%; overflow:hidden; overflow-y: auto;  padding: 8px;  border: 1px solid #E8E9F7;  background-color: white;  z-index:10003;
    }
    #bg{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background-color: black;  z-index:1001;  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);}

    .table tr th,.table tr td{
        text-align: center;
    }
    .add-btn{
        margin-left: 22px;
    }
    

</style>
<body>
	<div class="wrap" id="app">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('teacher/index');?>">教师管理</a></li>
			<li class="active"><a>编辑教师</a></li>
		</ul>
		<form class="form-horizontal" id="tagforms" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group">
					<label class="control-label">姓名：</label>
					<div class="controls">
						<input type="text" name="nicename" value="<?php echo ($info["nicename"]); ?>">
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">教龄：</label>
					<div class="controls">
						<input type="number" name="seniority" min="0" value="<?php echo ($info["seniority"]); ?>">
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">账号：</label>
					<div class="controls">
						<input type="text" name="mobile" maxlength="11" value="<?php echo ($info["mobile"]); ?>">
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">学科：</label>
					<div class="controls">
						<select name="xueke" onchange="selectxueke(this.value)">
							<option value="">选择学科</opiton>
							<?php if(is_array($xuekelist)): $i = 0; $__LIST__ = $xuekelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["title"]); ?>" <?php if($info['xueke'] == $va['title']): ?>selected<?php endif; ?>><?php echo ($va["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">职称：</label>
					<div class="controls">
						<select name="title">
							<option value="">选择职称</opiton>
							<option value="初级教师" <?php if($info['title'] == '初级教师'): ?>selected<?php endif; ?>>初级教师</option>
							<option value="中级教师" <?php if($info['title'] == '中级教师'): ?>selected<?php endif; ?>>中级教师</option>
							<option value="高级教师" <?php if($info['title'] == '高级教师'): ?>selected<?php endif; ?>>高级教师</option>
							<option value="特级教师" <?php if($info['title'] == '特级教师'): ?>selected<?php endif; ?>>特级教师</option>
							<option value="研究员" <?php if($info['title'] == '研究员'): ?>selected<?php endif; ?>>研究员</option>
						</select>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">学校：</label>
					<div class="controls">
						<select name="schoolname">
							<option value="">请选择学校</option>
							<option value="区、县级普通中学" <?php if($info['schoolname'] == '区、县级普通中学'): ?>selected<?php endif; ?>>区、县级普通中学</option>
							<option value="区、县级重点中学" <?php if($info['schoolname'] == '区、县级重点中学'): ?>selected<?php endif; ?>>区、县级重点中学</option>
							<option value="市级重点中学" <?php if($info['schoolname'] == '市级重点中学'): ?>selected<?php endif; ?>>市级重点中学</option>
						</select>
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">职称照片：</label>
					<div class="controls">
						<input type="hidden" name="titleimg" id="thumb" value="<?php echo ($info["titleimg"]); ?>">
						<a href="javascript:upload_one_image('图片上传','#thumb');">
							<?php if($info['titleimg'] != ''): ?><img src="<?php echo ($info["titleimg"]); ?>" id="thumb-preview" width="120"style="cursor: hand" />
							<?php else: ?>							
							<img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" id="thumb-preview" width="100" height="100" style="cursor: hand" /><?php endif; ?>
						</a>
						<input type="button" class="btn btn-small" onclick="$('#thumb-preview').attr('src','/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png');$('#thumb').val('');return false;" value="取消图片">
					</div><br/>
					<div style="margin-left: 180px;color: red;">建议图片尺寸：600*400</div>
				</div>		
				<div class="control-group">
					<label class="control-label">擅长题型：</label>
					<div class="controls" id="tixinglist">						
						<?php if(is_array($qtypelist)): $key = 0; $__LIST__ = $qtypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($key % 2 );++$key;?><input type="checkbox" name="questiontype[]" value="<?php echo ($va["typename"]); ?>" <?php if($va['isdo'] == 1): ?>checked<?php endif; ?>><span><?php echo ($va["typename"]); ?>&nbsp;</span><?php if($key%4 == 0): ?><br/><?php endif; endforeach; endif; else: echo "" ;endif; ?>						
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label">所获荣誉：</label>
					<div class="controls">
						<?php if(is_array($htypelist)): $key = 0; $__LIST__ = $htypelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($key % 2 );++$key;?><input type="checkbox" name="honors[]" value="<?php echo ($va["typename"]); ?>" <?php if($va['isdo'] == 1): ?>checked<?php endif; ?>><span><?php echo ($va["typename"]); ?>&nbsp;</span><?php if($key%4 == 0): ?><br/><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>		
				<div class="control-group">
					<label class="control-label">TA的代理：</label>
					<div class="controls">
						<input type="text" readonly id="teachername" maxlength="20" value="<?php echo ($info["parentname"]); ?>">
						<a class="btn changeeidt" onclick="show_div()" style="background-color:#1abc9c;">修改</a>
						<?php if($info['parentid'] > 0): ?><a class="btn changeeidt" onclick="delparent()" style="background-color:#1abc9c;">删除上级</a><?php endif; ?>
					</div>
				</div>
				<div class="control-group" id="category-list">	
					<div class="row-fluid" style="display: none">
						<div><center style="font-size: 18px;margin-bottom: 10px;">选择教师</center></div>
						<div style="margin-bottom: 10px">
							<input type="text" placeholder="输入教师姓名/电话" id="keyword" >
							<input type="button"  class="btn" id="search" style="background-color:#1abc9c;" value="搜索">
						</div>
						<div style="height: 450px;overflow-y: scroll;border-bottom: 1px solid #ccc;">
						<table class="table table-bordered" width="100%">
							<th>选择</th>
							<th>姓名</th>
							<th>电话</th>								
							<tbody id="list-box">
							</tbody>
						</table>
						</div>
						<div style="text-align: center;margin-top: 10px;">
							<a href="javascript:;" class="btn btn-primary" onclick="close_div()">取消</a>&nbsp;&nbsp;&nbsp;
							<a href="javascript:;" class="btn btn-primary" onclick="eachSelect()">确认</a>
						</div>
						<div class="row" id="page-info">
						</div>
					</div>
					<input type="hidden" name="agentid" id="good_ids" value="<?php echo ($info["parentid"]); ?>">
				</div>
				<div class="control-group">
					<label class="control-label">开启代理权限：</label>
					<div class="controls">
						
						<label><input type="radio" name="isdaili" value="1" <?php if($info['isdaili'] == 1): ?>checked<?php endif; ?>><span>已开启</span>
						<input type="radio" name="isdaili" value="0" <?php if($info['isdaili'] == 0): ?>checked<?php endif; ?>><span>未开启</span></label>
						
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<input type="hidden" name="id" id="nowteacher" value="<?php echo ($info["id"]); ?>">
				<input type="hidden" name="oldmobile" value="<?php echo ($info["mobile"]); ?>">
				<input type="button" @click="add()" class="btn btn-primary" value="保存"/>
				<a class="btn" href="javascript:history.back(-1);"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<div id="bg" onclick="close_div()"></div>
	<script src="/public/js/common.js"></script>
	<script src="/public/js/vue.js"></script>
	<script src="/public/js/content_addtop.js"></script>
	<script src="/public/js/define_my.js"></script>
	<script src="/public/js/artDialog/artDialog.js"></script>
	<script>
	var goods_ids =$("#good_ids").val();
	var nowteacher =$("#nowteacher").val();
	function close_div() {
        $('.row-fluid').css('display','none');
        $('#bg').css('display','none');
    }
	function delparent()
	{
		$("#good_ids").val(0);
		$("#teachername").val('');
	}
    function eachSelect(){           
	    check_val='';
        var name_str='';
        $("input[name=userid]").each(function(){
            if($(this).is(':checked')){
                var g_name= $(this).parents().siblings("td").eq(0).html();
                var id=$(this).val();
                check_val=id;
                name_str=g_name;
            }
        });
        console.log(check_val);
        $('#good_ids').val(check_val);
        $('#teachername').val(name_str);
        $("#bg").css('display','none');
        $('.row-fluid').css('display','none');
        return check_val;
    }
	function show_div() {
        $("#bg").css('display','block');
        $('#qg_check').css('display','none');
        $('.row-fluid').css('display','block');
        var keyword =$("#keyword").val();
		$.ajax({
			url:'<?php echo U("Teacher/getteachers");?>',
			data:{keyword:keyword,nowteacher:nowteacher},
			type:"POST",
			dataType:"json",
			success:function (arr) {
				var str = '';
				data = arr.list;
				for(var o in data) {
					var is_check=goods_ids==data[o].value ? 'checked':'';
					str+="<tr><td><input type=\"radio\" name=\"userid\" "+is_check+" value="+data[o].value+"></td><td>"+data[o].text+"</td><td>"+data[o].text1+"</td></tr>";
				}
				document.getElementById('list-box').innerHTML=str;
			}
		})
    }
	$(function () {       
        $('#search').click(function () {
            var keyword =$("#keyword").val();
			$.ajax({
				url:'<?php echo U("Teacher/getteachers");?>',
				data:{keyword:keyword,nowteacher:nowteacher},
				type:"POST",
				dataType:"json",
				success:function (arr) {
					var str = '';
					data = arr.list;
					for(var o in data) {
						var is_check=goods_ids==data[o].value ? 'checked':'';
						str+="<tr><td><input type=\"radio\" name=\"userid\" "+is_check+" value="+data[o].value+"></td><td>"+data[o].text+"</td><td>"+data[o].text1+"</td></tr>";
					}
					document.getElementById('list-box').innerHTML=str;
				}
			})
        });

    });
	</script>
	<script>
		function selectxueke(obj)
		{
			$.ajax({
				url:'<?php echo U("Teacher/gettixinglist");?>',
				data:{keyword:obj},
				type:"POST",
				dataType:"json",
				success:function (arr) {
					
					document.getElementById('tixinglist').innerHTML=arr.html;
				}
			})
		}
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
						url:'<?php echo U("Teacher/edit_post");?>',
						data:tagvals,
						type:"POST",
						dataType:"json",
						success:function (res) {							
							if(res.status==0){
								$.dialog({id: 'popup', lock: true,icon:"succeed", content: res.msg, time: 2});
								setInterval(function(){
									location.href='<?php echo U("Teacher/index");?>';
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