<?php
// +----------------------------------------------------------------------
// | 教师管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TeacherController extends AdminbaseController {
	public function index()
	{
		$where = array("nicename !=''");
		/**搜索条件**/
		$schoolname = I('request.schoolname');
		$title = I('request.xueke');
		$status = I('status','-1','intval');
		$nicename = trim(I('request.nicename'));
		$starttime =I('starttime','','trim');
        $endtime   =I('endtime','','trim');
		if($schoolname){
			$where['schoolname'] = array('like',"%$schoolname%");
			$this->assign('schoolname',$schoolname);
		}
		if($title){
			$where['xueke'] = array('like',"%$title%");
			$this->assign('title',$title);
		}
		if($status !='-1'){
			$where['status'] = $status;
			$this->assign('status',$status);
		}
		if($nicename){
			$where['nicename'] = array('like',"%$nicename%");
			$this->assign('nicename',$nicename);
		}
		if(!empty($starttime))
        {
            $where['addtime']=array(
                array('EGT',strtotime($starttime))
            );
        }
        if(!empty($endtime))
        {
            array_push($where['addtime'], array('ELT',strtotime($endtime.' 23:59:59')));
        }       	
		$count=M('teacher')->where($where)->count();
		$page = $this->page($count, 20);
        $list = M('teacher')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
		//echo M('teacher')->getLastSql();
        $todaymonth =date('Y-m');
		foreach ($list as $key => $value) {
			// 教龄自动加1
			if($todaymonth == $value['tyear'])
			{
				$seniority = $value['seniority']+1;
				$tyear = (date('Y')+1).'-'.date('m');
				M('teacher')->where("id='".$value['id']."'")->save(array('seniority'=>$seniority,'tyear'=>$tyear));
			}
			if($value['parentid']>0)
			{
				$list[$key]['parentname'] = M('teacher')->where("id='".$value['parentid']."'")->getField('nicename');
			}
		}
		$this->assign("page", $page->show('Admin'));	
		$this->assign("count",$count);
		// 学校
		$schollist =M('teacher')->field('schoolname')->where("schoolname !=''")->group('schoolname')->select();
		$this->assign("schollist",$schollist);
		// 职称
		//$titlelist =M('teacher')->field('title')->group('title')->select();
		//$this->assign("titlelist",$titlelist);
		$xuekelist =getxuekelist();
		$this->assign("xuekelist",$xuekelist);
		$this->assign("list",$list);
        $this->display();
	}
	public function  img()
	{
		$id=  I("get.id",0,'intval');		
		$info=M('teacher')->field('titleimg')->where("id=$id")->find();
		if($info['titleimg'])
		{
			if(strpos($info['titleimg'],'http://')===false)
			{
				$info['titleimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$info['titleimg'];
			}else{
				$info['titleimg'] =$info['titleimg'];
			}	
		}
		$this->assign("info",$info);
		$this->display();
		
	}
	public function  img1()
	{
		$id=  I("get.id",0,'intval');		
		$info=M('teacher')->field('cardimg')->where("id=$id")->find();
	
		if($info['cardimg'])
		{
			if(strpos($info['cardimg'],'http://')===false)
			{
				$info['cardimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$info['cardimg'];
			}else{
				$info['cardimg'] =$info['cardimg'];
			}	
		}
		$this->assign("info",$info);
		$this->display();
	}
	public function add()
	{
		// 题型
		$questiontype =M('teacher')->field('questiontype')->group('questiontype')->select();
		$this->assign("questionlist",$questiontype);
		// 荣誉
		$honors =M('teacher')->field('honors')->group('honors')->select();
		$this->assign("honorslist",$honors);
		$xuekelist =getxuekelist();
		$this->assign("xuekelist",$xuekelist);
		$this->display();
	}
	public function add_post()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			
			if(empty($pdata['nicename']))
			{
				$this->ajaxReturn(array('msg'=>'姓名不能为空','status'=>1));
			}
			if(empty($pdata['mobile']))
			{
				$this->ajaxReturn(array('msg'=>'账号不能为空','status'=>1));
			}else
			{
				if(!preg_match('/^1[34578]{1}\d{9}$/', $pdata['mobile']))
				{
					$this->ajaxReturn(array('msg'=>'账号必须是正确的手机号','status'=>1));
				}
			}
			if(empty($pdata['title']))
			{
				$this->ajaxReturn(array('msg'=>'职称不能为空','status'=>1));
			}
			if(empty($pdata['xueke']))
			{
				$this->ajaxReturn(array('msg'=>'请选择学科','status'=>1));
			}
			if(empty($pdata['schoolname']))
			{
				$this->ajaxReturn(array('msg'=>'学校不能为空','status'=>1));
			}
			if(empty($pdata['titleimg']))
			{
				$this->ajaxReturn(array('msg'=>'请上传职称照片','status'=>1));
			}
			
			if(empty($pdata['questiontype']))
			{
				$this->ajaxReturn(array('msg'=>'请选择擅长题型','status'=>1));
			}
			if(empty($pdata['honors']))
			{
				$this->ajaxReturn(array('msg'=>'请选择所获荣誉','status'=>1));
			}
			$count =M('teacher')->where("mobile='".$pdata['mobile']."'")->count();
			if($count > 0)
			{
				$this->ajaxReturn(array('msg'=>'该账号已经注册','status'=>1));
			}
			if(count($pdata['questiontype']) >5)
			{
				$this->ajaxReturn(array('msg'=>'擅长题型最多选择5个','status'=>1));
			}
			if(count($pdata['honors']) >3)
			{
				$this->ajaxReturn(array('msg'=>'所获荣誉最多选择3个','status'=>1));
			}
			$pdata['questiontype'] =implode(',', $pdata['questiontype']);
			$pdata['honors'] =implode(',', $pdata['honors']);
			$pdata['tyear'] = date('Y').'-09';
			$pdata['password'] =sp_password(123456);
			$pdata['addtime'] =time();
			if($pdata['agentid'] >0)
			{
				$pdata['parentid'] =$pdata['agentid'];
				unset($pdata['agentid']);
			}
			$res =M('teacher')->add($pdata);
			if($res)
			{
				$this->ajaxReturn(array('msg'=>'保存成功','status'=>0));
			}
		}
	}

	public function edit(){
		$id=  I("get.id",0,'intval');
		
		$info=M('teacher')->where("id=$id")->find();
		if($info['titleimg'])
		{
			if(strpos($info['titleimg'],'http://')===false)
			{
				$info['titleimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$info['titleimg'];
			}else{
				$info['titleimg'] =$info['titleimg'];
			}	
		}
		if($info['cardimg'])
		{
			if(strpos($info['cardimg'],'http://')===false)
			{
				$info['cardimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$info['cardimg'];
			}else{
				$info['cardimg'] =$info['cardimg'];
			}	
		}
		if($info['parentid'] > 0)
		{
			$info['parentname']=M('teacher')->where("id='".$info['parentid']."'")->getField('nicename');
		}
		switch ($info['xueke']) {
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
		$questiontype =explode(',',$info['questiontype']);
		foreach ($qtypelist as $key => $value) {
			if(in_array($value['typename'],$questiontype))
			{
				$qtypelist[$key]['isdo'] =1;
			}else
			{
				$qtypelist[$key]['isdo'] =0;
			}
		}
		$this->assign('qtypelist',$qtypelist);
		
		$htypelist[0]['typename'] ='参与中考命题';
		$htypelist[1]['typename'] ='参与中考阅卷';
		$htypelist[2]['typename'] ='学校教研组长';
		$htypelist[3]['typename'] ='年级备课组长';
		$htypelist[4]['typename'] ='全国赛课获奖';
		$htypelist[5]['typename'] ='全国论文比赛获奖';
		$htypelist[6]['typename'] ='市级赛课获奖';
		$htypelist[7]['typename'] ='市级论文比赛获奖';
		$htypelist[8]['typename'] ='发表核心期刊论文';
		$htypelist[9]['typename'] ='业内知名教师';
		$htypelist[10]['typename'] ='学校教学骨干';
		$honors =explode(',',$info['honors']);
		foreach ($htypelist as $key => $value) {
			if(in_array($value['typename'],$honors))
			{
				$htypelist[$key]['isdo'] =1;
			}else
			{
				$htypelist[$key]['isdo'] =0;
			}
		}
		$this->assign('htypelist',$htypelist);
		$xuekelist =getxuekelist();
		$this->assign("xuekelist",$xuekelist);
		$this->assign("info",$info);
		$this->display();
	}
	public function edit_post()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			if(empty($pdata['nicename']))
			{
				$this->ajaxReturn(array('msg'=>'姓名不能为空','status'=>1));
			}
			if(empty($pdata['mobile']))
			{
				$this->ajaxReturn(array('msg'=>'账号不能为空','status'=>1));
			}else
			{
				if(!preg_match('/^1[34578]{1}\d{9}$/', $pdata['mobile']))
				{
					$this->ajaxReturn(array('msg'=>'账号必须是正确的手机号','status'=>1));
				}
			}
			if(empty($pdata['xueke']))
			{
				$this->ajaxReturn(array('msg'=>'请选择学科','status'=>1));
			}
			if(empty($pdata['title']))
			{
				$this->ajaxReturn(array('msg'=>'职称不能为空','status'=>1));
			}
			if(empty($pdata['schoolname']))
			{
				$this->ajaxReturn(array('msg'=>'学校不能为空','status'=>1));
			}
			if(empty($pdata['titleimg']))
			{
				$this->ajaxReturn(array('msg'=>'请上传职称照片','status'=>1));
			}
			
			if(empty($pdata['questiontype']))
			{
				$this->ajaxReturn(array('msg'=>'请选择擅长题型','status'=>1));
			}
			if(empty($pdata['honors']))
			{
				$this->ajaxReturn(array('msg'=>'请选择所获荣誉','status'=>1));
			}
			if($pdata['oldmobile'] !=$pdata['mobile'])
			{
				$count =M('teacher')->where("mobile='".$pdata['mobile']."'")->count();
				if($count > 0)
				{
					$this->ajaxReturn(array('msg'=>'该账号已经注册','status'=>1));
				}
			}
			if(count($pdata['questiontype']) >5)
			{
				$this->ajaxReturn(array('msg'=>'擅长题型最多选择5个','status'=>1));
			}
			if(count($pdata['honors']) >3)
			{
				$this->ajaxReturn(array('msg'=>'所获荣誉最多选择3个','status'=>1));
			}
			$pdata['questiontype'] =implode(',', $pdata['questiontype']);
			$pdata['honors'] =implode(',', $pdata['honors']);
			if($pdata['agentid']>0)
			{
				$pdata['parentid'] =$pdata['agentid'];
				unset($pdata['agentid']);
			}else{
				$pdata['parentid']=0;
			}
			$res =M('teacher')->where("id='".$pdata['id']."'")->save($pdata);
			
			$this->ajaxReturn(array('msg'=>'保存成功','status'=>0));
						
		}
	}
	function getteachers()
    {
        $key =I('keyword','','trim');
		$nowteacher=I('nowteacher','','intval');
		if(empty($key))
		{
			$where ="nicename !='' and id !='$nowteacher'";
		}else{
			$where ="nicename like '%$key%' or mobile like '%$key%' and  nicename !='' and id !='$nowteacher'";
		}
        $list= M('teacher')->field('id,nicename,mobile')->where($where)->select();
        foreach ($list as $key => $value) {
            $list[$key]['value'] =$value['id'];
            $list[$key]['text'] =$value['nicename']; 
			$list[$key]['text1'] =$value['mobile']; 			
        }
        $this->ajaxReturn(array('list'=>$list));

    }
	public function detail(){
		$id=  I("get.id",0,'intval');
		
		$info=M('teacher')->where("id=$id")->find();
		if($info['titleimg'])
		{
			if(strpos($info['titleimg'],'http://')===false)
			{
				$info['titleimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$info['titleimg'];
			}else{
				$info['titleimg'] =$info['titleimg'];
			}	
		}
		if($info['cardimg'])
		{
			if(strpos($info['cardimg'],'http://')===false)
			{
				$info['cardimg'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$info['cardimg'];
			}else{
				$info['cardimg'] =$info['cardimg'];
			}	
		}
		if($info['parentid']>0)
		{
			$ainfo =M('teacher')->where("id='".$info['parentid']."'")->find();
			$info['parentname']  = $ainfo['nicename'];
			$info['parentmobile']= $ainfo['mobile'];
		}
		$this->assign("info",$info);
		//发布记录
		$list = M('task')->field('id,title,type,addtime')->where("userid='$id'")->select();
		$alist =M('zhuantis')->field('id,title,addtime')->where("teacherid='$id'")->select();
		foreach($alist as $ke=>$v)
		{
			$alist[$ke]['type'] = '专题';
		}
		$list=array_merge($list,$alist);
		
		$this->assign('list',$list);
		//Ta的学生
		$slist =M('member')->where("agentid='".$id."'")->select();
		$this->assign('slist',$slist);
		$this->assign('totalscount',count($slist));
		
		//Ta的教师
		$tlist =M('teacher')->where("parentid='".$id."'")->select();
		$this->assign('tlist',$tlist);
		
		$collectcount =M('collect_task')->where("userid='".$id."' and type='教师'")->count();
		$this->assign('collectcount',$collectcount);
		$ancount=D()->field('a.*')->table(C('DB_PREFIX')."answer a,".C('DB_PREFIX')."question q")->where("a.questionid=q.id and q.parentid=0 and q.teacherid='$id'")->count();
		$this->assign('ancount',$ancount);
		
		$this->display();
	}
	public function delete(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
			$count =M('question')->where("teacherid='$id'")->count();
			$count2 =M('task')->where("userid='$id'")->count();
			$count3 =M('reports')->where("teacherid='$id'")->count();
			$count4=M('zhuantis')->where("teacherid='$id'")->count();
			if($count ==0 && $count2 ==0 && $count3 ==0 && $count4==0)
			{
				$result = M('teacher')->where(array("id"=>$id))->delete();
				if ($result!==false) {
					$this->success("删除成功！", U("teacher/index"));
				} else {
					$this->error('删除失败！');
				}
			}else{
				$this->error('删除失败！该教师有发布/回答/举报/专题信息');
			}
    		
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    public function donechange()
    {    	
		$id =I('id','','intval');
		$result=M('teacher')->where("id='$id'")->save(array('status'=>1,'reason'=>''));
		if($result)
		{
			//模板推送 
			$info =M('teacher')->field('openid,nicename,mobile')->where("id='$id'")->find();
			$this->tsendTemplate($info);
			$this->ajaxReturn(array('msg'=>'审核操作成功','status'=>1));
		}else
		{
			$this->ajaxReturn(array('msg'=>'审核操作失败','status'=>0));
		}
    	
    }
	public function gettixinglist()
	{
		if(IS_POST)
		{
			$key =I('keyword','','trim');		
			$qtypelist =array();
			if(!empty($key)){
				switch ($key) {
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
				$str ='';
				foreach($qtypelist as $key=>$v)
				{
					$str.='<input type="checkbox" name="questiontype[]" value="'.$v['typename'].'"><span>'.$v['typename'].'&nbsp;</span>';
					if(($key+1)%4==0)
					{
						$str.="<br/>";
					}
				}
				$this->ajaxReturn(array('html'=>$str));
			}
		}
	}
    public function donechange2()
    {    	
		$id =I('id','','intval');
		$content =I('content','','trim');
		$result=M('teacher')->where("id='$id'")->save(array('status'=>2,'reason'=>$content));
		if($result)
		{
			// 模板推送
			$info =M('teacher')->field('openid,reason')->where("id='$id'")->find();
			$this->tsendTemplate2($info);
			$this->ajaxReturn(array('msg'=>'驳回操作成功','status'=>1));
		}else
		{
			$this->ajaxReturn(array('msg'=>'驳回操作失败','status'=>0));
		}    	
    }
	// 处理推送函数
	function tsendTemplate2($info){
        $weChatAuth = new \Com\WechatAuth("wx34dd37f9256128a8","05adb450c3107e9646b65a97c58742b5");
        $token=$weChatAuth->getAccessToken('client')['access_token'];
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $data=array(
            "touser"=>$info['openid'],
            "topcolor"=>"#151516", 
            "template_id"=>"BQ9sc4bCwztY4UYp8SPTk7qD9vPdcTQ4oZQ6_HQOoX4",
            "url"=>"http://".$_SERVER['HTTP_HOST']."/index.php?g=user&m=center&a=apply",
            'data'=>array(
                    'first'=>array('value'=>urlencode("尊敬的老师，您的认证申请未通过"),'color'=>"#151516"),
                    'keyword1'=>array('value'=>urlencode("申请认证"),'color'=>"#151516"),
                    'keyword2'=>array('value'=>"未通过",'color'=>"#151516"),
                    'keyword3'=>array('value'=>date('Y-m-d H:i:s'),'color'=>"#151516"),
                    'keyword4'=>array('value'=>urlencode("失败原因：".$info['reason']),'color'=>"#151516"),
                    'remark'=>array('value'=>urlencode("请点击详情重新提交认证资料信息"),'color'=>'#151516')
                ));
        $data=urldecode(json_encode($data));       
        $res= $this->_request($url,true,'POST',$data);
        
    }
	function tsendTemplate($info){
        $weChatAuth = new \Com\WechatAuth("wx34dd37f9256128a8","05adb450c3107e9646b65a97c58742b5");
        $token=$weChatAuth->getAccessToken('client')['access_token'];
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $data=array(
            "touser"=>$info['openid'],
            "topcolor"=>"#151516", 
            "template_id"=>"0KxY6zg91ZLvSxvmiI96OmjvEyyenRJwFJkhLl8Wl8M",
            "url"=>"http://".$_SERVER['HTTP_HOST']."/index.php?g=user&m=center&a=apply",
            'data'=>array(
                    'first'=>array('value'=>urlencode("尊敬的老师，您的认证申请已通过"),'color'=>"#151516"),
                    'keyword1'=>array('value'=>urlencode($info['nicename']),'color'=>"#151516"),
                    'keyword2'=>array('value'=>$info['mobile'],'color'=>"#151516"),
                    'remark'=>array('value'=>urlencode("欢迎加入语文帮，我们携手创造最大的价值~"),'color'=>'#151516')
                ));
        $data=urldecode(json_encode($data));       
        $res= $this->_request($url,true,'POST',$data);
       
    }
	function _request($curl,$https=true,$method='GET',$data=null){
        $header = array('Expect:');
        $ch=  curl_init();
        curl_setopt($ch,CURLOPT_URL,$curl);
        curl_setopt($ch,CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        if($https){
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,TRUE);
        }
        if($method=='POST'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        }
        $content=  curl_exec($ch);
        //返回结果
          if($content){
              curl_close($ch);
              return $content;
          }
          else {
             $errno = curl_errno( $ch );
             $info  = curl_getinfo( $ch );
             $info['errno'] = $errno;
                curl_close( $ch );
             $log = json_encode( $info );
             
              return false;
          }
    }
}