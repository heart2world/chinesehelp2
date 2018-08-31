<?php
/**
 * 微信授权登录
 */
namespace Home\Controller;
use Think\Controller;
class WexinController extends Controller {
    const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	
    const TOKEN = "weixin";
    public function get_user()
    {
        $wechatObj = new \Think\WeChat(self::APPID,self::APPSECRET,self::TOKEN);
        $code=$_GET['code'];
        $openidarr=$wechatObj->get_snsapi_base($code);
        
        if($openidarr['scope']=='snsapi_base'){
            dump($openidarr['openid']);
        }
        $access_token=$openidarr['access_token'];
        $openid=$openidarr['openid'];
                
        if($openidarr['scope']=='snsapi_userinfo'){           
            $info=$wechatObj->get_snsapi_userinfo($access_token, $openid); 
        }   
        $userinfo = M('member')->where("openid = '" . $info['openid'] . "'")->find();		
        if($userinfo)
        {
            $_SESSION['student'] =$userinfo;
            redirect('./');
        }
        else
        {             
            $_SESSION['student']['openid'] =$info['openid']; 
			$_SESSION['student']['headimg'] =$info['headimgurl'];   			
            redirect(U('Home/Public/login',array('parentid'=>intval($_GET['parentid']))));exit();
        }        
    }
}