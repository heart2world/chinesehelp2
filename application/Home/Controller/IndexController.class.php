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
class IndexController extends Controller {
	const APPID = 'wx34dd37f9256128a8';	
    public function index(){
		$parentid =I('parentid','0','intval');
		// 微信授权
		if(!$_SESSION['student']['openid'])
		{			
		  $str=urlencode('http://'.$_SERVER['HTTP_HOST'].'/index.php?g=Home&m=Wexin&a=get_user&parentid='.$parentid);
		  $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.self::APPID.'&redirect_uri='.$str.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
		  header("location:$url");
		}else
		{
			if(!$_SESSION['student']['id'])
			{
				redirect(U('Home/public/login'));
			}
		}
		// 轮播图
		$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%2%'")->select();		
		foreach ($imgs as $k => $val) {
			if(!empty($val['post_img']))
			{
				$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
			}			
		}
		// 上架的平台公告
		$article =M('posts')->field('id,post_title,post_date,post_excerpt,link_url,post_img')->where("post_term=1 and post_status=1 and position like '%2%'")->order('post_date desc')->limit(5)->select();
		foreach ($article as $key => $value) {
			$article[$key]['post_excerpt'] = mb_substr(strip_tags($value['post_excerpt']),0,30,'utf-8');
			$article[$key]['addtime'] =  date('Y-m-d',strtotime($value['post_date']));
			if(!empty($value['post_img']))
			{
				$article[$key]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$value['post_img'];
			}	
		}
		// 我的提问或追问被老师回答时。
		$qcount=M('question')->where("userid='".$_SESSION['student']['id']."' and isread=0 and isdo=1")->count();
		
    	$this->assign('qcount',$qcount);
		$this->assign('article',$article);
		$this->assign('imgs',$imgs);
        $this->display();
    }
	public function getbang()
	{
		$type =I('type','0','intval');
		if($type < 3 || $type > 9)
		{
			redirect(U('Home/index/index'));
		}
		switch ($type) {
			case '3':
				$typename ='语文';
				// 轮播图
					$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%3%'")->select();		
					foreach ($imgs as $k => $val) {
						if(!empty($val['post_img']))
						{
							$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
						}			
					}
				break;
			case '4':
				$typename ='数学';
				$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%4%'")->select();		
				foreach ($imgs as $k => $val) {
					if(!empty($val['post_img']))
					{
						$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
					}			
				}
				break;
			case '5':
				$typename ='英语';
				$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%5%'")->select();		
				foreach ($imgs as $k => $val) {
					if(!empty($val['post_img']))
					{
						$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
					}			
				}
				break;
			case '6':
				$typename ='物理';
				$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%6%'")->select();		
				foreach ($imgs as $k => $val) {
					if(!empty($val['post_img']))
					{
						$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
					}			
				}
				break;
			case '7':
				$typename ='化学';
				$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%7%'")->select();		
				foreach ($imgs as $k => $val) {
					if(!empty($val['post_img']))
					{
						$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
					}			
				}
				break;
			case '8':
				$typename ='政治';
				$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%8%'")->select();		
				foreach ($imgs as $k => $val) {
					if(!empty($val['post_img']))
					{
						$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
					}			
				}
				break;
			case '9':
				$typename ='历史';
				$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=2 and position like '%9%'")->select();		
				foreach ($imgs as $k => $val) {
					if(!empty($val['post_img']))
					{
						$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
					}			
				}
				break;
			default:
				# code...
				break;
		}
		$this->assign('imgs',$imgs);
		$this->assign('typename',$typename);
		$this->assign('type',$type);
		// 平台精选
		//-- 资源/微课
		$indexlist =M('task')->field("id,type,classtype,brief,title,clicknum,isindex,userid")->where("status=1 and isindex != 0 and xueke='$typename'")->order('isindex DESC')->limit(3)->select();
		foreach($indexlist as $key=>$val)
		{		
			if($val['userid']==0)
			{
				$indexlist[$key]['questiontype'] ='未添加';
				$indexlist[$key]['username'] ='问学帮官方';
				$indexlist[$key]['headimg'] ='http://'.$_SERVER['HTTP_HOST'].'/data/upload/logo.png';
			}else
			{
				$info =M('teacher')->field('id,headimg,truename,questiontype')->where("id='".$val['userid']."'")->find();
				$indexlist[$key]['questiontype'] =$info['questiontype'];
				$indexlist[$key]['username'] =$info['truename'];
				$indexlist[$key]['headimg'] =$info['headimg'];
			}
			
			$indexlist[$key]['colcount'] =M('collect_task')->where("type='".$val['type']."' and taskid='".$val['id']."'")->count();
		}
		//---问答
		$qlist =M('question')->field("id,title,clicknum,star as brief,isindex,userid")->where("parentid=0 and isindex != 0 and isfree=2 and xueke='$typename'")->order('isindex DESC')->limit(3)->select();
		foreach ($qlist as $ky => $value) {
			$infos =M('member')->field('id,headimg,nicename')->where("id='".$value['userid']."'")->find();
			$qlist[$ky]['username'] =$infos['nicename'];
			$qlist[$ky]['headimg']  =$infos['headimg'];
			$qlist[$ky]['type'] ='问答';
			$qlist[$ky]['classtype'] ='';			
			$qlist[$ky]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
		}
		// 专题
		$ztlist =M('zhuantis')->field("id,title,desc,clicknum,sortorder,teacherid")->where("sortorder != 0 and xueke='$typename'")->order('sortorder desc')->select();
		foreach($ztlist as $k=>$vv)
		{
			$inf =M('teacher')->field('id,headimg,truename,questiontype')->where("id='".$vv['teacherid']."'")->find();
			$ztlist[$k]['questiontype'] =$inf['questiontype'];
			$ztlist[$k]['username'] =$inf['truename'];
			$ztlist[$k]['headimg'] =$inf['headimg'];
			$ztlist[$k]['brief'] =$vv['desc'];
			$ztlist[$k]['isindex'] =$vv['sortorder'];
			$ztlist[$k]['type'] ='专题';
			$ztlist[$k]['colcount'] =M('collect_task')->where("taskid='".$vv['id']."' and type='专题'")->count();
			unset($ztlist[$k]['desc']);
			unset($ztlist[$k]['sortorder']);
		}
		$newsarray1 =array_merge($indexlist,$ztlist);	
		$newsarray =array_merge($newsarray1,$qlist);		
		$sort = array(  
			'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
			'field'     => 'isindex',       //排序字段  
		);  
		$arrSort = array();  
		foreach($newsarray AS $uniqid => $row){  
			foreach($row AS $key1=>$value1){  
				$arrSort[$key1][$uniqid] = $value1;  
			}  
		}  		
		if($sort['direction']){  
			array_multisort($arrSort[$sort['field']], constant($sort['direction']), $newsarray);  
		}  		
		
		$this->assign('indexlist',$newsarray);
		$this->display();
	}
    public function tasklist()
    {
		$type =I('type','0','intval');
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
    	// 平台精选
		$indexlist =M('task')->field("id,type,classtype,brief,title,clicknum,isindex,userid")->where("status=1 and isindex !=0 and xueke='$typename'")->order('isindex DESC')->select();
		foreach($indexlist as $key=>$val)
		{
			if($val['userid']==0)
			{
				$indexlist[$key]['questiontype'] ='官方综合';
				$indexlist[$key]['username'] ='问学帮官方';
				$indexlist[$key]['headimg'] ='http://'.$_SERVER['HTTP_HOST'].'/data/upload/logo.png';
			}else
			{
				$info =M('teacher')->field('id,headimg,truename,questiontype')->where("id='".$val['userid']."'")->find();
				$indexlist[$key]['questiontype'] =$info['questiontype'];
				$indexlist[$key]['username'] =$info['truename'];
				$indexlist[$key]['headimg'] =$info['headimg'];
			}
			$indexlist[$key]['colcount'] =M('collect_task')->where("type='".$val['type']."' and taskid='".$val['id']."'")->count();
		}
		//---问答
		$qlist =M('question')->field("id,title,clicknum,star as brief,isindex,userid")->where("parentid=0 and isindex != 0 and isfree=2 and xueke='$typename'")->order('isindex DESC')->limit(3)->select();
		foreach ($qlist as $ky => $value) {
			$infos =M('member')->field('id,headimg,nicename')->where("id='".$value['userid']."'")->find();
			$qlist[$ky]['username'] =$infos['nicename'];
			$qlist[$ky]['headimg']  =$infos['headimg'];
			$qlist[$ky]['type'] ='问答';
			$qlist[$ky]['classtype'] ='';			
			$qlist[$ky]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
		}
		// 专题
		$ztlist =M('zhuantis')->field("id,title,desc,clicknum,sortorder,teacherid")->where("sortorder != 0 and xueke='$typename'")->order('sortorder desc')->select();
		foreach($ztlist as $k=>$vv)
		{
			$inf =M('teacher')->field('id,headimg,truename,questiontype')->where("id='".$vv['teacherid']."'")->find();
			$ztlist[$k]['questiontype'] =$inf['questiontype'];
			$ztlist[$k]['username'] =$inf['truename'];
			$ztlist[$k]['headimg'] =$inf['headimg'];
			$ztlist[$k]['brief'] =$vv['desc'];
			$ztlist[$k]['isindex'] =$vv['sortorder'];
			$ztlist[$k]['type'] ='专题';
			$ztlist[$k]['colcount'] =M('collect_task')->where("taskid='".$vv['id']."' and type='专题'")->count();
			unset($ztlist[$k]['desc']);
			unset($ztlist[$k]['sortorder']);
		}
		$newsarray1 =array_merge($indexlist,$ztlist);	
		$newsarray =array_merge($newsarray1,$qlist);		
		$sort = array(  
			'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
			'field'     => 'isindex',       //排序字段  
		);  
		$arrSort = array();  
		foreach($newsarray AS $uniqid => $row){  
			foreach($row AS $key1=>$value1){  
				$arrSort[$key1][$uniqid] = $value1;  
			}  
		}  		
		if($sort['direction']){  
			array_multisort($arrSort[$sort['field']], constant($sort['direction']), $newsarray);  
		}  		
		$this->assign('indexlist',$newsarray);
	
    	$this->display();
    }

    public function hotrecommend()
    {
    	// 平台精选围观最多
		$type=I('type','','intval');
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
		$indexlist =M('task')->field('id,type,classtype,brief,title,clicknum,userid')->where("status=1 and clicknum!=0 and xueke='$typename'")->order('clicknum DESC')->limit(10)->select();
		foreach($indexlist as $key=>$val)
		{
			if($val['userid']==0)
			{
				$indexlist[$key]['headimg'] ='http://'.$_SERVER['HTTP_HOST'].'/data/upload/logo.png';
				$indexlist[$key]['nicename']='问学帮官方';
				$indexlist[$key]['questiontype']='官方综合';
			}else
			{
				$tinfo =M('teacher')->field('id,truename,headimg,questiontype')->where("id='".$val['userid']."'")->find();
				$indexlist[$key]['headimg']=$tinfo['headimg'];
				$indexlist[$key]['nicename']=$tinfo['truename'];
				$indexlist[$key]['questiontype']=$tinfo['questiontype'];
			}
			$indexlist[$key]['colcount'] =M('collect_task')->where("type='".$val['type']."' and taskid='".$val['id']."'")->count();
		}
		$qlist =M('question')->field("id,title,clicknum,star as brief,isindex,userid")->where("parentid=0 and clicknum!=0 and isfree=2 and xueke='$typename'")->order('clicknum DESC')->select();		
		foreach ($qlist as $ky => $value) {
			$minfo =M('member')->field('headimg,nicename')->where("id='".$value['userid']."'")->find();
			$qlist[$ky]['headimg'] =$minfo['headimg'];
			$qlist[$ky]['type'] ='问答';
			$qlist[$ky]['classtype'] ='';
			$qlist[$ky]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
		}
		$newsarray =array_merge($indexlist,$qlist);		
		$sort = array(  
			'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
			'field'     => 'clicknum',       //排序字段  
		);  
		$arrSort = array();  
		foreach($newsarray AS $uniqid => $row){  
			foreach($row AS $key1=>$value1){  
				$arrSort[$key1][$uniqid] = $value1;  
			}  
		}  		
		if($sort['direction']){  
			array_multisort($arrSort[$sort['field']], constant($sort['direction']), $newsarray);  
		}  		
		$this->assign('indexlist',$newsarray);

		// 本周最新
		$indexlist2 =M('task')->field('id,type,classtype,brief,title,clicknum,addtime,userid')->where("status=1 and xueke='$typename' and YEARWEEK(date_format(addtime2,'%Y-%m-%d')) = YEARWEEK(now())")->order('addtime DESC')->select();
		foreach($indexlist2 as $key=>$val)
		{
			if($val['userid']==0)
			{
				$indexlist2[$key]['headimg'] ='http://'.$_SERVER['HTTP_HOST'].'/data/upload/logo.png';
			}else
			{
				$tinfo =M('teacher')->field('id,truename,headimg')->where("id='".$val['userid']."'")->find();
				$indexlist2[$key]['headimg']=$tinfo['headimg'];
			}
			$indexlist2[$key]['colcount'] =M('collect_task')->where("type='".$val['type']."' and taskid='".$val['id']."'")->count();
		}
		$qlist2 =M('question')->field("id,title,clicknum,star as brief,isindex,addtime,userid")->where("parentid=0 and xueke='$typename' and isfree=2 and YEARWEEK(date_format(addtime2,'%Y-%m-%d')) = YEARWEEK(now())")->order('addtime DESC')->select();
		
		foreach ($qlist2 as $ky => $value) {
			$minfo =M('member')->field('headimg,nicename')->where("id='".$value['userid']."'")->find();
			$qlist2[$ky]['headimg'] =$minfo['headimg'];
			$qlist2[$ky]['type'] ='问答';
			$qlist2[$ky]['classtype'] ='';
			$qlist2[$ky]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
		}

		$newsarray2 =array_merge($indexlist2,$qlist2);		
		$sort = array(  
			'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
			'field'     => 'addtime',       //排序字段  
		);  
		$arrSort2 = array();  
		foreach($newsarray2 AS $uniqid => $row){  
			foreach($row AS $key1=>$value1){  
				$arrSort2[$key1][$uniqid] = $value1;  
			}  
		}  		
		if($sort['direction']){  
			array_multisort($arrSort2[$sort['field']], constant($sort['direction']), $newsarray2);  
		}  		
		$this->assign('indexlist2',$newsarray2);
    	$this->display();
    }
	public function articlelist()
	{
		// 上架的平台公告
		$article =M('posts')->field('id,post_title,post_date,post_excerpt,link_url,post_img')->where("post_term=1 and post_status=1 and position like '%2%'")->order('post_date desc')->select();
		
		foreach ($article as $key => $value) {
			$article[$key]['post_excerpt'] = mb_substr(strip_tags($value['post_excerpt']),0,30,'utf-8');
			$article[$key]['addtime'] =  date('Y-m-d',strtotime($value['post_date']));
			if(!empty($value['post_img']))
			{
				$article[$key]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$value['post_img'];
			}
		}
		$this->assign('article',$article);
		$this->display();
	}
	 //定时执行的方法
    public function crons() { 
        //每天晚上0点给教师推送结算昨日总获得的钱的通知（包括资源、微课抽成、充电的抽成），0元的不推送 
		
		$tlist =M('teacher')->where("id,openid,nicename,truename")->where("status=1")->select();
		foreach($tlist as $k=>$v)
		{
			$tlist[$k]['tprice'] = M('orders')->where("teacherid='".$v['id']."' and (TO_DAYS(NOW()) - TO_DAYS(addtime2) = 1) and orderstatus=1 and istuisong=0")->sum('tccoin');
			$tlist[$k]['tprice'] = $tlist[$k]['tprice'] ? $tlist[$k]['tprice'] :'0';
			if(!empty($tlist[$k]['tprice']))
			{
				// 推送模板
				
				// 推送成功
				$orlist =M('orders')->field('id')->where("teacherid='".$v['id']."' and (TO_DAYS(NOW()) - TO_DAYS(addtime2) = 1) and orderstatus=1 and istuisong=0")->select();
				foreach($orlist as $ky=>$val)
				{
					M('orders')->where("id='".$val['id']."'")->setField('istuisong',1);
				}
			}
		}
		// 学生打分后的2小时自动公开未操作问题是否私密问题
		$time =time()-7200;
		$qlist=M('question')->field('id')->where("isfree=0 and parentid=0 and isend=1 and scoretime <= '".$time."'")->select();
		
		foreach($qlist as $kk=>$vv)
		{
			M('question')->where("id='".$vv['id']."'")->setField('isfree',2);
		}
    }
	
}
?>