<?php
/**
 * 微信授权登录
 */
namespace User\Controller;
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
        $userinfo =M('teacher')->where("openid='".$info['openid']."'")->find();
		if(empty($userinfo))
		{
			$data=array(
				'nicename' => '',
				'mobile' =>'',
				'openid' =>$info['openid'],
				'headimg' =>$info['headimgurl'],
				'addtime' => time(),
				'parentid' =>intval($_GET['parentid']),
				'tyear'   =>date('Y').'-09',
				'password' => sp_password(time()),
				'status' => 0,
			);			
			$result = M('teacher')->add($data);
			$data['id']= $result;
			$_SESSION['user'] = $data;
			redirect(U('User/Center/addmobile'));exit();
		}else
		{
			$_SESSION['user'] =$userinfo;
			if(empty($userinfo['mobile']))
			{
				redirect(U('User/Center/addmobile'));exit();
			}else if(empty($userinfo['nicename']))
			{
				redirect(U('User/Center/apply'));exit();
			}else
			{
				redirect(U('Portal/index/index'));exit();
			}
			
		}     
    }
	public function get_user2()
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
              
		$_SESSION['user']['openid'] =$info['openid']; 
		$_SESSION['user']['headimg'] =$info['headimgurl'];  
		M('teacher')->where("id='".$_SESSION['user']['id']."'")->save(array('headimg'=>$info['headimgurl'],'openid'=>$info['openid']));
		redirect(U('User/center/index'));exit();
                
    }
	
}