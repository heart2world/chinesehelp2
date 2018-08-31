<?php
/**
 * 	 资源
 */
namespace Portal\Controller;
use Common\Controller\MemberbaseController;
class ResourceController extends MemberbaseController {
	const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	
	function _initialize(){
		parent::_initialize();
	}
	//我的资源
	public function index()
	{
		$id =I('id','','intval');
		$ztid =I('ztid','','intval');
		$uinfo=$this->user;
		$this->assign($uinfo);
		$option=get_caiwu_options();
		$option['zypersent'] =round(100-$option['zypersent'],2);
		$this->assign('option', $option);

		$list =M('task')->where("userid='".$uinfo['id']."' and type='资源'")->order('status ASC,addtime DESC')->select();
		foreach ($list as $key => $value) {
			$list[$key]['colcount'] =M('collect_task')->where("userid='".$userid."' and type='资源' and taskid='".$value['id']."'")->count();
		}
		$this->assign('list', $list);
		$this->assign('ztid', $ztid);
		// 教师专题
		$ztlist =M('zhuantis')->field('id,title,id as value')->where("teacherid='".$uinfo['id']."'")->select();
		if(count($ztlist)==0)
		{
			$ztlist='';
		}
		$this->assign('ztlist',$ztlist);
		if(!empty($id))
		{
			$taskinfo =M('task')->find($id);
			$content =json_decode($taskinfo['content'],true);		
			$this->assign('imgtaudio',$content);
			$this->assign('imgtaudiocount',count($content));
			$this->assign('taskinfo',$taskinfo);
		}
		
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID,self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		
		$this->display();
	}	
	public function detail()
	{
		$id =I('id','','intval');
		$info =M('task')->find($id);
		$content =json_decode($info['content'],true);
		
		$this->assign('imgtaudio',$content);
		$info['colcount'] =M('collect_task')->where("userid='".$info['userid']."' and type='资源' and taskid='".$id."'")->count();
		$this->assign('info',$info);
		$this->assign('localurl',U('Portal/Resource/index',array('id'=>$id)));
		$this->display();
	}
	function fabu()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			$data['type'] ='资源';
			$tinfo= M('teacher')->field('id,nicename,xueke')->where("id='".$pdata['userid']."'")->find();
			$data['username']=$tinfo['nicename'];
			$data['xueke']=$tinfo['xueke'];
			$adata=array();
			
			foreach($pdata['content'] as $k=>$value)
			{
				$adata[$k]['text'] =$value;
				$adata[$k]['type'] =$pdata['atype'][$k];
				$adata[$k]['atime']=$pdata['atime'][$k];
			}
			$data['content'] =json_encode($adata);
			$data['userid'] = $pdata['userid'];
			$data['title'] =$pdata['title'];
			$data['brief'] =$pdata['brief'];
			$data['classtype'] =$pdata['lesson_type'];
			$data['price'] =$pdata['price'];
			$data['status']=$pdata['status'];
			$data['star'] ='0.0';
			if(!$pdata['acid'])
			{
				$data['addtime'] =time();
				$data['addtime2']=date('Y-m-d H:i:s');
				$res=M('task')->add($data); 
				if($res)
				{
					M('term_zhuanti')->add(array('ztid'=>$pdata['ztid'],'type'=>2,'taskid'=>$res,'sortorder'=>time()));
				}
			}else
			{
				$res =M('task')->where("id='".$pdata['acid']."'")->save($data);
				$res =1;
			}	
			$this->ajaxReturn(array('status'=>1,'msg'=>'发布成功','url'=>U('Portal/Resource/index')));
			
		}
	}
	function fabu5()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			$data['type'] ='资源';
			$tinfo= M('teacher')->field('id,nicename,xueke')->where("id='".$pdata['userid']."'")->find();
			$data['username']=$tinfo['nicename'];
			$data['xueke']=$tinfo['xueke'];
			$adata=array();
			
			foreach($pdata['content'] as $k=>$value)
			{
				$adata[$k]['text'] =$value;
				$adata[$k]['type'] =$pdata['atype'][$k];
				$adata[$k]['atime']=$pdata['atime'][$k];
			}
			$data['content'] =json_encode($adata);
			$data['userid'] = $pdata['userid'];
			$data['title'] =$pdata['title'];
			$data['brief'] =$pdata['brief'];
			$data['classtype'] =$pdata['lesson_type'];
			$data['price'] =$pdata['price'];
			$data['status']=0;
			$data['star'] ='0.0';
			if(!$pdata['acid'])
			{
				$data['addtime'] =time();
				$data['addtime2']=date('Y-m-d H:i:s');
				$res=M('task')->add($data); 
				if($res)
				{
					M('term_zhuanti')->add(array('ztid'=>$pdata['ztid'],'type'=>2,'taskid'=>$res,'sortorder'=>time()));
				}
			}else
			{
				M('task')->where("id='".$pdata['acid']."'")->save($data);
				$res =$pdata['acid'];
			}	
			$this->ajaxReturn(array('status'=>1,'msg'=>'发布成功','id'=>$res));
			
		}
	}
	// 直接发布
	function fabu2()
	{
		if(IS_POST)
		{
			$id =I('id','','intval');
			$res=M('task')->where("id='$id'")->save(array('status'=>1)); 
			if($res)
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'发布成功','url'=>U('Portal/Resource/index')));
			}else
			{
				$this->ajaxReturn(array('status'=>2,'msg'=>'发布失败'));
			}
		}
	}
}