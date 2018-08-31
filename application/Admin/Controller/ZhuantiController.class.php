<?php
// +----------------------------------------------------------------------
// | 专题管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ZhuantiController extends AdminbaseController {
	public function index()
	{
		$where = array();
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
		$count=M('zhuantis')->where($where)->count();
		$page = $this->page($count, 20);
        $list = M('zhuantis')
            ->where($where)
            ->order("createtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
		foreach($list as $k=>$v)
		{
			$list[$k]['surl'] ='http://'.$_SERVER['HTTP_HOST'].'/'.U('Home/Zhuantis/ztinfo',array('id'=>$v['id']));
			$list[$k]['turl'] ='http://'.$_SERVER['HTTP_HOST'].'/'.U('Portal/Zhuantis/ztinfo',array('id'=>$v['id']));
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
		$info=M('zhuantis')->where("id=$id")->find();
		$info['collectnum'] =M('collect_task')->where("type='专题' and taskid='$id'")->count();
		$this->assign("info",$info);
		
		$slist = D()->field('r.*')->table(C('DB_PREFIX')."task r,".C('DB_PREFIX')."term_zhuanti ru")->where("r.id=ru.taskid and ru.ztid='".$id."'")->select();
		$this->assign('slist',$slist);
		$this->display();
	}
	public function delete(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
			$info =M('zhuantis')->find($id);
    		$result = M('zhuantis')->where(array("id"=>$id))->delete();
    		if ($result!==false) {
				M('term_zhuanti')->where("ztid='$id'")->delete();				
    			$this->success("删除成功！", U("zhuanti/index"));
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
    		M('zhuantis')->where("id='$id'")->setField('sortorder',$val);
    		$this->ajaxReturn(array('msg'=>'更新成功','status'=>0));
    	}
    }
}