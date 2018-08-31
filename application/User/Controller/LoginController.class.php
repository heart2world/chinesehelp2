<?php
namespace User\Controller;

use Common\Controller\HomebaseController;

class LoginController extends HomebaseController {
	const APPID = 'wx34dd37f9256128a8';
	
    // 前台用户登录
	public function index(){
	    $redirect=I('get.redirect','');
	    if(empty($redirect)){
	        $redirect=$_SERVER['HTTP_REFERER'];
	    }else{
	        $redirect=base64_decode($redirect);
	    }
	    session('login_http_referer',$redirect);
	    
	    if(sp_is_user_login()){ //已经登录时直接跳到首页
	        redirect(U('Portal/index/index'));
	    }else{
			$parentid=I('parentid','0','intval');
			// 微信授权
			if(!$_SESSION['user']['openid'])
			{
				
			  $str=urlencode('http://'.$_SERVER['HTTP_HOST'].'/index.php?g=User&m=Wexin&a=get_user&parentid='.$parentid);
			  $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.self::APPID.'&redirect_uri='.$str.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
			  header("location:$url");
			}
	    }
	}
	
}