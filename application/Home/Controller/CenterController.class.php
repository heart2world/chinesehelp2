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
 * 首页
 */
class CenterController extends Controller {
	
	const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';	 
	
    public function index(){
    	$this->checklogin();
    	$this->checkuser();
    	$member =M('member')->where("id='".$_SESSION['student']['id']."'")->find();
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID,self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
    	$this->assign('member',$member);
		
		// 我的提问或追问被老师回答时。
		$qcount=M('question')->where("userid='".$_SESSION['student']['id']."' and isread=0 and isdo=1")->count();
		
    	$this->assign('qcount',$qcount);
		$this->display();
    }
    // 收藏
    public function myfavar()
    {
        //教师
		$this->checklogin();
    	$this->checkuser();
        $collectt=D()->field("t.*")->table(C('DB_PREFIX')."teacher t,".C('DB_PREFIX')."collect_task c")->where("c.userid='".$_SESSION['student']['id']."' and c.type='教师' and c.taskid=t.id")->group('c.rec_id')->order('c.addtime desc')->select();
        foreach ($collectt as $k => $val) {
            $collectt[$k]['qcount'] = M('answer')->where("teacherid='".$val['id']."'")->count();
            $collectt[$k]['colcount'] = M('collect_task')->where("taskid='".$val['id']."' and type='教师'")->count();
            $info =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$val['id']."' and isend=1")->find();
            $collectt[$k]['star'] = number_format($info['star'],1);
        }
        $this->assign("collectt", $collectt);
        // 资源/微课
        $collectelse =D()->field("t.*")->table(C('DB_PREFIX')."task t,".C('DB_PREFIX')."collect_task c")->where("c.userid='".$_SESSION['student']['id']."' and (c.type='微课' or c.type='资源') and c.taskid=t.id")->group('c.rec_id')->order('c.addtime desc')->select();
        //file_put_contents('a222.txt',D()->getLastSql());
		foreach ($collectelse as $key => $value) {
			if($value['userid'] == 0)
			{
				 $collectelse[$key]['headimg'] ='http://'.$_SERVER['HTTP_HOST'].'/data/upload/logo.png';
				 $collectelse[$key]['nicename'] ='文学帮官方';
				 $collectelse[$key]['questiontype'] ='暂无';
			}else
			{
				$minfo =M('teacher')->where("id='".$value['userid']."'")->find();
				$collectelse[$key]['nicename'] =$minfo['nicename'];
				$collectelse[$key]['headimg'] =$minfo['headimg'];
				$collectelse[$key]['questiontype'] =$minfo['questiontype'];
			}
			
            if($value['type'] == '微课')
            {
                $collectelse[$key]['colcount'] = M('collect_task')->where("taskid='".$value['id']."' and type='微课'")->count();
            }else
            {
                $collectelse[$key]['colcount'] = M('collect_task')->where("taskid='".$value['id']."' and type='资源'")->count();
            }            
        }
        //问答
        $collectqs =D()->field("t.*")->table(C('DB_PREFIX')."question t,".C('DB_PREFIX')."collect_task c")->where("c.userid='".$_SESSION['student']['id']."' and c.type ='问答' and c.taskid=t.id")->group('c.rec_id')->order('c.addtime desc')->select();
        foreach ($collectqs as $key => $value) {
            $minfo =M('member')->where("id='".$value['userid']."'")->find();
			$collectqs[$key]['nicename'] =$minfo['nicename'];
			$collectqs[$key]['headimg'] =$minfo['headimg'];
            $collectqs[$key]['colcount'] = M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
                        
        }
		$collectzt =D()->field("t.*")->table(C('DB_PREFIX')."zhuantis t,".C('DB_PREFIX')."collect_task c")->where("c.userid='".$_SESSION['student']['id']."' and c.type ='专题' and c.taskid=t.id")->group('c.rec_id')->order('c.addtime desc')->select();
        foreach ($collectzt as $key => $value) {
            $minfo =M('teacher')->where("id='".$value['teacherid']."'")->find();
			$collectzt[$key]['nicename'] =$minfo['nicename'];
			$collectzt[$key]['headimg'] =$minfo['headimg'];
			$collectzt[$key]['questiontype'] =$minfo['questiontype'];
            $collectzt[$key]['colcount'] = M('collect_task')->where("taskid='".$value['id']."' and type='专题'")->count();
                        
        }
        $this->assign("collectzt", $collectzt);
		$this->assign("collectqs", $collectqs);
        $this->assign("collectelse", $collectelse);
		
        $this->display();
    }
	// 问答收藏取消操作
	function collect()
	{
		if(IS_POST)
		{
			$taskid =I('taskid','','intval');
			$type =I('type','','intval');
			$typename =I('typename','','trim');
			if($type ==1)// 加入收藏
			{
				$data['userid'] =$_SESSION['student']['id'];
				$data['taskid'] =$taskid;
				$data['addtime'] =time();
				$data['type'] =$typename;
				$count=M('collect_task')->where("userid='".$data['userid']."' and taskid='$taskid'")->count();
				if($count > 0)
				{
					$this->ajaxReturn(array('status'=>0));
				}
				$res =M('collect_task')->add($data); 
				if($res)
				{
					$collectnum=M('collect_task')->where("taskid='$taskid' and type='$typename'")->count();
					$this->ajaxReturn(array('status'=>1,'collectnum'=>$collectnum,'typename'=>$typename));
				}
			}else//取消收藏
			{
				$res =M('collect_task')->where("type='$typename' and taskid='$taskid' and userid ='".$_SESSION['student']['id']."'")->delete();
				
				if($res)
				{
					$collectnum=M('collect_task')->where("taskid='$taskid' and type='$typename'")->count();
					$this->ajaxReturn(array('status'=>1,'collectnum'=>$collectnum,'typename'=>$typename));
				}
			}
		}
	}
	// 上传图片
	function getimgpost()
	{
		if(IS_POST)
		{
			$access_token=I('access_token','','trim');
			$media_id=I('media_id','','trim');
			$url ="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;			
			$urldemo =file_get_contents($url);
			
			if($urldemo)
			{
				 $imgurl = "./data/upload/images/".date('Ymd').rand(10000,99999).".jpg";
				
				 $resource = fopen($imgurl, 'w+');  
				 //将图片内容写入上述新建的文件  
				 fwrite($resource, $urldemo);  
				 //关闭资源  
				 fclose($resource);  
				 $strimgurl ='http://'.$_SERVER['HTTP_HOST'].'/'.$imgurl;	
				 M('member')->where("id='".$_SESSION['student']['id']."'")->save(array('headimg'=>$strimgurl));
				 $this->ajaxReturn(array('status'=>1,'imgurl'=>$imgurl,'strimgurl'=>$strimgurl));
			}else{
				$this->ajaxReturn(array('status'=>0));
			}
		}
	}
    // 我的提问
    public function mypub()
    {
		$this->checklogin();
    	$this->checkuser();
        $qlist =M('question')->where("userid='".$_SESSION['student']['id']."' and parentid=0 and type=0")->order("addtime desc")->select();
        foreach ($qlist as $key => $value) {
            $qlist[$key]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
			
        }
		$qqlist =M('question')->where("userid='".$_SESSION['student']['id']."' and isdo=1 and isread=0")->order("addtime desc")->select();
		foreach ($qqlist as $k=>$v)
		{
			M('question')->where("id='".$v['id']."'")->setField('isread',1);
		}
        $this->assign('qlist',  $qlist);
        $this->display();
    }
    // 消费记录
    public function consume_note()
    {
		$this->checklogin();
    	$this->checkuser();
        $order =M('orders')->where("userid='".$_SESSION['student']['id']."' and orderstatus=1")->order('addtime desc')->select();
        $this->assign('order', $order);
        $this->display();
    }
    public function setting_profile()
    {
		$this->checklogin();
    	$this->checkuser();
    	$member =M('member')->where("id='".$_SESSION['student']['id']."'")->find();
    	$this->assign('member',$member);
    	$this->display();
    }
    function doedit()
    {
    	if(IS_POST)
    	{
    		$pdata=I('post.');
    		M('member')->where("id='".$pdata['id']."'")->save($pdata);
			M('question')->where("userid='".$pdata['id']."'")->save(array('nicename'=>$pdata['nicename']));
			M('orders')->where("userid='".$pdata['id']."'")->save(array('username'=>$pdata['nicename']));
    		$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Center/index')));
    	}
    }
    //-------函数部分--------------------------------------------//
    function checklogin()
    {
    	$session_user=session('student');
    	if(empty($session_user['id']))
    	{
    		redirect(U('Home/Public/login'));
    	}
    	
    }
    function checkuser()
    {
		header("Content-type: text/html; charset=utf-8");  
    	$user_status=M('member')->where(array("id"=>session('student.id')))->getField("user_status");
    	if($user_status==0){
			echo '<center style="font-size:40px;padding:10px;">您的账户被冻结，请联系管理员！</center>';
			exit;
		}
    }
}
?>