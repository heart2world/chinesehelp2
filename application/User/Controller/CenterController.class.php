<?php
namespace User\Controller;

use Common\Controller\MemberbaseController;

class CenterController extends MemberbaseController {
	protected $payurl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    protected $appid = 'wx34dd37f9256128a8'; //appid
    protected $mchid = '1499636962';
	protected $appsecret ='05adb450c3107e9646b65a97c58742b5';
    protected $signkey ='ywbsd8DGFi8e4osdfg0234moldfgwsed';//支付密钥
	const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	
    //这里的路径很重要  一定要写相对路径
    protected $cacab =  array(
        'api_cert'=>'./data/xinlianyu/apiclient_cert.pem',	
        'api_key'=>'./data/xinlianyu/apiclient_key.pem',
        'api_ca'=>'./data/xinlianyu/rootca.pem'
    );
	function _initialize(){
		parent::_initialize();
	}
	
    // 会员中心首页
	public function index() {
		$uinfo =$this->user;	
		$uuinfo =M('teacher')->field('id,isdaili')->where("id='".$uinfo['id']."'")->find();		
		$this->assign('isdaili',$uuinfo['isdaili']);
    	$this->assign($uinfo);
    	if($uinfo['status'] != 1)
    	{
    		redirect(U('User/Center/apply'));
    	}		
    	// 未读消息记录
    	$msgcount = M('message')->where("teacherid='".$uinfo['id']."' and isread=0")->count();
    	$this->assign('msgcount',$msgcount);
    	// 最新收入记录
    	$ordercount = M('orders')->where("teacherid='".$uinfo['id']."' and isread=0 and orderstatus=1")->count();
    	$this->assign('ordercount',$ordercount);
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID,self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
    	$this->display(':center');
    }
    // 认证资料
    public function certify_info()
    {
    	$uinfo =$this->user;
    	if(!empty($uinfo['titleimg']))
    	{
			if(strpos($uinfo['titleimg'],'http://')===false)
			{
				$uinfo['titleimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$uinfo['titleimg'];
			}else{
				$uinfo['titleimg'] =$uinfo['titleimg'];
			}	
    	}
    	if(!empty($uinfo['cardimg']))
    	{
    		if(strpos($uinfo['cardimg'],'http://')===false)
			{
				$uinfo['cardimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$uinfo['cardimg'];
			}else{
				$uinfo['cardimg'] =$uinfo['cardimg'];
			}	
    	}
    	$this->assign($uinfo);
    	$this->display(':certify_info');
    }
	// 我的学生
	public function mystudent()
	{
		// 当前教师的下线学生总人数
		$uinfo =$this->user;
		$count = M('member')->where("agentid='".$uinfo['id']."'")->count();
		
		$optionvalue = M('options')->where("option_name='caiwu_settings'")->getField('option_value');
		$option =json_decode($optionvalue,true);
		
		$this->assign('option',$option);
		$this->assign('count',$count);
		$this->display(':mystudent');
	}
	// 学生推广码
	public function scode()
	{
		$uinfo =$this->user;
		$codeimg=M('teacher')->where("id='".$uinfo['id']."'")->getField('scode');
        if(empty($codeimg))
        {
            $url ='http://'.$_SERVER['HTTP_HOST'].U('Home/Index/index',array('parentid'=>$uinfo['id']));
            $codeimg= qr_show($url);
            M('teacher')->where("id='".$uinfo['id']."'")->save(array('scode'=>$codeimg));
        }else
        {
            $codeimg ='http://'.$_SERVER['HTTP_HOST'].'/'.$codeimg;            
        }       
        $this->assign('codeimg',$codeimg);
		$this->assign('codeurl',"http://".$_SERVER['HTTP_HOST']."/Portal/Index/share_code/mid/".$uinfo['id']);
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID, self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		$this->display(':scode');
	}
	// 学生列表
	public function studentlist()
	{
		$uinfo =$this->user;
		$list =M('member')->where("agentid='".$uinfo['id']."'")->order('addtime desc')->select();
		$this->assign('list',$list);
		$this->display(':studentlist');
	}
	// 我的教师
	public function myteacher()
	{
		// 当前教师的下线学生总人数
		$uinfo =$this->user;
		$count = M('teacher')->where("parentid='".$uinfo['id']."'")->count();
		$this->assign('count',$count);
		$optionvalue = M('options')->where("option_name='caiwu_settings'")->getField('option_value');
		$option =json_decode($optionvalue,true);
		
		$this->assign('option',$option);
		$this->display(':myteacher');
	}
	// 教师推广码
	public function tcode()
	{
		$uinfo =$this->user;
		$uuinfo =M('teacher')->field('id,isdaili')->where("id='".$uinfo['id']."'")->find();
		$codeimg=M('teacher')->where("id='".$uinfo['id']."'")->getField('tcode');
        if(empty($codeimg))
        {
            $url ='http://'.$_SERVER['HTTP_HOST'].U('User/Login/index',array('parentid'=>$uinfo['id']));
            $codeimg= qr_show($url);
            M('teacher')->where("id='".$uinfo['id']."'")->save(array('tcode'=>$codeimg));
        }else
        {
            $codeimg ='http://'.$_SERVER['HTTP_HOST'].'/'.$codeimg;            
        }       
        $this->assign('codeimg',$codeimg);
		$this->assign('codeurl',"http://".$_SERVER['HTTP_HOST']."/Portal/Index/teacher_code/mid/".$uinfo['id']);
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID, self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		$this->assign('uuinfo',$uuinfo);
		$this->display(':tcode');
	}
	// 学生列表
	public function teacherlist()
	{
		$uinfo =$this->user;
		$list =M('teacher')->where("parentid='".$uinfo['id']."'")->select();
		$this->assign('list',$list);
		$this->display(':teacherlist');
	}
	// 绑定手机号
	public function addmobile()
	{
		$this->display(':addmobile');
	}
	function dologinmobile()
	{
		if(IS_POST)
		{
			$mobile=I('post.mobile');
			if(!check_send_code($mobile,trim($_POST['yzcode']))){
				$this->ajaxReturn(['status'=>1,'msg'=>'短信验证码错误']);
			}        
			
			$users_model=M("teacher");
			$count =$users_model->where("mobile='$mobile'")->count();
			if($count >0)
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'该手机号已注册'));
			}
			else
			{
				$_SESSION['user']['mobile'] = $mobile;
				$result=$users_model->where("id='".$_SESSION['user']['id']."'")->save(array('mobile'=>$mobile));
				$this->ajaxReturn(array('status'=>0,'msg'=>'登录成功','url'=>U('User/Center/index')));
			}
		}
	}
    // 我的收入
    public function myincome()
    {
    	$uinfo =$this->user;
    	$orders =M('orders')->where("teacherid='".$uinfo['id']."' and orderstatus=1")->order('addtime desc')->select();
    	$totalin =M('teacher')->where("id='".$uinfo['id']."' and status=1")->getField('coin');
    	foreach ($orders as $key => $value) {    		
    		M('orders')->where("id='".$value['id']."'")->setField('isread',1);
    	}    	
    	$this->assign('totalin',price_format($totalin,false));    	
    	$this->assign($uinfo);
    	$this->display(':myincome');
    }
    //提现记录
    public function tixianlog()
    {
    	$uinfo =$this->user;
    	$tixianlog =M('tixianlog')->where("teacherid='".$uinfo['id']."' and status=1")->select();
    	$this->assign('tixianlog',$tixianlog);

    	$this->display(':tixianlog');
    }
	// 收入明细
	public function yestixian()
	{
		$uinfo =$this->user;
    	$orders =D()->field('o.id,o.ordersn,o.title,m.type,o.addtime,m.coin')->table(C('DB_PREFIX').'orders o,'.C('DB_PREFIX').'commissionlog m')->where("m.teacherid='".$uinfo['id']."' and o.orderstatus=1 and o.id=m.orderid")->order('addtime desc')->select(); 	
    	
    	$this->assign('orders',$orders);
		$this->display(':yestixian');
	}
	// 提现
	public function tixian()
	{
		$uinfo =$this->user;
    	
    	$totalin =M('teacher')->where("id='".$uinfo['id']."' and status=1")->getField('coin');
  
    	$this->assign('totalin',price_format($totalin,false));
		$this->display(':tixian');
	}
	function gettypeorders()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			if($pdata['starttime'])
			{
				$starttime = $pdata['starttime']/1000;
			}
			if($pdata['endtime'])
			{
				$endtime = $pdata['endtime']/1000;
			}
			$pdata['userid'] =$_SESSION['user']['id'];
			$where='';
			if($pdata['typename'])
			{
				$where.=" and m.type='".$pdata['typename']."'";
			}
			if($pdata['starttime']&&$pdata['endtime'])
			{
				$where.=" and o.addtime>='".$starttime."' and o.addtime <= '".$endtime."'";
			}
			$html='';
			$orders =D()->field('o.id,o.ordersn,o.title,m.type,o.addtime,m.coin')->table(C('DB_PREFIX').'orders o,'.C('DB_PREFIX').'commissionlog m')->where("m.teacherid='".$pdata['userid']."' and o.orderstatus=1 and o.id=m.orderid".$where)->order('addtime desc')->select(); 	
			foreach($orders as $k=>$va)
			{
				$html.="<div class=\"weui-cell\">
						<div class=\"weui-cell__bd\">
							<p>".$va['title']."</p>
							<p style=\"color: #999;\">".date('Y-m-d H:i:s',$va['addtime'])."</p>
						</div>
						<div class=\"weui-cell__ft\">
							<p style=\"font-size: .9em;\">".$va['type']."</p>
							<p style=\"color: #3CC8FE; font-size: .8rem;\">￥".$va['coin']."</p>
						</div>
					</div>";
			}
			$this->ajaxReturn(array('status'=>0,'html'=>$html));
		}
	}
	// 提现操作
	function dotixianlog()
	{
		if(IS_POST)
		{
			
			$price =I('price','','trim');
			$data['price'] = $price;
			$data['teacherid'] = $_SESSION['user']['id'];
			$data['status'] =1;
			$data['addtime'] =time();
			if($price > 0)
			{
				// 判断当前教师是否已体现
				$tinfo =M('teacher')->where("id='".$data['teacherid']."'")->find();
				if($tinfo['coin'] > 0)
				{
					$resid=M('tixianlog')->add($data);
					if($resid)
					{
						$dataa = array(
							'userid' => $_SESSION['user']['id'],       //用户ID   做更新状态使用
							'openid' => $tinfo['openid'],  //$_SESSION['user']['openid']收钱的人微信 OPENID
							'refundid' => $resid,        //退款申请ID
							'money'    => $price,      //金额
							'desc'     => '提现',
						); 
						$res = $this->wxbuild($dataa, '');	
						
						if($res['status'] == '1')
						{
							M('tixianlog')->where("id='$resid'")->delete();
							$this->ajaxReturn(array('status'=>0,'msg'=>'提现失败'));
						}
						else
						{
							// 提现成功
							if($res['result_code']=='SUCCESS')
							{
								// 更新提现订单
								$list=M('orders')->where("orderstatus=1 and logid=0 and teacherid='".$data['teacherid']."'")->select();						
								foreach($list as $k=>$va){
									M('orders')->where("id='".$va['id']."'")->save(array('logid'=>$resid));
								}
								M('teacher')->where("id='".$data['teacherid']."'")->setDec('coin',$price);						
								$this->ajaxReturn(array('status'=>1,'url'=>U('User/center/tixianlog')));
							}else
							{
								M('tixianlog')->where("id='$resid'")->delete();
								$this->ajaxReturn(array('status'=>0));
							}
						}			
						
					}else{
						$this->ajaxReturn(array('status'=>0));
					}
				}else{
					$this->ajaxReturn(array('status'=>0,'msg'=>'您已提现完成，不能重复提现'));
				}
			}else{
				$this->ajaxReturn(array('status'=>0,'msg'=>'您不能提现'));
			}
		}
	}
    // 消息提醒
    public function msg()
    {
    	$uinfo =$this->user;
    	$list =M('message')->where("teacherid='".$uinfo['id']."'")->select();
		
    	foreach ($list as $key => $value) {
    		M('message')->where("id='".$value['id']."'")->setField('isread',1);
    	}
    	$this->assign('list',$list);
		
    	$this->display(':msg');
    }
    public function apply()
    {
    	$uinfo =M('teacher')->where("id='".$_SESSION['user']['id']."'")->find();
		switch ($uinfo['xueke']) {
				case '语文':
					$uinfo['xk'] =1;
					break;
				case '数学':
					$uinfo['xk'] =2;
					break;
				case '英语':
					$uinfo['xk'] =3;
					break;
				case '物理':
					$uinfo['xk'] =4;
					break;
				case '化学':
					$uinfo['xk'] =5;
					break;
				case '政治':
					$uinfo['xk'] =6;
					break;
				case '历史':
					$uinfo['xk'] =7;
					break;
				default:
					$uinfo['xk'] =0;
					break;
			}
    	$this->assign($uinfo);
		
    	if($uinfo['status'] == 1)
    	{
    		redirect(U('Portal/Index/index'));
			exit();
    	}else{			
			// jssdk微信授权获取信息
			$jssdk = new \Think\JSSDK(self::APPID,self::APPSECRET);
			$signPackage = $jssdk->GetSignPackage();
			$this->assign('signPackage',$signPackage);
		}
    	$this->display(':apply');
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
				 M('teacher')->where("id='".$_SESSION['user']['id']."'")->save(array('headimg'=>$strimgurl));
				 $this->ajaxReturn(array('status'=>1,'imgurl'=>$imgurl,'strimgurl'=>$strimgurl));
			}else{
				$this->ajaxReturn(array('status'=>0));
			}
		}
	}
    public function update_pwd()
    {
    	$uinfo =$this->user;
    	$this->assign($uinfo);
    	$this->display(':update_pwd');
    }
    function doapply()
    {	
    	if(IS_POST)
    	{
    		$pdata =I('post.');
    		$pdata['status'] = 0;
    		$pdata['isdo'] =1;
			switch ($pdata['xk']) {
				case '1':
					$pdata['xueke'] ='语文';
					break;
				case '2':
					$pdata['xueke'] ='数学';
					break;
				case '3':
					$pdata['xueke'] ='英语';
					break;
				case '4':
					$pdata['xueke'] ='物理';
					break;
				case '5':
					$pdata['xueke'] ='化学';
					break;
				case '6':
					$pdata['xueke'] ='政治';
					break;
				case '7':
					$pdata['xueke'] ='历史';
					break;
				default:
					# code...
					break;
			}
    		$res=M('teacher')->where("id='".$pdata['userid']."'")->save($pdata);
    		if($res)
    		{
				unset($_SESSION['user']);
				$uinfo =M('teacher')->where("id='".$pdata['userid']."'")->find();
				session('user',$uinfo);
    			$this->ajaxReturn(array('status'=>1));
    		}
    	}
    }
	function gettypedata()
	{
		if(IS_POST)
		{
			$type =I('type','','intval');
			switch ($type) {
				case '1':
					$strdemo =array();				
					$strdemo[0]['title']='中国文化趣谈';
					$strdemo[0]['value']='001';
					$strdemo[1]['title']='西方文化趣谈';
					$strdemo[1]['value']='002';
					$strdemo[2]['title']='基础知识应试技巧';
					$strdemo[2]['value']='003';
					$strdemo[3]['title']='综合性学习应试技巧';
					$strdemo[3]['value']='004';
					$strdemo[4]['title']='记叙文小说应试技巧';
					$strdemo[4]['value']='005';
					$strdemo[5]['title']='说明文应试技巧';
					$strdemo[5]['value']='006';
					$strdemo[6]['title']='议论文应试技巧';
					$strdemo[6]['value']='007';
					$strdemo[7]['title']='作文应试技巧';
					$strdemo[7]['value']='008';
					$strdemo[8]['title']='课内现代文导读';
					$strdemo[8]['value']='009';
					$strdemo[9]['title']='课内古诗文导读';
					$strdemo[9]['value']='010';
					$strdemo[10]['title']='课外阅读指南';
					$strdemo[10]['value']='011';
					$strdemo[11]['title']='学科渗透及其他';
					$strdemo[11]['value']='012';
					break;
				case '2':
					$strdemo =array();				
					$strdemo[0]['title']='实数';
					$strdemo[0]['value']='101';
					$strdemo[1]['title']='代数';
					$strdemo[1]['value']='102';
					$strdemo[2]['title']='整式';
					$strdemo[2]['value']='103';
					$strdemo[3]['title']='分式';
					$strdemo[3]['value']='104';
					$strdemo[4]['title']='方程（组）与不等式';
					$strdemo[4]['value']='105';
					$strdemo[5]['title']='变量与函数';
					$strdemo[5]['value']='106';
					$strdemo[6]['title']='图形的认识';
					$strdemo[6]['value']='107';
					$strdemo[7]['title']='圆';
					$strdemo[7]['value']='108';
					$strdemo[8]['title']='空间与图形';
					$strdemo[8]['value']='109';
					$strdemo[9]['title']='统计与概率';
					$strdemo[9]['value']='110';
					$strdemo[10]['title']='其他';
					$strdemo[10]['value']='111';
	
					break;
				case '3':
					$strdemo =array();				
					$strdemo[0]['title']='质量与密度';
					$strdemo[0]['value']='301';
					$strdemo[1]['title']='压力压强';
					$strdemo[1]['value']='302';
					$strdemo[2]['title']='浮力';
					$strdemo[2]['value']='303';
					$strdemo[3]['title']='简单机械';
					$strdemo[3]['value']='304';
					$strdemo[4]['title']='功率和机械效率';
					$strdemo[4]['value']='305';
					$strdemo[5]['title']='电学';
					$strdemo[5]['value']='306';
					$strdemo[6]['title']='光学';
					$strdemo[6]['value']='307';
					$strdemo[7]['title']='运动学';
					$strdemo[7]['value']='308';
					$strdemo[8]['title']='热学';
					$strdemo[8]['value']='309';
					$strdemo[9]['title']='其他';
					$strdemo[9]['value']='310';
					
					break;
				case '4':
					$strdemo =array();				
					$strdemo[0]['title']='空气与O2';
					$strdemo[0]['value']='401';
					$strdemo[1]['title']='碳和碳的氧化物';
					$strdemo[1]['value']='402';
					$strdemo[2]['title']='水及溶液';
					$strdemo[2]['value']='403';
					$strdemo[3]['title']='金属与金属材料';
					$strdemo[3]['value']='404';
					$strdemo[4]['title']='酸和碱';
					$strdemo[4]['value']='405';
					$strdemo[5]['title']='盐和化肥';
					$strdemo[5]['value']='406';
					$strdemo[6]['title']='常见气体的制取';
					$strdemo[6]['value']='407';
					$strdemo[7]['title']='化学式和化合价，构成物质的微粒';
					$strdemo[7]['value']='408';
					$strdemo[8]['title']='化学与生活，化学与能源';
					$strdemo[8]['value']='409';
					$strdemo[9]['title']='化学计算';
					$strdemo[9]['value']='410';
					$strdemo[9]['title']='其他';
					$strdemo[9]['value']='411';
					break;
				case '5':
					$strdemo =array();				
					$strdemo[0]['title']='尊重、宽容、理解';
					$strdemo[0]['value']='401';
					$strdemo[1]['title']='碳和碳的氧化物';
					$strdemo[1]['value']='402';
					$strdemo[2]['title']='水及溶液';
					$strdemo[2]['value']='403';
					$strdemo[3]['title']='金属与金属材料';
					$strdemo[3]['value']='404';
					$strdemo[4]['title']='酸和碱';
					$strdemo[4]['value']='405';
					$strdemo[5]['title']='盐和化肥';
					$strdemo[5]['value']='406';
					$strdemo[6]['title']='常见气体的制取';
					$strdemo[6]['value']='407';
					$strdemo[7]['title']='化学式和化合价，构成物质的微粒';
					$strdemo[7]['value']='408';
					$strdemo[8]['title']='化学与生活，化学与能源';
					$strdemo[8]['value']='409';
					$strdemo[9]['title']='化学计算';
					$strdemo[9]['value']='410';
					$strdemo[9]['title']='其他';
					$strdemo[9]['value']='411';
					break;
				case '6':
					
					break;
				case '7':
					
					break;
				default:
					# code...
					break;
			}
			$this->ajaxReturn(array('data'=>$strdemo));
		}
	}
	function changetruename()
	{
		if(IS_POST)
    	{
    		$userid =I('userid','','intval');
    		$truename=I('truename','','trim');
    		M('teacher')->where("id='$userid'")->setField('truename',$truename);
    		$this->ajaxReturn(array('status'=>0,'namestr'=>$truename));
    	}
	}
    function changeline()
    {
    	if(IS_POST)
    	{
    		$userid =I('userid','','intval');
    		$isonline=I('isonline','','intval');
    		M('teacher')->where("id='$userid'")->setField('isonline',$isonline);
    		$this->ajaxReturn(array('status'=>0));
    	}
    }
    // 重置密码
    function doupdatepwd()
    {
    	if(IS_POST)
    	{
    		$userid =I('userid','','intval');
    		$password =I('password','','trim');
    		$mobile=I('mobile','','trim');
		  	if(!check_send_code($mobile,trim($_POST['yzcode']))){
	            $this->ajaxReturn(['status'=>0,'msg'=>'短信验证码错误']);
	        }
	        $res=M('teacher')->where("id='$userid'")->save(array('password'=>sp_password($password))); 
	        //if($res){$this->ajaxReturn(['status'=>1,'url'=>U('User/center/index'),'msg'=>'重置密码成功']); }
	        $this->ajaxReturn(['status'=>1,'url'=>U('User/center/index'),'msg'=>'重置密码成功']);
    	}
    }
    function del_msg()
    {
    	if(IS_POST)
    	{
    		$id=I('id','','intval');
    		$res=M('message')->where("id='$id'")->delete();
    		if($res)
    		{
    			$this->ajaxReturn(array('status'=>0));
    		}else
    		{
    			$this->ajaxReturn(array('status'=>1,'msg'=>'删除失败'));
    		}
    	}
    }
    // 搜索收入记录
    function gettixianlog()
    {
    	if(IS_POST)
    	{
    		$userid =I('id','','intval');
    		$starttime =I('starttime','','trim');
    		$endtime =I('endtime','','trim');
    		
    		if(!empty($starttime) && !empty($endtime))
    		{
    			$html='';
    			$list =M('orders')->where("teacherid='$userid' and addtime >'".strtotime($starttime)."' and addtime <'".strtotime($endtime.' 23:59:59')."'")->select();
    			
    			foreach ($list as $key => $value) {
    				$html.='<li class="list-item app-flex app-vertical-center">
						<div class="list-info app-basis">
							<h4>'.$value[type].'<span>￥'.$value[orderprice].'</span></h4>
							<p>'.$value[title].'</p>
							<p>'.date('Y-m-d H:i',$value['addtime']).'</p>
						</div>';
					if($value['logid']!=0)
					{
						$html.='<div class="list-status">已提现</div>';
					}else
					{
						$html.='<div class="list-status in">未提现</div>';
					}
					$html.='</li>';
    			}	    		
	    		$this->ajaxReturn(array('status'=>1,'html'=>$html));
    		}    		
    	}
    }
	/** $data 格式如下
     *  $data = array(
            'userid' //申请退款者ID
            'openid' //退款者openid
            'refundid' //退款申请ID
            'money' //退款金额
            'desc'  //退款描述
        );
     *
     */
    function wxbuild($data, $wxchat){
        //判断有没有CA证书及支付信息
        if(empty($wxchat['api_cert']) || empty($wxchat['api_key']) || empty($wxchat['api_ca']) || empty($wxchat['appid']) || empty($wxchat['mchid'])){
            $wxchat['appid'] = $this->appid;
            $wxchat['mchid'] = $this->mchid;
            $wxchat['api_cert'] = $this->cacab['api_cert'];
            $wxchat['api_key'] = $this->cacab['api_key'];
            $wxchat['api_ca'] = $this->cacab['api_ca'];
        }
        $webdata = array(
            'mch_appid' => $wxchat['appid'],
            'mchid'     => $wxchat['mchid'],
            'nonce_str' => md5(time()),           
            'partner_trade_no'  => date('ymdHis').rand(100,999), //商户订单号，需要唯一
            'openid'    => $data['openid'],
            'check_name'=> 'NO_CHECK', //OPTION_CHECK不强制校验真实姓名, FORCE_CHECK：强制 NO_CHECK：
            //'re_user_name' => 'jorsh', //收款人用户姓名
            'amount'    => $data['money'] * 100, //付款金额单位为分
            'desc'      => empty($data['desc'])? '退款' : $data['desc'],
            'spbill_create_ip' => $this->getip(),
        );
        foreach ($webdata as $k => $v) {
            $tarr[] =$k.'='.$v;
        }
        sort($tarr);
        $sign = implode($tarr, '&');
        $sign .= '&key='.$this->signkey;
        $webdata['sign']=strtoupper(md5($sign));
        $wget = $this->array2xml($webdata);
        $res = $this->postXmlSSLCurl($wget,$this->payurl,'30',$wxchat);
		
        if(!$res){
            return array('status'=>1, 'msg'=>"参数有误" );
        }
        $content = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
        if(strval($content->return_code) == 'FAIL'){
            return array('status'=>1, 'msg'=>strval($content->return_msg));
        }
        if(strval($content->result_code) == 'FAIL'){
            return array('status'=>1, 'msg'=>strval($content->err_code),':'.strval($content->err_code_des));
        }
        $rdata = array(
            'mch_appid'        => strval($content->mch_appid),
            'mchid'            => strval($content->mchid),
            'device_info'      => strval($content->device_info),
            'nonce_str'        => strval($content->nonce_str),
            'result_code'      => strval($content->result_code),
            'partner_trade_no' => strval($content->partner_trade_no),
            'payment_no'       => strval($content->payment_no),
            'payment_time'     => strval($content->payment_time),
        );
        return $rdata;
    }
 
    function getip() {
        static $ip = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
 
        /**
     * 将一个数组转换为 XML 结构的字符串
     * @param array $arr 要转换的数组
     * @param int $level 节点层级, 1 为 Root.
     * @return string XML 结构的字符串
     */
    function array2xml($arr, $level = 1) {
        $s = $level == 1 ? "<xml>" : '';
        foreach($arr as $tagname => $value) {
            if (is_numeric($tagname)) {
                $tagname = $value['TagName'];
                unset($value['TagName']);
            }
            if(!is_array($value)) {
                $s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
            } else {
                $s .= "<{$tagname}>" . $this->array2xml($value, $level + 1)."</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $level == 1 ? $s."</xml>" : $s;
    }
	
	 /**
     *     作用：使用证书，以post方式提交xml到对应的接口url
     */
    function postXmlSSLCurl($xml,$url,$second=30,$wxchat)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        //设置证书
        curl_setopt($ch,CURLOPT_CAINFO, 'E:/phpStudy/WWW/chinesehelp2'.$wxchat['api_ca']);
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, 'E:/phpStudy/WWW/chinesehelp2'.$wxchat['api_cert']);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, 'E:/phpStudy/WWW/chinesehelp2'.$wxchat['api_key']);

        //post提交方式
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
        $data = curl_exec($ch);		
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);		
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }
}
