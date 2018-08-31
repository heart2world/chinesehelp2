<?php
// +----------------------------------------------------------------------
// | 问答管理  
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
use \Qiniu\Auth;
use \Qiniu\Storage\UploadManager;
use \Qiniu\Storage\BucketManager;
class ProblemController extends Controller {
	//const APPID ='wx34dd37f9256128a8';
    //const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	const APPID='wx72b76eb517a03d9e';
	const APPSECRET='7ba7e78c8702fcf19991c166c7910134';
	public function pub()
	{
		// 在线老师
		$tlist =M('teacher')->field('id,nicename,headimg,honors,isonline')->where("status=1 and isonline=1")->order('number desc')->select();
		foreach($tlist as $k=>$val){
			$tlist[$k]['qcount'] = M('answer')->where("teacherid='".$val['id']."'")->count();
			$tlist[$k]['colcount'] = M('collect_task')->where("taskid='".$val['id']."' and type='教师'")->count();
			$info =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$val['id']."'")->find();
			$tlist[$k]['star'] = number_format($info['star'],1);
		}
		// 热门问题
		$qrlist =M('question')->where("parentid=0")->order('isindex desc')->limit(3)->select();
		foreach ($qrlist as $key => $value) {
			$minfo =M('member')->field('headimg,nicename')->where("id='".$value['userid']."'")->find();
			$qrlist[$key]['mnicename'] =$minfo['nicename'];
			$qrlist[$key]['headimg'] =$minfo['headimg'];
			$qrlist[$key]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
		}
		$this->assign('qrlist',$qrlist);
		$this->assign('tlist',$tlist);
		$this->display();
	}
	//直接提问
	public function pub_question()
	{
		$this->checklogin();
    	$this->checkuser();
		$id=I('id','','intval');
		$parentid =I('parentid','','intval'); // $parentid >0 追问提问；
		if($parentid > 0)
		{			
			$pinfo =M('question')->where("id='$parentid'")->find();
			if(empty($pinfo))
			{
				redirect('./');
			}
		}
		$tinfo =M('teacher')->find($id);
		$tinfo['qcount'] =M('answer')->where("teacherid='".$tinfo['id']."'")->count();
		$tinfo['colcount'] =M('collect_task')->where("taskid='".$tinfo['id']."' and type='教师'")->count();
		$info =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$id."' and isend=1")->find();
        $tinfo['star'] = number_format($info['star'],1);
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID, self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		$this->assign('tinfo',$tinfo);
		$this->assign('parentid',$parentid);
		$this->display();
	}
	// 提问保存
	function questionaddinfo()
	{
		if(IS_POST)
		{
			$pdata =I('post.');			
			if($pdata['content'])
			{
				$adata=array();
				foreach($pdata['content'] as $k=>$value)
				{
					$adata[$k]['text'] =$value;
					$adata[$k]['type'] =$pdata['atype'][$k];
					$adata[$k]['atime'] =$pdata['atime'][$k];
				}
				$data['content'] =json_encode($adata);
			}
			$data['teacherid'] =$pdata['teacherid'];
			$data['title']     =$pdata['qname'];
			$data['userid']    =$_SESSION['student']['id'];
			$data['xueke']    =M('teacher')->where("id='".$pdata['teacherid']."'")->getField('xueke');
			$data['parentid'] =$pdata['parentid']; 
			if(intval($pdata['parentid']) > 0)
			{
				$data['type']     =1;  // 追问提问
			}else{
				$data['type']     =0;  // 首次提问
			}
			$data['nicename'] =$_SESSION['student']['nicename'];
			$data['addtime'] =time();
			$data['addtime2']=date('Y-m-d H:i:s');
			$result=M('question')->add($data);
			if($result)
			{
				// 模板推送
				$info=M('teacher')->field('openid,mobile')->where("id='".$data['teacherid']."'")->find();
				$info['id'] =$result;
				$info['title'] = $data['title'];
				send_msgto($info['mobile']);
				$this->ajaxReturn(array('status'=>1));
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
								 
				 $this->ajaxReturn(array('status'=>1,'imgurl'=>$imgurl,'strimgurl'=>$strimgurl));
			}else{
				$this->ajaxReturn(array('status'=>0));
			}
		}
	}
	// 选择提问
	public function online_select_teacher()
	{
		// 平台推荐教师
		$this->checklogin();
    	$this->checkuser();
		$list=M('answer')->field("teacherid,count(*)as number")->where("YEARWEEK(date_format(addtime2,'%Y-%m-%d')) = YEARWEEK(now())")->group('teacherid')->order('number desc')->limit(3)->select();
		$list2=M('answer')->field("teacherid,count(*)as number")->where("YEARWEEK(date_format(addtime2,'%Y-%m-%d')) = YEARWEEK(now())-1")->group('teacherid')->order('number desc')->limit(3)->select();
		
		if(count($list)<3)
		{
			// 上周的回答数
			if(count($list2)<3)
			{
				$tlist =M('teacher')->where("isonline=1")->limit(3)->order("number desc")->select();
				foreach ($tlist as $k => $val) {
					$tlist[$k]['qcount'] = $val['number'];
					$tlist[$k]['colcount'] = M('collect_task')->where("taskid='".$val['id']."' and type='教师'")->count();
					$info =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$val['id']."' and isend=1")->find();
					$tlist[$k]['star'] = number_format($info['star'],1);
				}
			}else
			{
				foreach($list2 as $kk=>$vl)
				{
					$info =M('teacher')->field('id,honors,star,nicename,truename,headimg,number')->where("id='".$vl['teacherid']."'")->find();
					$tlist[$kk]['id'] =$info['id'];
					$tlist[$kk]['qcount'] =$info['number'];
					$tlist[$kk]['colcount'] = M('collect_task')->where("taskid='".$info['id']."' and type='教师'")->count();
					$infos =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$vl['teacherid']."' and isend=1")->find();
					$tlist[$kk]['star'] = number_format($infos['star'],1);
					$tlist[$kk]['headimg'] =$info['headimg'];
					$tlist[$kk]['truename'] =$info['truename'];
				}
			}
		}else{
			foreach($list as $kk=>$vl)
				{
					$info =M('teacher')->field('id,honors,nicename,truename,headimg,number')->where("id='".$vl['teacherid']."'")->find();
					$tlist[$kk]['id'] =$info['id'];
					$tlist[$kk]['qcount'] =$info['number'];
					$tlist[$kk]['colcount'] = M('collect_task')->where("taskid='".$info['id']."' and type='教师'")->count();
					$infos =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$vl['teacherid']."' and isend=1")->find();
					$tlist[$kk]['star'] = number_format($infos['star'],1);
					$tlist[$kk]['headimg'] =$info['headimg'];
					$tlist[$kk]['truename'] =$info['truename'];
				}
		}
		//file_put_contents('a2222.txt',var_export($tlist,true));
		$this->assign("tlist",$tlist);
		$this->display();
	}
	public function detail()
	{
		$id=I('id','','intval');
		$this->checklogin();
    	$this->checkuser();
		// 主问题
		$qinfo = M('question')->where("id='$id' and parentid=0")->find();
		// 指定教师信息
		$uinfo =M('teacher')->where("id='".$qinfo['teacherid']."'")->find();
		$uinfo['colcount'] =M('collect_task')->where("taskid='".$uinfo['id']."' and type='教师'")->count();
		$qinfo['content'] =json_decode($qinfo['content'],true);		
		$this->assign('imgtaudio',$qinfo['content']);
		
		$this->assign('uinfo',$uinfo);

		// 查看当前用户是否收藏该教师
		$iscollect =M('collect_task')->where("userid='".$_SESSION['student']['id']."' and taskid='".$uinfo['id']."' and type='教师'")->find();
		if($iscollect)
		{
			$this->assign('iscollect',1);
		}
		// 查看当前用户是否收藏该问答
		$iscollect2 =M('collect_task')->where("userid='".$_SESSION['student']['id']."' and taskid='".$qinfo['id']."' and type='问答'")->find();		
		if($iscollect2)
		{
			$this->assign('iscollect2',1);
		}
		// 查看当前用户是否举报该问答
		$isquestion =M('reports')->where("mid='".$_SESSION['student']['id']."' and tid='".$qinfo['id']."' and type='问答'")->find();
		if($isquestion)
		{
			$this->assign('isquestion',1);
		}
		// 主问题回答
		$aninfo =M('answer')->where("questionid='$id' and teacherid='".$uinfo['id']."'")->find();
		if($aninfo)
		{
			$atime =time()-$aninfo['addtime'];
			$lesstime =120-round($atime/60);
			$aninfo['content'] =json_decode($aninfo['content'],true);		
			$this->assign('imgtaudio1',$aninfo['content']);
			$this->assign('aninfo',$aninfo);
			// 两小时自动结束
			if($qinfo['isend'] ==0 && $lesstime <= 0)
			{
				M('question')->where("id='".$qinfo['id']."'")->save(array('isend'=>1,'star'=>5));
				$qinfo['isend'] =1;
			}
			$this->assign('lesstime',$lesstime);
			$this->assign('atime',$atime);
			// 追问问题
			$agqinfo =M('question')->where("parentid='".$qinfo['id']."' and teacherid='".$uinfo['id']."'")->find();
			if($agqinfo)
			{
				$agqinfo['content'] =json_decode($agqinfo['content'],true);		
				$this->assign('imgtaudio2',$agqinfo['content']);
				$this->assign('agqinfo',$agqinfo);
				// 追问回答
				 $anaginfo =M('answer')->where("questionid='".$agqinfo['id']."' and teacherid='".$uinfo['id']."'")->find();
				 if($anaginfo)
				 {
					$anaginfo['content'] =json_decode($anaginfo['content'],true);		
					$this->assign('imgtaudio3',$anaginfo['content']);
				 	$this->assign('anaginfo',$anaginfo);
				 }
			}
		}
		//echo $iscollect2.'|'.$qinfo['isend'];
		// 不显示边框
		if(!empty($iscollect2) && $qinfo['isend'] == 0)
		{
			$this->assign('isshowcss',1);
		}
		else if(empty($iscollect2) && $qinfo['isend'] == 0)
		{
			$this->assign('isshowcss',2);
		}else if(empty($iscollect2)  && $qinfo['isend'] == 1){
			$this->assign('isshowcss',3);
		}elseif (!empty($iscollect2)  && $qinfo['isend'] == 1){
			$this->assign('isshowcss',4);
		}
		// 查看累加次数
		M("question")->where("id='".$id."'")->setInc("clicknum");
		if($_SESSION['student']['id']== $qinfo['userid'])
		{
			$this->assign('isuser',1);
		}
		$this->assign('qinfo',$qinfo);
		$this->display();
	}
	// 打分
	public function give_score()
	{
		$this->checklogin();
    	$this->checkuser();
		$id=I('id','','intval');
		$qinfo = M('question')->where("id='$id' and userid='".$_SESSION['student']['id']."' and parentid=0")->find();

		$this->assign("qinfo",$qinfo);
		$this->display();
	}
	function docore()
	{
		if(IS_POST)
		{
			$id =I('id','','intval');
			$cores =I('cores','','trim');
			$qinfo = M('question')->where("id='$id' and userid='".$_SESSION['student']['id']."' and parentid=0")->find();
			if(!empty($qinfo))
			{
				if($qinfo['isend'] == 0)
				{
					$totcore =0;
					foreach ($cores as $key => $value) {
						$totcore +=$value;
					}
					$star =number_format($totcore/4,1);
					$result=M('question')->where("id='$id'")->save(array('star'=>$star,'isend'=>1));
					if($result)
					{
						$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Problem/dopay',array('tid'=>$id,'teacherid'=>$qinfo['teacherid'])),'url2'=>U('Home/Problem/detail',array('id'=>$id))));
					}
				}else
				{
					$this->ajaxReturn(array('status'=>0,'msg'=>'已经打过分啦'));
				}
			}
		}
	}
	// 充电下单跳转微信支付
	public function dopay()
	{
		if(IS_POST)
		{
			$tid=I('id','','intval');
			$price =I('price','','trim');
			if($price > 0)
			{
				$qinfo = M('question')->where("id='$tid' and parentid=0")->find();
				$uinfo =M('teacher')->field('nicename')->where("id='".$qinfo['teacherid']."'")->find();
				$userid =$_SESSION['student']['id'];
				$username =$_SESSION['student']['nicename'];
				M('orders')->where("userid='$userid' and tid='$tid' and orderstatus=0 and type='为TA充电'")->delete();
				// 提成
				$option =M('options')->where("option_id='9'")->find();
				$ticheng=json_decode($option['option_value'],true);
				// 代理教师提成
				$commission = round($ticheng['teacherpersent']*$price/100,2);
				// 学生上级提成
				$commission2 = round($ticheng['studentpersent']*$price/100,2);				
				$orders =array(
						'userid'=>$userid,
						'username'=>$username,
						'title'=>'标题：'.$qinfo['title'],
						'teachername'=>$uinfo['nicename'],
						'teacherid'=>$qinfo['teacherid'],
						'tid'=>$tid,
						'type'=>'为TA充电',
						'orderprice'=>$price,
						'commission'=>$commission,
						'commission2'=>$commission2,
						'tccoin'  => round($price*$ticheng['cdpersent']/100,2),
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
					$this->ajaxReturn(array('status'=>1,'url'=>U('WxJsAPI/jsApiCall',array('orderNum'=>$orders['ordersn']))));
				}			
			}else{
				//M('question')->where("id='".$tid."'")->save(array('isend'=>1));
				$this->ajaxReturn(array('status'=>1,'url2'=>U('Home/Problem/detail',array('id'=>$tid))));
			}			
		}
	}
	// 举报此内容
	public function tipoff()
	{
		$id =I('id','','intval');
		$atype =I('atype','','intval');
		if($atype > 0)
		{
			$qinfo =M('task')->find($id);
			if($atype==1)
			{
				$qinfo['colcount'] =M('collect_task')->where("taskid='".$qinfo['id']."' and type='微课'")->count();	
			}else
			{
				$qinfo['colcount'] =M('collect_task')->where("taskid='".$qinfo['id']."' and type='资源'")->count();	
			}
		}
		else
		{
			// 主问题
			$qinfo = M('question')->where("id='$id' and parentid=0")->find();
			$qinfo['colcount'] =M('collect_task')->where("taskid='".$qinfo['id']."' and type='问答'")->count();			
		}
		$this->assign('qinfo',$qinfo);
		$this->assign('atype',$atype);
		$this->display();
	}
	// 举报保存操作
	function doreport()
	{
		if(IS_POST)
		{
			$reason =I('reason','','trim');
			$userid = $_SESSION['student']['id'];
			$tid =I('tid','','intval');
			$atype =I('atype','','intval');
			
			 switch ($atype) {
				case '1':
					$type='微课';
					$count =M('reports')->where("tid='$tid' and mid='$userid' and type='微课'")->count();
					if($count > 0)
					{
						$this->ajaxReturn(array('status'=>0));
					}
					$info =M("task")->field("title,userid,addtime,brief,content")->where("id='$tid'")->find();
					$teacherid =$info['userid'];					
					$teachername =M('teacher')->where("id='".$info['userid']."'")->getField('nicename');
					break;
				case '2':
					$type='资源';
					$count =M('reports')->where("tid='$tid' and mid='$userid' and type='资源'")->count();
					if($count > 0)
					{
						$this->ajaxReturn(array('status'=>0));
					}
					$info =M("task")->field("title,userid,addtime,brief,content")->where("id='$tid'")->find();
					$teacherid =$info['userid'];
					if($info['userid']>0)
					{						
						$teachername =M('teacher')->where("id='".$info['userid']."'")->getField('nicename');
					}else{
						$teachername='语文帮官方';
					}
					break;
				default:
					$type='问答';
					$count =M('reports')->where("tid='$tid' and mid='$userid' and type='问答'")->count();
					if($count > 0)
					{
						$this->ajaxReturn(array('status'=>0));
					}
					$info =M("question")->field("title,teacherid,addtime,content")->where("id='$tid'")->find();
					$teacherid =$info['teacherid'];
					$teachername =M('teacher')->where("id='".$info['teacherid']."'")->getField('nicename');
					break;
			}
			
			if(empty($teachername) || empty($info['title']))
			{
				$this->ajaxReturn(array('status'=>0,'url'=>U('Home/Task/lesson_info',array('id'=>$tid))));
			}
			$data =array(
				'tid'  =>$tid,
				'mid'  =>$userid,
				'title'=>$info['title'],
				'teachername'=>$teachername,
				'teacherid'=>$teacherid,
				'type'=>$type,
				'rcontent'=>$info['content'],
				'brief'=>$info['brief'],
				'lefttime'=>$info['addtime'],
				'content'=>$reason,
				'addtime'=>time(),
				'status'=>1
				);
			$res=M('reports')->add($data);
			
			if($res)
			{
				switch ($atype) {
					case '1':
						$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Task/lesson_info',array('id'=>$tid))));
						break;
					case '2':
						$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Resource/lesson_info',array('id'=>$tid))));
						break;
					default:
						$this->ajaxReturn(array('status'=>1,'url'=>U('Home/Problem/detail',array('id'=>$tid))));
						break;
				}
				
			}
		}
	}
	// 教师收藏取消操作
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
				$data['type'] ='教师';
				$count=M('collect_task')->where("userid='".$data['userid']."' and taskid='$taskid' and type='教师'")->count();
				if($count > 0)
				{
					$this->ajaxReturn(array('status'=>0));
				}
				$res =M('collect_task')->add($data); 
				if($res)
				{
					$collectnum=M('collect_task')->where("taskid='$taskid' and type='教师'")->count();
					$this->ajaxReturn(array('status'=>1,'collectnum'=>$collectnum));
				}
			}else//取消收藏
			{
				$res =M('collect_task')->where("type='教师' and taskid='$taskid' and userid ='".$_SESSION['student']['id']."'")->delete();
				
				if($res)
				{
					$collectnum=M('collect_task')->where("taskid='$taskid' and type='教师'")->count();
					$this->ajaxReturn(array('status'=>1,'collectnum'=>$collectnum));
				}
			}
		}
	}
	// 问答收藏取消操作
	function collect2()
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
				$data['type'] ='问答';
				$count=M('collect_task')->where("userid='".$data['userid']."' and taskid='$taskid'")->count();
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
				$res =M('collect_task')->where("type='问答' and taskid='$taskid' and userid ='".$_SESSION['student']['id']."'")->delete();
				if($res)
				{
					$this->ajaxReturn(array('status'=>1));
				}
			}
		}
	}

	// 搜索问答
	function searchquestion()
	{
		if(IS_POST)
		{
			$keywords =I('keywords','','trim');
			$xueke =I('xueke','','trim');
			$where ='';
			if(!empty($xueke))
			{
				$where = " and xueke='$xueke'";
			}
			$qlist =M('question')->where("parentid=0 and isfree=2 and title like '%".$keywords."%'".$where)->select();
			
			$html='';
			if(count($qlist) > 0)
			{
				$html.="<ul class=\"content-list\">";
				foreach ($qlist as $key => $value) {
					$colcount =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
					$minfo =M('member')->field('headimg,nicename')->where("id='".$value['userid']."'")->find();
					$html.="<li class=\"content-item\" data-type=\"requestion\">
								<a href='".U('Home/Problem/detail',array('id'=>$value['id']))."' class=\"app-flex app-vertical-center\">
									<div class=\"student-avatar\" style=\"float:left\">
										<img src='".$minfo['headimg']."' alt=\"img\">
									</div>
									<div class=\"student-info app-basis\">
										<h4 style=\"font-size:1rem; color:#333\">".$minfo['nicename']."<span style=\"float:right; font-size:.8rem;color:#999\">".date('Y-m-d',$value['addtime'])."</span></h4>
										<h4 style=\"font-size:.9rem;color:#999; white-space:nowrap;overflow:hidden;text-overflow:ellipsis;\">".$value['title']."</h4>
										<h4 style=\"font-size:.9rem;color:#999\">回答满意度:".$value['star']."</h4>
										
									</div>
								</a>
							</li>";
				}
				$html.="</ul>";
				$this->ajaxReturn(array('status'=>1,'html'=>$html));
			}else
			{
				$this->ajaxReturn(array('status'=>0,'msg'=>'无搜索结果'));
			}
		}
	}
	function getpost()
    {
    	if(IS_POST)
    	{
    		$media_id =trim($_POST['serverId']);
			$access_token =trim($_POST['access_token']);
			$chatime =intval($_POST['chatime']);
			
			$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;  
			$filedata = file_get_contents($url);
			if($filedata)
			{
				$imgurl = "./data/upload/luyin/".$media_id.".amr";
				$this->downAndSaveFile($url,$imgurl);
				$strfileurl=$this->upchange($imgurl,$media_id);	
				$ctime =floor($chatime/1000);// 取整
			    $this->ajaxReturn(array('status'=>1,'strfileurl'=>$strfileurl,'chatime'=>$ctime));
			}else{
				$this->ajaxReturn(array('status'=>0));
			}
    	}
    }
	
	//将本地amr音频文件上传至七牛云并转码生成MP3文件
  	function upchange($filePath,$mediaid){    
        import('Qiniu.functions');
        $setting=C('UPLOAD_SITEIMG_QINIU');
		
	    $accessKey = $setting['driverConfig']['accessKey'];      //七牛公钥    
	    $secretKey = $setting['driverConfig']['secrectKey'];      //七牛私钥    
	    $auth = new Auth($accessKey, $secretKey);    
	           
	    $bucket = trim($setting['driverConfig']['bucket']);    
	    //数据处理队列名称,不设置代表不使用私有队列，使用公有队列。    
	    $pipeline = 'arsenal';    
	            
	    //通过添加'|saveas'参数，指定处理后的文件保存的bucket和key    
	    //不指定默认保存在当前空间，bucket为目标空间，后一个参数为转码之后文件名     
	    $savekey = \Qiniu\base64_urlSafeEncode($bucket.':'.$mediaid.'.mp3');  
		 
	    //设置转码参数    
	    $fops = "avthumb/mp3/ab/320k/ar/44100/acodec/libmp3lame";    
	    $fops = $fops.'|saveas/'.$savekey;    
	    if(!empty($pipeline)){  //使用私有队列    
	        $policy = array(    
	            'persistentOps' => $fops,    
	            'persistentPipeline' => $pipeline    
	        );    
	    }else{                  //使用公有队列    
	        $policy = array(    
	            'persistentOps' => $fops    
	        );    
	    }    
	            
	    //指定上传转码命令    
	    $uptoken = $auth->uploadToken($bucket, null, 3600, $policy);   
		
	    $key = $mediaid.'.amr'; //七牛云中保存的amr文件名    
	    $uploadMgr = new UploadManager();    
	            
	    //上传文件并转码$filePath为本地文件路径    
	    list($ret, $err) = $uploadMgr->putFile($uptoken, $key, $filePath);  
	    if ($err !== null) {    
	        return false;    
	    }else {    
			//此时七牛云中同一段音频文件有amr和MP3两个格式的两个文件同时存在    
			$bucketMgr = new BucketManager($auth);  			
			//为节省空间,删除amr格式文件    
			$results=$bucketMgr->delete($bucket, $key);     
			$url = "http://".$setting['driverConfig']['domain']."/".$mediaid.".mp3";			
			//$bendiurl ='./data/upload/luyin/'.$mediaid.'.mp3';
			//$this->downAndSaveFile($url,$bendiurl);
			@unlink('./data/upload/luyin/'.$mediaid.'.amr');
			return $url;    
		}    
	}  

    //根据URL地址，下载文件
	function downAndSaveFile($url,$savePath){
	    ob_start();
	    readfile($url);
	    $img  = ob_get_contents();
	    ob_end_clean();
	    $size = strlen($img);
	    $fp = fopen($savePath, 'a');
	    fwrite($fp, $img);
	    fclose($fp);
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