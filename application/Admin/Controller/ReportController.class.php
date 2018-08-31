<?php
// +----------------------------------------------------------------------
// | 举报管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ReportController extends AdminbaseController {
	public function index()
	{
		$where = array();
		/**搜索条件**/
		$title = I('request.title');
		$teacher = trim(I('request.teacher'));
		if($title){
			$where['title'] = array('like',"%$title%");
		}

		if($teacher){
			$where['teachername'] = array('like',"%$teacher%");;
		}

		$count=M('reports')->where($where)->count();
		$page = $this->page($count, 20);
        $list = M('reports')->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
		
		$this->assign("page", $page->show('Admin'));		
		$this->assign("list",$list);
		$this->assign("rcount",$count);
        $this->display();
	}
	public function info(){
		$id=  I("get.id",0,'intval');
		$rinfo =M('reports')->where("id='$id'")->find();
		$tid=$rinfo['tid'];
		switch($rinfo['type'])
		{
			case '微课':
				$info=M('task')->where("id=$tid")->find();	
				$content =json_decode($rinfo['rcontent'],true);
				$this->assign("content",$content);
				$this->assign("info",$info);
				$uinfo =M('teacher')->where("id='".$rinfo['teacherid']."'")->find();
				$uinfo['colcount'] =M('collect_task')->where("taskid='".$uinfo['id']."' and type='教师'")->count();
				$this->assign("uinfo",$uinfo);
				$collectcount =M('collect_task')->where("taskid='".$tid."' and type='微课'")->count();
				$this->assign('collectcount',$collectcount);
				break;
			case '资源':
				$info=M('task')->where("id=$tid")->find();	
				if($info['userid'] != 0)
				{
					$content =json_decode($rinfo['rcontent'],true);
					$this->assign("content",$content);	
				}							
				$this->assign("info",$info);
				$uinfo =M('teacher')->where("id='".$rinfo['teacherid']."'")->find();
				$uinfo['colcount'] =M('collect_task')->where("taskid='".$uinfo['id']."' and type='教师'")->count();
				$this->assign("uinfo",$uinfo);
				$collectcount =M('collect_task')->where("taskid='".$tid."' and type='资源'")->count();
				$this->assign('collectcount',$collectcount);
				break;
			case '问答':
				$info=M('question')->where("id=$tid")->find();
				$content =json_decode($rinfo['rcontent'],true);
				$this->assign("content",$content);
				$this->assign("info",$info);
				$uinfo =M('teacher')->where("id='".$rinfo['teacherid']."'")->find();
				$uinfo['colcount'] =M('collect_task')->where("taskid='".$uinfo['id']."' and type='教师'")->count();
				$this->assign("uinfo",$uinfo);
				$collectcount =M('collect_task')->where("taskid='".$tid."' and type='问答'")->count();
				$this->assign('collectcount',$collectcount);
				break;
			default:
				break;
		}
		$this->assign('rinfo',$rinfo);		
		
		$this->display();
	}
	public function doadd()
	{
		if(IS_POST)
		{
			$id =I('tid','','intval');
			$res=M('reports')->where("id='$id'")->setField('status',2);

			$this->ajaxReturn(array('status'=>0,'msg'=>'操作成功','url'=>U('Report/info',array('id'=>$id))));
		}
	}
	public function delete(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
    		$result = M('reports')->where(array("id"=>$id))->delete();
    		if ($result!==false) {
    			$this->success("删除成功！", U("Report/index"));
    		} else {
    			$this->error('删除失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    // 删除 举报
    public function doadd2(){
        $id = I('post.tid',0,'intval');
    	if (!empty($id)) {
			$info =M('reports')->where(array("id"=>$id))->find();
			M('reports')->where(array("id"=>$id))->setField('status',2);
    		switch($info['type'])
			{
				case '问答':
					$result=M('question')->where("id='".$info['tid']."'")->delete();
					break;
				default:
					$result=M('task')->where("id='".$info['tid']."'")->delete();
					break;
			}
    		if ($result!==false) {
    			$this->ajaxReturn(array('status'=>0,'msg'=>'删除成功'));
    		} else {
    			$this->ajaxReturn(array('status'=>1,'msg'=>'删除失败！'));
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
}