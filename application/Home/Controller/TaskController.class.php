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
 * 微课列表
 */
class TaskController extends Controller {
	public function index()
	{
		$type=I('type','','intval');
		if($type < 3 || $type > 9)
		{
			redirect(U('Home/index/index'));
		}
		$_SESSION['student']['xueketype']=$type;
		switch ($type) {
			case '3':
				$typename ='语文';
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
			case '4':
				$typename ='数学';
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
			case '5':
				$typename ='英语';
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
			case '6':
				$typename ='物理';
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
			case '7':
				$typename ='化学';
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
			case '8':
				$typename ='政治';
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
			case '9':
				$typename ='历史';
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
		$this->assign('typename',$typename);
		$lists =M('task')->where("status=1 and type='微课' and xueke='$typename'")->order('addtime desc')->select();
		foreach ($lists as $key => $value) {
			$tinfo=M('teacher')->field('id,truename,headimg,questiontype')->where("id='".$value['userid']."'")->find();
			$lists[$key]['headimg'] =$tinfo['headimg'];
			$lists[$key]['questiontype'] =$tinfo['questiontype'];
			$lists[$key]['username'] =$tinfo['truename'];
			$lists[$key]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='微课'")->count();
		}
		$typelist =M('task')->field('classtype')->where("status=1")->group('classtype')->select();
		$this->assign('typelist', $typelist);
		$this->assign('list',$lists);

		// 在线教师
		$list=M('answer')->field("teacherid,count(*)as number")->where("YEARWEEK(date_format(addtime2,'%Y-%m-%d')) = YEARWEEK(now()) and xueke='$typename'")->group('teacherid')->order('number desc')->limit(3)->select();
		$list2=M('answer')->field("teacherid,count(*)as number")->where("xueke='$typename' and YEARWEEK(date_format(addtime2,'%Y-%m-%d')) = YEARWEEK(now())-1")->group('teacherid')->order('number desc')->limit(3)->select();
		
		if(count($list)<3)
		{
			// 上周的回答数
			if(count($list2)<3)
			{
				$tlist =M('teacher')->where("isonline=1 and xueke='$typename'")->limit(3)->order("number desc")->select();
				foreach ($tlist as $k => $val) {
					$tlist[$k]['qcount'] = $val['number'];
					$tlist[$k]['colcount'] = M('collect_task')->where("taskid='".$val['id']."' and type='教师'")->count();
					$info =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$val['id']."' and isend=1")->find();
					$tlist[$k]['star'] = number_format($info['star'],1);
					$tlist[$k]['truename']=$val['truename'];
				}
			}else
			{
				
				foreach($list2 as $kk=>$vl)
				{
					$info =M('teacher')->field('id,honors,star,nicename,truename,headimg,number')->where("id='".$vl['teacherid']."' and xueke='$typename'")->find();
					$tlist[$kk]['id'] =$info['id'];
					$tlist[$kk]['qcount'] =$info['number'];
					$tlist[$kk]['colcount'] = M('collect_task')->where("taskid='".$vl['id']."' and type='教师'")->count();
					$infos =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$vl['teacherid']."' and isend=1")->find();
					$tlist[$kk]['star'] = number_format($infos['star'],1);
					$tlist[$kk]['headimg']=$info['headimg'];
					$tlist[$kk]['truename']=$info['truename'];
				}
				
			}
		}else{
			foreach($list as $kk=>$vl)
				{
					$info =M('teacher')->field('id,honors,star,nicename,truename,headimg,number')->where("id='".$vl['teacherid']."' and xueke='$typename'")->find();
					$tlist[$kk]['id'] =$info['id'];
					$tlist[$kk]['qcount'] =$info['number'];
					$tlist[$kk]['colcount'] = M('collect_task')->where("taskid='".$vl['id']."' and type='教师'")->count();
					$infos =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$vl['teacherid']."' and isend=1")->find();
					$tlist[$kk]['star'] = number_format($infos['star'],1);
					$tlist[$kk]['headimg']=$info['headimg'];
					$tlist[$kk]['truename']=$info['truename'];
				}
		}
		
		$this->assign("tlist",$tlist);
		$this->display();
	}
	public function lesson_info()
	{
		$id=I('id','','intval');
		$this->checklogin();
    	$this->checkuser();
		$this->assign('isscore',intval($_GET['isscore']));
		$this->assign('studenttype',intval($_SESSION['student']['xueketype']));
		// 微课详情
		$info=M('task')->where("id='$id'")->find();
		// 发布者信息
		$uinfo =M('teacher')->where("id='".$info['userid']."'")->find();
		$uinfo['qcount'] = M('answer')->where("teacherid='".$uinfo['id']."'")->count();
		$uinfo['colcount'] = M('collect_task')->where("taskid='".$uinfo['id']."' and type='教师'")->count();
		$info['colcount'] = M('collect_task')->where("taskid='".$id."' and type='微课'")->count();


		// 相关推荐
		$relatelist =M('task')->where("isindex!=0 and type='微课' and id<>'".$info['id']."'")->limit(3)->order('isindex desc')->select();
		foreach ($relatelist as $key => $value) {
			$relatelist[$key]['colcount'] = M('collect_task')->where("taskid='".$value['id']."' and type='微课'")->count();
		}

		// 查看当前用户是否收藏该微课
		$iscollect =M('collect_task')->where("userid='".$_SESSION['student']['id']."' and taskid='".$info['id']."' and type='微课'")->find();		
		if($iscollect)
		{
			$this->assign('iscollect',1);
		}
		$iscollect2 =M('collect_task')->where("userid='".$_SESSION['student']['id']."' and taskid='".$info['userid']."' and type='教师'")->find();		
		if($iscollect2)
		{
			$this->assign('iscollect2',1);
		}
		// 查看当前用户是否举报过
		$isreport =M('reports')->where("mid='".$_SESSION['student']['id']."' and tid='".$info['id']."' and type='微课'")->find();
		if($isreport)
		{
			$this->assign('isreport',1);

		}
		// 查看当前用户是否打过分
		$isscoreed =M('taskscore')->where("userid='".$_SESSION['student']['id']."' and taskid='".$info['id']."' and type='1'")->find();
		
		if($isscoreed)
		{
			$this->assign('isscoreed',1);
		}else{
			$this->assign('isscoreed',0);
		}
		// 查看累加次数
		M("task")->where("id='".$id."'")->setInc("clicknum");
		// 当前课程是否购买
		$ismall =M('orders')->where("tid='$id' and userid='".$_SESSION['student']['id']."' and orderstatus=1 and type='购买微课'")->count();
		$this->assign('ismall', $ismall);
		
		$content =json_decode($info['content'],true);
		$this->assign('imgaudio',$content);
		
		$this->assign('info', $info);
		if($info['price'] > '0.00' && $ismall == 0)
		{
			$this->assign('showpay',1);
		}
		if($info['price'] > '0.00' && $ismall == 1)
		{
			$this->assign('showpay',0);
		}
		if($info['price'] == '0.00')
		{
			$this->assign('showpay',0);
		}
		$this->assign('uinfo', $uinfo);
		$this->assign('relatelist', $relatelist);
		
		// 计算综合评分
		$scorelist =M('taskscore')->where("taskid='".$id."' and type=1")->select();
		$totalscore=0.0;
		foreach($scorelist as $key=>$vv)
		{
			$totalscore+=$vv['score'];
		}
		if($totalscore>0)
		{
			$star =number_format($totalscore/count($scorelist),1);
			$res=M('task')->where("id='$id'")->setField('star',$star);
			
			// 计算专题的综合评分
			$ztlist=M('term_zhuanti')->where("taskid='$id'")->group('ztid')->select();
			$tstar=0.0;
			foreach($ztlist as $kk=>$vq)
			{
				$tasklist =D()->field('t.star')->table(C('DB_PREFIX').'task t,'.C('DB_PREFIX').'term_zhuanti z')->where("t.id=z.taskid and ztid='".$vq['ztid']."'")->select();
				foreach($tasklist as $k1=>$vk)
				{
					$tstar+=$vk['star'];
				}
				$star =number_format($tstar/count($tasklist),1);
				M('zhuantis')->where("id='".$vq['ztid']."'")->setField('compoint',$star);
				$tstar=0.0;
			}
			
		}
		$this->assign('payurl',U('Home/Task/dopay',array('tid'=>$info['id'],'teacherid'=>$uinfo['id'])));
		$this->display();
	}
	// 打分
	public function give_score()
	{
		$id=I('id','','intval');
		$info =M('task')->find($id);
		if(empty($info))
		{
			redirect(U('Home/Index/index'));
		}
		$this->assign('id', $id);
		$this->display();
	}
	function docore()
	{
		if(IS_POST)
		{
			$id =I('id','','intval');
			$cores =I('cores','','trim');
			$qinfo = M('task')->where("id='$id'")->find();
			if(!empty($qinfo))
			{				
				$totcore =0;
				foreach ($cores as $key => $value) {
					$totcore +=$value;
				}
				$star =number_format($totcore/4,1);
				$count =M('taskscore')->where("taskid='$id' and type=1 and userid='".$_SESSION['student']['id']."'")->count();
				if($count > 0)
				{
					$this->ajaxReturn(array('status'=>0,'msg'=>'您已打过分了'));
				}
				$data['taskid']=$id;
				$data['type']=1;
				$data['score']=$star;
				$data['userid']=$_SESSION['student']['id'];
				$result=M('taskscore')->add($data);
				if($result)
				{
					$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Task/lesson_info',array('id'=>$id))));
				}				
			}else
			{
				$this->ajaxReturn(array('status'=>0,'msg'=>'打分失败'));
			}
		}
	}
	// 微课下单跳转微信支付
	public function dopay()
	{
			$tid=I('tid','','intval');			
			$teacherid =I('teacherid','','intval');
			if($tid && $teacherid)
			{
				$info =M('task')->field("title,price")->where("id='$tid'")->find();
				$userid =$_SESSION['student']['id'];
				$username =$_SESSION['student']['nicename'];
				$uinfo =M('teacher')->field('nicename')->where("id='$teacherid'")->find();
				M('orders')->where("userid='$userid' and tid='$tid' and orderstatus=0 and type='购买微课'")->delete();			
				// 提成
				$option=M('options')->where("option_id='9'")->find();
				//file_put_contents('a8999.txt',var_export($option,true));
				$ticheng=json_decode($option['option_value'],true);
				// 代理教师提成
				$commission = round($ticheng['teacherpersent']*$info['price']/100,2);
				// 学生上级提成
				$commission2 = round($ticheng['studentpersent']*$info['price']/100,2);
				$orders =array(
					'userid'=>$userid,
					'username'=>$username,
					'title'=>'标题：'.$info['title'],
					'teachername'=>$uinfo['nicename'],
					'teacherid'=>$teacherid,
					'tid'=>$tid,
					'type'=>'购买微课',
					'orderprice'=>$info['price'],
					'commission'=>$commission,
					'commission2'=>$commission2,
					'tccoin'  => round($info['price']*$ticheng['wxpersent']/100,2),
					'ordersn'=>sp_get_order_sn(),
					'orderstatus'=>0,
					'addtime'=>time()
				);
				$res=M('orders')->add($orders);
				if($res)
				{					
					redirect(U('WxJsAPI/jsApiCall',array('orderNum'=>$orders['ordersn'])));
				}			
			}else
			{
				redirect('./');
			}
	}
	function getweikelist()
	{
		if(IS_POST)
		{
			$classtype =I('classtype','','trim');
			$keywords =I('keywords','','trim');
			$xueke =I('xueke','','trim');
			$where =array("status=1 and type='微课'");
			if(!empty($classtype) && $classtype !='课程类型')
			{
				$where['classtype'] =$classtype;
			}
			if(!empty($xueke))
			{
				$where['xueke'] =$xueke;
			}
			if(!empty($keywords))
			{
				$where['title'] = array('like','%'.$keywords.'%');
			}
			$html='';
			$list =M('task')->where($where)->select();
			foreach ($list as $key => $va) {
				$tinfo =M('teacher')->field('id,truename,headimg,questiontype')->where("id='".$va['userid']."'")->find();
				$list[$key]['colcount'] =M('collect_task')->where("taskid='".$va['id']."' and type='微课'")->count();
				$html.="<li class=\"content-item\" data-type=\"mrolesson\">
						<a href=".U('Home/Task/lesson_info',array('id'=>$va['id']))." class=\"app-basis app-flex app-vertical-center\">
							<div class=\"headImg\">
								<img src='".$tinfo['headimg']."' alt=\"img\">
							</div>
							<div class=\"app-basis\" style=\"width:1%\">
								<div style=\"font-size:.9rem\">".$tinfo['truename']."</div>							
								<h4 class=\"ellipsis\" style=\"font-size:.8rem;color:#999\">".$tinfo['questiontype']."</h4>
								<div class=\"ellipsis\" style=\"font-size:.8rem\">".$va['title']."</div>							
								<h5 style=\"font-size:.8rem;color:#999;margin:5px 0\">".$va['classtype']."&nbsp;&nbsp;&nbsp;".$va['type']."</h5>							
								<h5 class=\"Line2\" style=\"color:#999;font-size:.8rem;\">".$va['brief']."</h5>							
								<div class=\"content-info-num3 app-flex app-vertical-center\" style=\"margin-top:.5rem\">
									<h4>".$va['clicknum']."";
									if($va['clicknum'] > '999')
									{
										$html .= '+';
									}
									$html.="</h4>";
									$html.="<h5>".$list[$key]['colcount']."";
									if($va['colcount'] > '999')
									{
										$html .='+';
									}
									$html.="</h5>
								</div>
						 </div>
						</a>
					</li>";
			}
			$this->ajaxReturn(array('status'=>1,'html'=>$html));

		}
	}
	
	// 微课收藏取消操作
	function collect()
	{
		if(IS_POST)
		{
			$taskid =I('taskid','','intval');
			$type =I('type','','intval');
			if($type ==1)// 加入收藏
			{
				$data['userid'] =$_SESSION['student']['id'];
				$data['taskid'] =$taskid;
				$data['addtime'] =time();
				$data['type'] ='微课';
				$res =M('collect_task')->add($data); 
				if($res)
				{
					$this->ajaxReturn(array('status'=>1));
				}
			}else//取消收藏
			{
				$res =M('collect_task')->where("type='微课' and taskid='$taskid' and userid ='".$_SESSION['student']['id']."'")->delete();
				if($res)
				{
					$this->ajaxReturn(array('status'=>1));
				}
			}
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