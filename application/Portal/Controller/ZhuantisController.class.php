<?php
/**
 * 	 专题管理
 */
namespace Portal\Controller;
use Common\Controller\MemberbaseController;
class ZhuantisController extends MemberbaseController {
	const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	
	function _initialize(){
		parent::_initialize();
	}
	//我的专题
	public function index()
	{
		$uinfo=$this->user;
		$this->assign($uinfo);
		$ztlist =M('zhuantis')->where("teacherid='".$uinfo['id']."'")->select();
		
		$this->assign('ztlist', $ztlist);
		$this->display();
	}
	// 添加专题
	public function addzt()
	{
		$this->assign('istype', intval($_GET['istype']));
		$this->assign('atype', intval($_GET['atype']));
		$this->display();
	}
	// 编辑专题
	public function edit()
	{
		$ztid =I('ztid','','intval');
		$info=M('zhuantis')->where("id='$ztid'")->find();
		$this->assign('info',$info);
		$this->display();
	}
	public function edit_post()
	{
		if(IS_POST)
		{
			$pdata=I('post.');
			M('zhuantis')->where("id='".$pdata['id']."'")->save($pdata);
			$this->ajaxReturn(array('status'=>1,'url'=>U('Portal/zhuantis/index')));
		}
	}
	public function delzt()
	{
		if(IS_POST)
		{
			$pdata=I('post.');
			$result=M('zhuantis')->where("id='".$pdata['id']."'")->delete();
			if($result)
			{
				$this->ajaxReturn(array('status'=>0,'id'=>$pdata['id'],'url'=>U('Portal/zhuantis/index')));
			}			
		}
	}
	public function getmoveztlist()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			$list =D()->field('z.id')->table(C('DB_PREFIX').'term_zhuanti t,'.C('DB_PREFIX').'zhuantis z')->where("t.taskid='".$pdata['id']."' and t.type='".$pdata['type']."' and t.ztid=z.id")->select();
			$data =array();
			foreach($list as $key=>$v)
			{
				$data[]=$v['id'];
			}
			$this->ajaxReturn(array('status'=>0,'result'=>$data));
		}
	}
	// 移入专题操作
	public function addpostzt()
	{
		if(IS_POST)
		{
			$pdata =I('post.');	
			M('term_zhuanti')->where("taskid='".$pdata['id']."' and type='".$pdata['type']."'")->delete();
			foreach($pdata['ztlist'] as $key=>$v)
			{
				$data['ztid']=$v;
				$data['taskid']=$pdata['id'];
				$data['type']  =$pdata['type'];				
				$data['sortorder']=time();
				M('term_zhuanti')->add($data);								
			}
			$this->ajaxReturn(array('status'=>0));
		}
	}
	// 删除专题下的微课，资源
	public function delinfo()
	{
		if(IS_POST)
		{
			$id =I('taskid','','intval');
			$ztid=I('ztid','','intval');
			$type=I('type','','intval');
			$res =M('term_zhuanti')->where("ztid='$ztid' and taskid='$id' and type='$type'")->delete();
			if($res)
			{
				$this->ajaxReturn(array('status'=>0,'ids'=>$id));
			}else{
				$this->ajaxReturn(array('status'=>1,'msg'=>'删除失败'));
			}
		}
	}
	// 移动专题下的微课，资源
	public function domove()
	{
		if(IS_POST)
		{
			$id =I('taskid','','intval');
			$ztid=I('ztid','','intval');
			$type=I('type','','intval');
			$number=I('number','','intval');
			// 下移
			if($number == 1)
			{
				$sortorder=M('term_zhuanti')->where("ztid='$ztid' and taskid='$id' and type='$type'")->getField('sortorder');			
				$nextinfo=M('term_zhuanti')->where("ztid='$ztid' and sortorder <'$sortorder'")->order('sortorder desc')->find();
				
				$res =M('term_zhuanti')->where("ztid='$ztid' and taskid='$id' and type='$type'")->save(array('sortorder'=>$nextinfo['sortorder']));
				$res1 =M('term_zhuanti')->where("id='".$nextinfo['id']."'")->save(array('sortorder'=>$sortorder));
			}
			// 上移
			else
			{
				$sortorder=M('term_zhuanti')->where("ztid='$ztid' and taskid='$id' and type='$type'")->getField('sortorder');
				// 769
				$nextinfo=M('term_zhuanti')->where("ztid='$ztid' and sortorder >'$sortorder'")->order('sortorder asc')->find();				
				$res =M('term_zhuanti')->where("ztid='$ztid' and taskid='$id' and type='$type'")->save(array('sortorder'=>$nextinfo['sortorder']));				
				$res1 =M('term_zhuanti')->where("id='".$nextinfo['id']."'")->save(array('sortorder'=>$sortorder));				
			}			
			if($res && $res1)
			{
				$this->ajaxReturn(array('status'=>0,'ids'=>$id));
			}else{
				$this->ajaxReturn(array('status'=>1,'msg'=>'移动失败'));
			}
		}
	}
	// 专题下的资源微课
	public function ztinfo()
	{
		$ztid =I('id','','intval');
		$info=M('zhuantis')->where("id='$ztid'")->find();
		$this->assign('info',$info);
		
		$list=M('term_zhuanti')->where("ztid='$ztid'")->order('sortorder desc')->select();
		$liststr =array();
		foreach($list as $k=>$v)
		{
			$liststr[$k] = M('task')->field('id,type,title,status,classtype,brief,star,price,clicknum,addtime')->where("id='".$v['taskid']."'")->find();
			if($v['type']==1)
			{
				$liststr[$k]['colcount'] =M('collect_task')->where("taskid='".$v['taskid']."' and type='微课'")->count();
			}else
			{
				$liststr[$k]['colcount'] =M('collect_task')->where("taskid='".$v['taskid']."' and type='资源'")->count();
			}
			
		}
		$this->assign('list',$liststr);
		$this->display();
	}
	// 发布专题
	public function dofabu()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			$pdata['teacherid'] =$_SESSION['user']['id'];
			$info =M('teacher')->where("id='".$_SESSION['user']['id']."'")->find();
			$pdata['username'] =$info['nicename'];
			$pdata['xueke'] =$info['xueke'];
			$pdata['addtime']=time();
			$result=M('zhuantis')->add($pdata);
			if($result)
			{
				if($pdata['istype']==1)
				{
					if($pdata['atype']==1)
					{
						$this->ajaxReturn(array('status'=>1,'msg'=>'添加成功','url'=>U('Portal/task/index')));
					}
					else if($pdata['atype']==2)
					{
						$this->ajaxReturn(array('status'=>1,'msg'=>'添加成功','url'=>U('Portal/resource/index')));
					}
				}else
				{
					$this->ajaxReturn(array('status'=>1,'msg'=>'添加成功','url'=>U('Portal/zhuantis/index')));
				}
				
			}
			else
			{
				$this->ajaxReturn(array('status'=>0,'msg'=>'添加失败'));
			}
		}
	}
}