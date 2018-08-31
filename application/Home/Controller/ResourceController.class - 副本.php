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
 * 资源列表
 */
class ResourceController extends Controller {
	public function index()
	{
		$type=I('type','','intval');
		if($type < 3 || $type > 9)
		{
			redirect(U('Home/index/index'));
		}
		$_SESSION['student']['xueketype'] =$type;
		switch ($type) {
			case '3':
				$typename ='语文';
				break;
			case '4':
				$typename ='数学';
				break;
			case '5':
				$typename ='英语';
				break;
			case '6':
				$typename ='物理';
				break;
			case '7':
				$typename ='化学';
				break;
			case '8':
				$typename ='政治';
				break;
			case '9':
				$typename ='历史';
				break;
			default:
				# code...
				break;
		}
		$lists =M('task')->where("status=1 and type='资源' and xueke='$typename'")->order('addtime desc')->select();
		foreach ($lists as $key => $value) {
			if($value['userid']==0)
			{
				$lists[$key]['headimg']='http://'.$_SERVER['HTTP_HOST'].'/data/upload/logo.png';
				$lists[$key]['nicename']='问学帮官方';
			}else
			{
				$tinfo =M('teacher')->field('id,nicename,headimg')->where("id='".$value['userid']."'")->find();
				$lists[$key]['headimg']=$tinfo['headimg'];
				$lists[$key]['nicename']=$tinfo['nicename'];
			}
			
			$lists[$key]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='资源'")->count();
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
					$tlist[$k]['truename']=$val['nicename'];
				}
			}else
			{
				foreach($list2 as $kk=>$vl)
				{
					$info =M('teacher')->field('id,honors,star,nicename,truename,headimg,number')->where("id='".$vl['teacherid']."'")->find();
					$tlist[$kk]['id'] =$info['id'];
					$tlist[$kk]['qcount'] =$info['number'];
					$tlist[$kk]['colcount'] = M('collect_task')->where("taskid='".$val['id']."' and type='教师'")->count();
					$infos =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$vl['teacherid']."' and isend=1")->find();
					$tlist[$kk]['star'] = number_format($infos['star'],1);
					$tlist[$kk]['headimg']=$info['headimg'];
					$tlist[$kk]['truename']=$info['nicename'];
				}
			}
		}else{
			foreach($list as $kk=>$vl)
				{
					$info =M('teacher')->field('id,honors,star,nicename,truename,headimg,number')->where("id='".$vl['teacherid']."'")->find();
					$tlist[$kk]['id'] =$info['id'];
					$tlist[$kk]['qcount'] =$info['number'];
					$tlist[$kk]['colcount'] = M('collect_task')->where("taskid='".$val['id']."' and type='教师'")->count();
					$infos =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$vl['teacherid']."' and isend=1")->find();
					$tlist[$kk]['star'] = number_format($infos['star'],1);
					$tlist[$kk]['headimg'] =$info['headimg'];
					$tlist[$kk]['truename']=$info['nicename'];
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
		// 资源详情
		$info=M('task')->where("id='$id'")->find();
		// 发布者信息
		$uinfo =M('teacher')->where("id='".$info['userid']."'")->find();
		
		$uinfo['qcount'] = M('answer')->where("teacherid='".$uinfo['id']."'")->count();
		$uinfo['colcount'] = M('collect_task')->where("taskid='".$uinfo['id']."' and type='教师'")->count();
		
		
		$info['colcount'] = M('collect_task')->where("taskid='".$id."' and type='资源'")->count();


		// 相关推荐（同类型的文章）
		$relatelist =M('task')->where("isindex !=0 and type='资源' and id<>'".$info['id']."'")->limit(3)->order('isindex desc')->select();
		foreach ($relatelist as $key => $value) {
			$relatelist[$key]['colcount'] = M('collect_task')->where("taskid='".$value['id']."'")->count();
		}
		// 查看当前用户是否收藏该资源
		$iscollect =M('collect_task')->where("userid='".$_SESSION['student']['id']."' and taskid='".$info['id']."' and type='资源'")->find();
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
		$isreport =M('reports')->where("mid='".$_SESSION['student']['id']."' and tid='".$info['id']."' and type='资源'")->find();
		
		if($isreport)
		{
			$this->assign('isreport',1);
		}else{
			$this->assign('isreport',0);
		}
		// 查看累加次数
		M("task")->where("id='".$id."'")->setInc("clicknum");
		// 当前课程是否购买
		$ismall =M('orders')->where("tid='$id' and userid='".$_SESSION['student']['id']."' and orderstatus=1 and type='购买资源'")->count();
		$this->assign('ismall', $ismall);
		
		$content =json_decode($info['content'],true);
		$this->assign('imgaudio',$content);
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
		$this->assign('info', $info);
		$this->assign('uinfo', $uinfo);
		$this->assign('relatelist', $relatelist);
		// 计算综合评分
		$scorelist =M('taskscore')->where("taskid='".$id."' and type=2")->select();
		$totalscore=0.0;
		foreach($scorelist as $key=>$vv)
		{
			$totalscore+=$vv['score'];
		}
		if($totalscore>0)
		{
			$star =number_format($totalscore/count($scorelist),1);
			M('task')->where("id='$id'")->setField('star',$star);
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
		$this->assign('payurl',U('Home/Resource/dopay',array('tid'=>$info['id'],'teacherid'=>$uinfo['id'])));
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
				$data['taskid']=$id;
				$data['type']=2;
				$data['score']=$star;
				$result=M('taskscore')->add($data);
				if($result)
				{
					$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Resource/lesson_info',array('id'=>$id))));
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
				M('orders')->where("userid='$userid' and tid='$tid' and orderstatus=0 and type='购买资源'")->delete();	
				// 提成
				$option=M('options')->where("option_id='9'")->find();
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
					'type'=>'购买资源',
					'orderprice'=>$info['price'],
					'commission'=>$commission,
					'commission2'=>$commission2,
					'tccoin'  => round($info['price']*$ticheng['zypersent']/100,2),
					'ordersn'=>sp_get_order_sn(),
					'orderstatus'=>0,
					'addtime'=>time()
				);
				$res=M('orders')->add($orders);
				if($res)
				{
					//<!--*仅供测试使用-->
					// 学生是否有上级教师
					M('orders')->where("id='$res'")->setField('orderstatus',1);
					M('teacher')->where("id='".$teacherid."'")->setInc("coin",$orders['tccoin']);
					$data['coin'] =$orders['tccoin'];
					$data['orderid']=$res;
					$data['teacherid'] =$orders['teacherid'];
					$data['userid'] =$orders['userid'];
					$data['type'] =$orders['type'];
					M('commissionlog')->add($data);
					$techinfo=D()->field('m.*')->table(C('DB_PREFIX').'orders o,'.C('DB_PREFIX').'member m')->where("m.id=o.userid and o.id='".$res."'")->find();
					if($techinfo['agentid'])
					{
						M('teacher')->where("id='".$techinfo['agentid']."'")->setInc('coin',$commission2);
						$data['coin'] =$commission2;
						$data['orderid']=$res;
						$data['teacherid'] =$techinfo['agentid'];
						$data['userid'] =$orders['userid'];
						$data['type'] ='消费分红';
						M('commissionlog')->add($data);
						// 上级教师是否有代理
						$agentinfo =M('teacher')->where("id='".$techinfo['agentid']."'")->find();
						if($agentinfo['parentid'])
						{
							M('teacher')->where("id='".$agentinfo['parentid']."'")->setInc('coin',$commission);
							$data['coin'] =$commission;
							$data['orderid']=$res;
							$data['teacherid'] =$agentinfo['parentid'];
							$data['userid'] =$orders['userid'];
							$data['type'] ='代理分红';
							M('commissionlog')->add($data);
						}
					}
					//-----end-----//
					//redirect(U('WxJsAPI/jsApiCall',array('orderNum'=>$orders['ordersn'])));
				}			
			}
			if($tid && empty($teacherid))
			{
				$info =M('task')->field("title,price")->where("id='$tid'")->find();
				$userid =$_SESSION['student']['id'];
				$username =$_SESSION['student']['nicename'];
				M('orders')->where("userid='$userid' and tid='$tid' and orderstatus=0 and type='购买资源'")->delete();	
				// 提成
				$option=M('options')->where("option_id='9'")->find();
				$ticheng=json_decode($option['option_value'],true);
				$orders =array(
					'userid'=>$userid,
					'username'=>$username,
					'title'=>'标题：'.$info['title'],
					'teachername'=>'语文帮官方',
					'teacherid'=>0,
					'tid'=>$tid,
					'type'=>'购买资源',
					'orderprice'=>$info['price'],
					'tccoin'  => round($info['price']*$ticheng['zypersent']/100,2),
					'ordersn'=>sp_get_order_sn(),
					'orderstatus'=>0,
					'addtime'=>time()
				);
				$res=M('orders')->add($orders);
				if($res)
				{
					redirect(U('WxJsAPI/jsApiCall',array('orderNum'=>$orders['ordersn'])));
				}			
			}
			
	}
	function getresourcelist()
	{
		if(IS_POST)
		{
			$classtype =I('classtype','','trim');
			$keywords =I('keywords','','trim');
			$where =array("status=1 and type='资源'");
			if(!empty($classtype) && $classtype !='资源类型')
			{
				$where['classtype'] =$classtype;
			}
			if(!empty($keywords))
			{
				$where['title'] = array('like','%'.$keywords.'%');
			}
			$html='';
			$list =M('task')->where($where)->select();
			foreach ($list as $key => $va) {
				if($va['userid']==0)
				{
					$tinfo['headimg'] ='http://'.$_SERVER['HTTP_HOST'].'/data/upload/logo.png';
				}else
				{
					$tinfo =M('teacher')->field('id,headimg,nicename')->where("id='".$va['userid']."'")->find();
				}
				
				$list[$key]['colcount'] =M('collect_task')->where("taskid='".$va['id']."' and type='资源'")->count();
				$html.="<li class=\"content-item\" data-type=\"mrolesson\">
						<a href=".U('Home/Resource/lesson_info',array('id'=>$va['id']))." class=\"app-basis app-flex app-vertical-center\">
							<div class=\"teacher-avatar\">
								<img src='".$tinfo['headimg']."' alt='img'>
							</div>
							<div class=\"teacher-info app-basis\">
								<h4 style=\"font-size:.9rem; color:#595959\">".$va['title']."</h4>							
								<h5 class=\"ellipsis\" style=\"color:#999;font-size:.8rem\">".$va['classtype']."</h5>
								<h5 class=\"Line2\" style=\"font-size:.8rem\">".$va['brief']."</h5>
								<div class=\"content-info-num2 app-flex app-vertical-center\">
									<h4>".$va['clicknum']."";
							if($va['clicknum'] > '999')
							{
								$html.="+";
							}
							$html.="</h4>
									<h5>".$list[$key]['colcount']."";
							if($va['colcount']>'999')
							{
								$html.="+";
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
	// 收藏取消操作
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
				$data['type'] ='资源';
				$count=M('collect_task')->where("userid='".$data['userid']."' and taskid='$taskid' and type='资源'")->count();
				if($count > 0)
				{
					$this->ajaxReturn(array('status'=>0));
				}
				$res =M('collect_task')->add($data); 
				if($res)
				{
					$this->ajaxReturn(array('status'=>1));
				}
			}else//取消收藏
			{
				$res =M('collect_task')->where("type='资源' and taskid='$taskid' and userid ='".$_SESSION['student']['id']."'")->delete();
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