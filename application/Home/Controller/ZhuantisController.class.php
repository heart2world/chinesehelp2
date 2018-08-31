<?php
/**
 * 	 专题管理
 */
namespace Home\Controller;
use Think\Controller;
class ZhuantisController extends Controller {
	const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	
	//我的专题
	public function index()
	{
		
		$type =I('type','','intval');
		if($type < 3 || $type > 9)
		{
			redirect(U('Home/index/index'));
		}
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
		$ztlist =M('zhuantis')->where("xueke='".$typename."'")->order('addtime desc')->select();
		foreach($ztlist as $key=>$v)
		{
			$tinfo =M('teacher')->field('id,truename,headimg,questiontype')->where("id='".$v['teacherid']."'")->find();
			$ztlist[$key]['truename'] =$tinfo['truename'];
			$ztlist[$key]['headimg'] =$tinfo['headimg'];
			$ztlist[$key]['questiontype'] =$tinfo['questiontype'];
			$ztlist[$key]['colcount'] =M('collect_task')->where("taskid='".$v['id']."' and type='专题'")->count();
		}
		$this->assign('list', $ztlist);
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
	// 搜索专题
	function searchztlist()
	{
		if(IS_POST)
		{
			$keywords =I('keywords','','trim');
			$qlist =M('zhuantis')->where("title like '%".$keywords."%'")->select();
			$html='';
			if(count($qlist) > 0)
			{
				foreach ($qlist as $key => $value) {
					$tinfo =M('teacher')->field('id,truename,headimg,questiontype')->where("id='".$value['teacherid']."'")->find();
					$colcount =M('collect_task')->where("taskid='".$value['id']."' and type='专题'")->count();
					
					$html.="<li class=\"content-item\" data-type=\"mrolesson\">
								<a href='".U('Home/Zhuantis/ztinfo',array('id'=>$value['id']))."' class=\"app-flex\" style=\"display:flex\">
								<div class=\"headImg\" style=\"align-self:flex-start\">
									<img src='".$tinfo['headimg']."' alt=\"img\">
								</div>
								<div class=\"app-basis\" style=\"width:1%\">
									<div style=\"font-size:.8rem\">".$tinfo['truename']."</div>							
									<h4 class=\"ellipsis\" style=\"font-size:.8rem;color:#999\">".$tinfo['questiontype']."</h4>
									<div class=\"ellipsis\" style=\"font-size:.8rem\">".$value['title']."</div>							
										<h5 style=\"font-size:.8rem;color:#999;\">专题简介 :&nbsp;".$value['desc']."</h5>
									<h5 class=\"Line2\" style=\"color:#999;font-size:.8rem;\">综合评分 :&nbsp;";
								if($value['compoint'] !='0.0')
								{
									$html.=$value['compoint']."</h5>";
								}else
								{
									$html.="暂无评分</h5>";
								}	
								$html.="<div class=\"content-info-num3 app-flex app-vertical-center\" style=\"margin-top:.5rem\">
										<h4>".$value['clicknum']."";
								if($value['clicknum'] > 999)
								{
									$html.="+";
								}									
								$html.="</h4><h5>".$colcount."";
								if($colcount > '999')
								{
									$html .= "+";
								}
								$html.="</h5>
									</div>
								</div>
								</a>
							</li>";
				}
				$this->ajaxReturn(array('status'=>1,'html'=>$html));
			}else
			{
				$this->ajaxReturn(array('status'=>0,'msg'=>'无搜索结果'));
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
		$this->checklogin();
    	$this->checkuser();
		$ztid =I('id','','intval');
		// 专题信息
		//
		$info=M('zhuantis')->where("id='$ztid'")->find();		
		$info['colcount'] =M('collect_task')->where("taskid='".$info['id']."' and type='专题'")->count();
		$info['iscollect'] =M('collect_task')->where("taskid='".$info['id']."' and userid='".$_SESSION['student']['id']."' and type='专题'")->count();

		$this->assign('info',$info);
		// 教师信息
		$tinfo =M('teacher')->where("id='".$info['teacherid']."'")->find();
		$tinfo['qcount'] =M('answer')->where("teacherid='".$tinfo['id']."'")->count();
		$tinfo['colcount'] =M('collect_task')->where("taskid='".$tinfo['id']."' and type='教师'")->count();
		$tinfo['iscollect'] =M('collect_task')->where("taskid='".$tinfo['id']."' and userid='".$_SESSION['student']['id']."' and type='教师'")->count();
		$this->assign('tinfo',$tinfo);
		
		
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
		
		M('zhuantis')->where("id='$ztid'")->setInc('clicknum');
		$this->display();
	}
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
				$data['type'] ='专题';
				$count=M('collect_task')->where("userid='".$data['userid']."' and taskid='$taskid' and type='专题'")->count();
				if($count > 0)
				{
					$this->ajaxReturn(array('status'=>0));
				}
				$res =M('collect_task')->add($data); 
				if($res)
				{
					$collectnum=M('collect_task')->where("taskid='$taskid' and type='专题'")->count();
					$this->ajaxReturn(array('status'=>1,'collectnum'=>$collectnum));
				}
			}else//取消收藏
			{
				$res =M('collect_task')->where("type='专题' and taskid='$taskid' and userid ='".$_SESSION['student']['id']."'")->delete();
				
				if($res)
				{
					$collectnum=M('collect_task')->where("taskid='$taskid' and type='专题'")->count();
					$this->ajaxReturn(array('status'=>1,'collectnum'=>$collectnum));
				}
			}
		}
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
				$this->ajaxReturn(array('status'=>1,'msg'=>'添加成功','url'=>U('Portal/zhuantis/index')));
			}
			else
			{
				$this->ajaxReturn(array('status'=>0,'msg'=>'添加失败'));
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