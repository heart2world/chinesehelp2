<?php
// +----------------------------------------------------------------------
// | 会员管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MemberController extends AdminbaseController {
	public function index()
	{
		$where = array();
		/**搜索条件**/
		$schoolname = I('request.schoolname');
		$nicename = trim(I('request.nicename'));
		$starttime =I('starttime','','trim');
        $endtime   =I('endtime','','trim');
		if($schoolname){
			$where['schoolname'] = array('like',"%$schoolname%");
		}
		
		if($nicename){
			$where['nicename'] = array('like',"%$nicename%");;
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
		$count=M('member')->where($where)->count();
		$page = $this->page($count, 20);
        $users = M('member')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
		foreach($users as $key=>$v)
		{
			if($v['agentid'] > 0)
			{
				$uinfo = M('teacher')->field("id,parentid,nicename")->where("id='".$v['agentid']."'")->find();
				$users[$key]['teachername'] =$uinfo['nicename'];
				if($uinfo['parentid']>0)
				{
					$users[$key]['parentname'] = M('teacher')->where("id='".$uinfo['parentid']."'")->getField('nicename');
				}
			}
		}
		
		$this->assign("page", $page->show('Admin'));		
		$this->assign("member",$users);
		$this->assign("count",count($users));
        $this->display();
	}

	public function edit()
	{
		$id = I('get.id',0,'intval');
		
		
		$user=M('member')->where(array("id"=>$id))->find();
		if($user['agentid']>0)
		{
			$user['teachername'] =M('teacher')->where("id='".$user['agentid']."'")->getField('nicename');
		}
		$this->assign($user);
		$this->display();
	}
	
	public function detail()
	{
		$id = I('get.id',0,'intval');
		$user=M('member')->where(array("id"=>$id))->find();
		if($user['agentid']>0)
		{
			$tinfo =M('teacher')->field('id,nicename,parentid')->where("id='".$user['agentid']."'")->find();
			$user['teachername'] =$tinfo['nicename'];
			if($tinfo['parentid']>0)
			{
				$user['parentname'] =M('teacher')->where("id='".$tinfo['parentid']."'")->getField('nicename');
			}
		}
		
		$this->assign($user);
		// 消费记录
		$count = M('orders')->where("userid='$id'")->count();
		$page = $this->page($count, 20);
		$orderlist = M('orders')->where("userid='$id'")->order("addtime DESC")->limit($page->firstRow, $page->listRows)->select();
		$this->assign('orderlist',$orderlist);
		$this->assign("page1", $page->show('Admin'));

		// 历史记录
		$count1 = M('question')->where("userid='$id' and parentid=0")->count();
		$page1 = $this->page($count1, 20);
		$questionlist = M('question')->where("userid='$id' and parentid=0")->order("addtime DESC")->limit($page1->firstRow, $page1->listRows)->select();
		foreach ($questionlist as $key => $value) {
			$questionlist[$key]['againtitle'] =M('question')->where("parentid='".$value['id']."'")->getField('title');
		}
		$this->assign('questionlist',$questionlist);
		$this->assign("page", $page1->show('Admin'));
		$this->display();
	}
	public function edit_post(){
		if (IS_POST) {
			$pdata =I('post.');
			
			$res=M('member')->where("id='".$pdata['id']."'")->save($pdata);
			$this->ajaxReturn(array('msg'=>'保存成功','status'=>0));
		}
	}

	// 停用管理员
    public function ban(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
    		$result = M('member')->where(array("id"=>$id))->setField('user_status','0');
    		if ($result!==false) {
    			$this->success("会员冻结成功！", U("member/index"));
    		} else {
    			$this->error('会员冻结失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }

    // 启用管理员
    public function cancelban(){
    	$id = I('get.id',0,'intval');
    	if (!empty($id)) {
    		$result = M('member')->where(array("id"=>$id))->setField('user_status','1');
    		if ($result!==false) {
    			$this->success("会员解冻成功！", U("member/index"));
    		} else {
    			$this->error('会员解冻失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
	function getteachers()
    {
        $key =I('keyword','','trim');
		if(empty($key))
		{
			$where ="nicename !=''";
		}else{
			$where ="nicename like '%$key%' or mobile like '%$key%' and  nicename !=''";
		}
        $list= M('teacher')->field('id,nicename,mobile')->where($where)->select();
        foreach ($list as $key => $value) {
            $list[$key]['value'] =$value['id'];
            $list[$key]['text'] =$value['nicename']; 
			$list[$key]['text1'] =$value['mobile']; 			
        }
        $this->ajaxReturn(array('list'=>$list));

    }
}