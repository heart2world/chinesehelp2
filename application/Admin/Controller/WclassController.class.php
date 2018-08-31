<?php
// +----------------------------------------------------------------------
// | 微课管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WclassController extends AdminbaseController {
	public function index()
	{
		$where = array('type'=>'微课');
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
		if($username){
			$where['username'] = array('like',"%$username%");
			$this->assign('username',$username);
		}
		if($xueke)
		{
			$where['xueke'] =$xueke;
		}
		$this->assign('xueke',$xueke);
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
		$xuekelist =getxuekelist();
		$this->assign("xuekelist",$xuekelist);
		$this->assign("count",$count);
        $this->display();
	}
	public function detail(){
		$id=  I("get.id",0,'intval');		
		$info=M('task')->where("id=$id")->find();
		$content = json_decode($info['content'],true);
		$this->assign('imgaudio',$content);
		$this->assign("info",$info);
		$uinfo =M('teacher')->where("id='".$info['userid']."'")->find();
		$this->assign("uinfo",$uinfo);
		$collectcount =M('collect_task')->where("taskid='".$info['userid']."' and type='教师'")->count();
		
		$this->assign('collectcount',$collectcount);
		$ancount=D()->field('a.*')->table(C('DB_PREFIX')."answer a,".C('DB_PREFIX')."question q")->where("a.questionid=q.id and q.parentid=0 and q.teacherid='".$info['userid']."'")->count();
		$this->assign('ancount',$ancount);

		
		$this->display();
	}
	public function delete(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
			$info =M('task')->find($id);
    		$result = M('task')->where(array("id"=>$id))->delete();
    		if ($result!==false) {
				if($info['userid'] > 0)
				{
					$data['teacherid'] =$info['userid'];
					switch ($info['type']) {
						case '微课':
							$data['title']='你发布的课程'.$info['title'].'已被删除';
							$data['content'] ='';							
							break;
						case '资源':
							$data['title']='你发布的资源'.$info['title'].'已被删除';	
							$data['content'] ='';							
							break;
						default:
							# code...
							break;
					}
					$data['addtime'] =time();
					M('message')->add($data);
				}
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