<?php
/**
 * 	 微课
 */
namespace Portal\Controller;
use Common\Controller\MemberbaseController;
class TaskController extends MemberbaseController {
	const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	
	function _initialize(){
		parent::_initialize();
	}
	//我的微课
	public function index()
	{
		$id =I('id','','intval');
		$ztid =I('ztid','0','intval');
		$uinfo=$this->user;
		$this->assign($uinfo);
		$option=get_caiwu_options();
		$option['wxpersent'] =round(100-$option['wxpersent'],2);
		$this->assign('option', $option);		
		$list =M('task')->where("userid='".$uinfo['id']."' and type='微课'")->order('status ASC,addtime DESC')->select();
		foreach ($list as $key => $value) {
			$list[$key]['colcount'] =M('collect_task')->where("type='微课' and taskid='".$value['id']."'")->count();
		}
		$this->assign('list', $list);
		$this->assign('ztid', $ztid);
		if(!empty($id))
		{
			$taskinfo =M('task')->find($id);
			$content =json_decode($taskinfo['content'],true);
			
			$this->assign('imgtaudio',$content);
			$this->assign('imgtaudiocount',count($content));
			$this->assign('taskinfo',$taskinfo);
		}
		// 教师专题
		$ztlist =M('zhuantis')->field('id,title,id as value')->where("teacherid='".$uinfo['id']."'")->select();
		if(count($ztlist) == 0)
		{
			$ztlist = '';
		}
		$this->assign('ztlist',$ztlist);
		switch ($uinfo['xueke']) {
			case '语文':
				$qtypelist[0]['typename'] ='中国文化趣谈';
				$qtypelist[1]['typename'] ='西方文化趣谈';
				$qtypelist[2]['typename'] ='基础知识应试技巧';
				$qtypelist[3]['typename'] ='综合性学习应试技巧';
				$qtypelist[4]['typename'] ='记叙文小说应试技巧';
				$qtypelist[5]['typename'] ='说明文应试技巧';
				$qtypelist[6]['typename'] ='议论文应试技巧';
				$qtypelist[7]['typename'] ='作文应试技巧';
				$qtypelist[8]['typename'] ='课内现代文导读';
				$qtypelist[9]['typename'] ='课内古诗文导读';
				$qtypelist[10]['typename'] ='课外阅读指南';
				$qtypelist[11]['typename'] ='学科渗透及其他';				
				break;
			case '数学':
				$qtypelist[0]['typename'] ='实数';
				$qtypelist[1]['typename'] ='代数式';
				$qtypelist[2]['typename'] ='整式';
				$qtypelist[3]['typename'] ='分式';
				$qtypelist[4]['typename'] ='方程（组）与不等式组';
				$qtypelist[5]['typename'] ='变量与函数';
				$qtypelist[6]['typename'] ='图形的认识';
				$qtypelist[7]['typename'] ='圆';
				$qtypelist[8]['typename'] ='空间与图形';
				$qtypelist[9]['typename'] ='统计与概率';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '英语':
				$qtypelist[0]['typename'] ='听力';
				$qtypelist[1]['typename'] ='单选';
				$qtypelist[2]['typename'] ='完型';
				$qtypelist[3]['typename'] ='阅读';
				$qtypelist[4]['typename'] ='任务性阅读';
				$qtypelist[5]['typename'] ='正确形式填空';
				$qtypelist[6]['typename'] ='完成句子';
				$qtypelist[7]['typename'] ='短文填空';
				$qtypelist[8]['typename'] ='作文';
				$qtypelist[9]['typename'] ='口语交际';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '物理':
				$qtypelist[0]['typename'] ='质量密度';
				$qtypelist[1]['typename'] ='压力压强';
				$qtypelist[2]['typename'] ='浮力';
				$qtypelist[3]['typename'] ='简单机械';
				$qtypelist[4]['typename'] ='功率和机械效率';
				$qtypelist[5]['typename'] ='电学';
				$qtypelist[6]['typename'] ='光学';
				$qtypelist[7]['typename'] ='运动学';
				$qtypelist[8]['typename'] ='热学';
				$qtypelist[9]['typename'] ='其他';
				break;
			case '化学':
				$qtypelist[0]['typename'] ='空气与O２';
				$qtypelist[1]['typename'] ='碳和碳的氧化物';
				$qtypelist[2]['typename'] ='水及溶液';
				$qtypelist[3]['typename'] ='金属与金属材料';
				$qtypelist[4]['typename'] ='酸和碱';
				$qtypelist[5]['typename'] ='盐和化肥';
				$qtypelist[6]['typename'] ='常见气体的制取';
				$qtypelist[7]['typename'] ='化学式和化合价、构成物质的微粒';
				$qtypelist[8]['typename'] ='化学与生活、化学与能源';
				$qtypelist[9]['typename'] ='化学计算';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '政治':
				$qtypelist[0]['typename'] ='尊重、宽容、理解';
				$qtypelist[1]['typename'] ='诚信、竞争、合作';
				$qtypelist[2]['typename'] ='个人、集体、责任、公平、正义';
				$qtypelist[3]['typename'] ='网络的利与弊';
				$qtypelist[4]['typename'] ='法律基本知识';
				$qtypelist[5]['typename'] ='公民的权利与义务';
				$qtypelist[6]['typename'] ='未成年人的特殊保护';
				$qtypelist[7]['typename'] ='国策、战略、理念';
				$qtypelist[8]['typename'] ='发展道路、理论体系、伟人旗帜';
				$qtypelist[9]['typename'] ='政治学科核心观点';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '历史':
				$qtypelist[0]['typename'] ='古今中外文明交往';
				$qtypelist[1]['typename'] ='中国古代科技文化';
				$qtypelist[2]['typename'] ='大国关系';
				$qtypelist[3]['typename'] ='中华民族复兴';
				$qtypelist[4]['typename'] ='两次世界大战';
				$qtypelist[5]['typename'] ='省市本土历史';
				$qtypelist[6]['typename'] ='中共党史';
				$qtypelist[7]['typename'] ='重要历史人物';
				$qtypelist[8]['typename'] ='热点时事连线';					
				$qtypelist[9]['typename'] ='其他';
				break;
			default:
				# code...
				break;
		}
		
		$this->assign('qtypelist',$qtypelist);
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID,self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		$this->display();
	}	
	public function ztinfo()
	{
		$this->display();
	}
	public function detail()
	{
		$id =I('id','','intval');
		$info =M('task')->find($id);
		$content =json_decode($info['content'],true);
		
		$this->assign('imgtaudio',$content);
		$info['colcount'] =M('collect_task')->where("userid='".$info['userid']."' and type='微课' and taskid='".$id."'")->count();
		$this->assign('info',$info);
		$this->assign('localurl',U('Portal/Task/index',array('id'=>$id)));
		$this->display();
	}
	function fabu()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			
			$data['type'] ='微课';
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
					M('term_zhuanti')->add(array('ztid'=>$pdata['ztid'],'type'=>1,'taskid'=>$res,'sortorder'=>time()));
				}
			}else
			{
				
				$res =M('task')->where("id='".$pdata['acid']."'")->save($data);
			}
			$this->ajaxReturn(array('status'=>1,'msg'=>'发布成功','url'=>U('Portal/task/index')));
			
		}
	}
	function fabu5()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			
			$data['type'] ='微课';
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
					M('term_zhuanti')->add(array('ztid'=>$pdata['ztid'],'type'=>1,'taskid'=>$res,'sortorder'=>time()));
				}
			}else
			{
				
				M('task')->where("id='".$pdata['acid']."'")->save($data);
				$res =$pdata['acid'];
			}
			$this->ajaxReturn(array('status'=>1,'msg'=>'发布成功','id'=>$res));
			
		}
	}
	function fabu2()
	{
		if(IS_POST)
		{
			$id =I('id','','intval');
			$res=M('task')->where("id='$id'")->save(array('status'=>1)); 
			if($res)
			{
				$this->ajaxReturn(array('status'=>1,'msg'=>'发布成功','url'=>U('Portal/task/index')));
			}else
			{
				$this->ajaxReturn(array('status'=>2,'msg'=>'发布失败'));
			}
		}
	}
	// 删除微客资源	
	function deltask()
	{
		if(IS_POST)
		{
			$id=I('id','','intval');
			$res=M('task')->where("id='$id'")->delete();
			if($res)
			{
				$this->ajaxReturn(array('status'=>0));
			}
		}
	}
}