<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
	    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>教师推广码</title>
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/jquery-weui.css" />
		<link rel="stylesheet" href="/public/chhelp2/lib/weui/weui.min.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/public.css" />
		<link rel="stylesheet" href="/public/chhelp2/css/style.css" />
		<script type="text/javascript" src="/public/chhelp2/lib/jq/jquery-1.10.2.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/lib/weui/jquery-weui.js" ></script>
		<script type="text/javascript" src="/public/chhelp2/js/common.js" ></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	</head>
	<body>		
		<section class="stuTuiSec">
			
			<div class="ewmImg">
				<img src="<?php echo ($codeimg); ?>" alt="img" style="width:100%" />
			</div>
			<p>请让教师扫此码进行注册</p>
			
			<!--<p style="margin-top:20px;font-size:17px;">很遗憾，您暂时没有推广权限</p>-->
			
		</section>		
	</body>
</html>
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
			"onMenuShareTimeline",
          "onMenuShareAppMessage",
          "onMenuShareQQ",
          "onMenuShareWeibo"
        ]
    });
	// 4. 通过ready接口处理成功验证
    wx.ready(function () {
        //微信分享到朋友圈
        wx.onMenuShareTimeline({
            title: '问学帮', // 分享标题
            link: "<?php echo ($codeurl); ?>", // 分享链接,将当前登录用户转为 puid,以便于发展下线
            imgUrl: '<?php echo ($codeimg); ?>', // 分享图标
            success: function () {
              // 用户确认分享后执行的回调函数
            },
            cancel: function () {
              // 用户取消分享后执行的回调函数
            }
          });
          wx.error(function(res){
            // config 信息验证失败会执行 error 函数，如签名过期导致验证失败，具体错误信息可以打开 config 的 debug 模式查看，也可以在返回的 res 参数中查看，对于 SPA 可以在这里更新签名。
            alert("errorMSG:"+res);
          });
        //微信分享给朋友
        wx.onMenuShareAppMessage({  
			title:'问学帮', // 分享标题  
            desc: '', // 分享描述  
            link: "<?php echo ($codeurl); ?>", // 分享链接  
            imgUrl: '<?php echo ($codeimg); ?>', // 分享图标  
            type: '', // 分享类型,music、video或link，不填默认为link  
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空  
            success: function () {   
                // 用户确认分享后执行的回调函数  
            },  
            cancel: function () {   
                // 用户取消分享后执行的回调函数  
            }  
        });  
        // weixin.wxShareWeibo(); //微信分享到微博
        // weixin.wxShareQQ(); //微信分享到QQ
    });

    // 5. 通过error接口处理失败验证
    wx.error(function (res) {
        //alert(JSON.stringify(res));
        //alert("微信接口验证失败!查看是否配置url");
    });
})
</script>