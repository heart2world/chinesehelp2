<?php
// +----------------------------------------------------------------------
// | 资源管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class RecommendedController extends AdminbaseController {
	public function index()
	{
		$where = array('type'=>'资源');
		/**搜索条件**/
		$title = I('request.title');
		$username = trim(I('request.username'));
		$starttime =I('starttime','','trim');
        $endtime   =I('endtime','','trim');
		$xueke =I('xueke','','trim');
		if($title){
			$where['title'] = array('like',"%$title%");
			$this->assign('title',$title);
		}
		if($xueke)
		{
			$where['xueke'] =$xueke;
		}
		$this->assign('xueke',$xueke);
		if($username){
			$where['username'] = array('like',"%$username%");
			$this->assign('username',$username);
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
		$count=M('task')->where($where)->count();
		$page = $this->page($count, 20);
        $list = M('task')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
		foreach ($list as $k=>$v){
			$list[$k]['turl'] = 'http://'.$_SERVER['HTTP_HOST'].U('Portal/Task/detail',array('id'=>$v['id']));
			$list[$k]['surl'] = 'http://'.$_SERVER['HTTP_HOST'].U('Home/Task/lesson_info',array('id'=>$v['id']));
		}
		$this->assign("page", $page->show('Admin'));	
		$this->assign("list",$list);
		$this->assign("count",$count);
		$xuekelist =getxuekelist();
		$this->assign("xuekelist",$xuekelist);
        $this->display();
	}
	public function add()
	{
		$xuekelist =array();
		$xuekelist[0]['title'] = '语文';
		$xuekelist[1]['title'] = '数学';
		$xuekelist[2]['title'] = '外语';
		$xuekelist[3]['title'] = '物理';
		$xuekelist[4]['title'] = '化学';
		$xuekelist[5]['title'] = '政治';
		$xuekelist[6]['title'] = '历史';
		$this->assign("xuekelist",$xuekelist);
		$this->display();
	}
	public function add_post()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			if(empty($pdata['title']))
			{
				$this->ajaxReturn(array('msg'=>'资源标题不能为空','status'=>1));
			}
			if(empty($pdata['classtype']))
			{
				$this->ajaxReturn(array('msg'=>'类型不能为空','status'=>1));
			}
			if(empty($pdata['brief']))
			{
				$this->ajaxReturn(array('msg'=>'资源简介不能为空','status'=>1));
			}
			if(empty($pdata['content']))
			{
				$this->ajaxReturn(array('msg'=>'资源内容不能为空','status'=>1));
			}
			$pdata['username'] ='语文帮官方';
			$pdata['type'] ='资源';
			$pdata['status'] =1;
			$pdata['content'] = strcontentjs(htmlspecialchars_decode($pdata['content']));
			$pdata['addtime'] =time();
			$result =M('task')->add($pdata);
			if($result)
			{
				$this->ajaxReturn(array('msg'=>'保存成功','status'=>0));
			}
		}
	}
	public function edit()
	{
		$id=  I("get.id",0,'intval');
		$info=M('task')->where("id=$id")->find();
		$this->assign("info",$info);
		$this->display();
	}
	public function edit_post()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			if(empty($pdata['title']))
			{
				$this->ajaxReturn(array('msg'=>'资源标题不能为空','status'=>1));
			}
			if(empty($pdata['classtype']))
			{
				$this->ajaxReturn(array('msg'=>'类型不能为空','status'=>1));
			}
			if(empty($pdata['brief']))
			{
				$this->ajaxReturn(array('msg'=>'资源简介不能为空','status'=>1));
			}
			if(empty($pdata['content']))
			{
				$this->ajaxReturn(array('msg'=>'资源内容不能为空','status'=>1));
			}
			$pdata['content'] = strcontentjs(htmlspecialchars_decode($pdata['content']));
			
			$result =M('task')->where("id='".$pdata['id']."'")->save($pdata);
			
			$this->ajaxReturn(array('msg'=>'保存成功','status'=>0));
			
		}
	}
	public function detail(){
		$id=  I("get.id",0,'intval');
		
		$info=M('task')->where("id=$id")->find();
		$content = json_decode($info['content'],true);
		$this->assign('imgaudio',$content);
		$this->assign("info",$info);
		$uinfo =M('teacher')->where("id='".$info['userid']."'")->find();
		$this->assign("uinfo",$uinfo);
		$collectcount =M('collect_task')->where("taskid='".$id."' and type='资源'")->count();
		$this->assign('collectcount',$collectcount);
		$ancount=D()->field('a.*')->table(C('DB_PREFIX')."answer a,".C('DB_PREFIX')."question q")->where("a.questionid=q.id and q.parentid=0 and q.teacherid='".$info['userid']."'")->count();
		$this->assign('ancount',$ancount);

		$this->display();
	}
	public function delete(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
    		$result = M('task')->where(array("id"=>$id))->delete();
    		if ($result!==false) {
    			$this->success("删除成功！", U("Wclass/index"));
    		} else {
    			$this->error('删除失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    public function changesort()
    {
    	if(IS_POST)
    	{
    		$id =I('id','','intval');
    		$val =I('val','','intval');
    		M('task')->where("id='$id'")->setField('isindex',$val);
    		$this->ajaxReturn(array('msg'=>'更新成功','status'=>0));
    	}
    }
}