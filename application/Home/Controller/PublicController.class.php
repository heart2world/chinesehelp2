<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
/**
 * 登录注册
 */
class PublicController extends Controller {
	
    public function login(){    	
		
		$parentid=I('parentid','0','intval');
		$this->assign('agentid',$parentid);
    	$this->display();
    }
    function dologin()
    {
    	if(IS_POST)
    	{
    		$pdata =I('post.');
    		$pdata['addtime'] =time();
    		$pdata['openid'] =$_SESSION['student']['openid'];
            $pdata['headimg'] =$_SESSION['student']['headimg'];
			$pdata['agentid']=$pdata['agentid'];
    		$pdata['user_status']=1;
    		$result=M('member')->add($pdata);
    		if($result)
    		{
    			$_SESSION['student'] =$pdata;
    			$_SESSION['student']['id'] =$result;
    			$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Index/index')));
    		}else
    		{
    			$this->ajaxReturn(array('status'=>0,'msg'=>'资料保存失败'));
    		}
    	}
    }
}