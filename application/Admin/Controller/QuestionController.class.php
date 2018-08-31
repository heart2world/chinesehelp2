<?php
// +----------------------------------------------------------------------
// | 提问管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class QuestionController extends AdminbaseController {
	public function index()
	{
		$where = array("parentid"=>0);
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
			$where['nicename'] = array('like',"%$username%");
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
		$count=M('question')->where($where)->count();
		$page = $this->page($count, 20);
        $list = M('question')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
		foreach ($list as $key => $value) {
			$list[$key]['againtitle'] = M('question')->where("parentid='".$value['id']."'")->getField('title');
			$list[$key]['teachername'] = M('teacher')->where("id='".$value['teacherid']."'")->getField('nicename');
			$list[$key]['turl'] = 'http://'.$_SERVER['HTTP_HOST'].U('Portal/Problem/detail',array('id'=>$value['id']));
			$list[$key]['surl'] = 'http://'.$_SERVER['HTTP_HOST'].U('Home/Problem/detail',array('id'=>$value['id']));
		}
		$this->assign("page", $page->show('Admin'));	
		$this->assign("list",$list);
		$xuekelist =getxuekelist();
		$this->assign("xuekelist",$xuekelist);
		$this->assign("count",$count);
        $this->display();
	}
	public function detail()
	{
		$id=  I("get.id",0,'intval');
		
		$info=M('question')->where("id='$id'")->find();
		// 首提问录音记录
		$tinfo =M('teacher')->where("id='".$info['teacherid']."'")->find();
		
		$stars =M('question')->where("teacherid='".$info['teacherid']."' and parentid=0 and isend=1")->sum('star');
		$starcount =M('question')->where("teacherid='".$info['teacherid']."' and parentid=0 and isend=1")->count();
		$tinfo['star'] = round($stars/$starcount,1);
		$ancount=D()->field('a.*')->table(C('DB_PREFIX')."answer a,".C('DB_PREFIX')."question q")->where("a.questionid=q.id and q.parentid=0 and q.teacherid='".$info['teacherid']."'")->count();
		$tinfo['answercount'] =$ancount;
		$collectcount =M('collect_task')->where("taskid='".$info['teacherid']."' and type='教师'")->count();
		$tinfo['collectcount'] =$collectcount;
		
		$content=json_decode($info['content'],true);
		$this->assign('imgaudio',$content);
		$answerinfo =M('answer')->where("questionid='".$info['id']."'")->find();

		// 首回答录音记录
		$this->assign("info",$info);
		$this->assign("tinfo",$tinfo);
		
		$content1=json_decode($answerinfo['content'],true);
		$this->assign('imgaudio1',$content1);
		$this->assign("answerinfo",$answerinfo);
		$againinfo =M('question')->where("parentid='".$info['id']."'")->find();
		// 追提问录音记录
		if(!empty($againinfo))
		{
			$content2=json_decode($againinfo['content'],true);
			$this->assign('imgaudio2',$content2);
			$this->assign('againinfo',$againinfo);
			// 追回答录音记录
			$againanswer =M('answer')->where("questionid='".$againinfo['id']."'")->find();
			$content2=json_decode($againanswer['content'],true);
			$this->assign('imgaudio2',$content2);
			$this->assign('againanswer',$againanswer);	
		}		
		$this->display();
	}

	public function changesort()
    {
    	if(IS_POST)
    	{
    		$id =I('id','','intval');
    		$val =I('val','','intval');
    		M('question')->where("id='$id'")->setField('isindex',$val);
    		$this->ajaxReturn(array('msg'=>'更新成功','status'=>0));
    	}
    }
	public function delete(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
			$info =M('question')->find($id);
    		$result = M('question')->where(array("id"=>$id))->delete();
			$againres =M('question')->where("parentid='".$info['id']."'")->find();
			if($againres)
			{
				M('question')->where(array("id"=>$againres['id']))->delete();
			}
    		if ($result!==false) {
				if($info['userid'] > 0)
				{
					$data['teacherid'] =$info['teacherid'];					
					$data['title']='指定你的问题'.$info['title'].'已被删除';												
					$data['content'] ='';
					$data['addtime'] =time();
					M('message')->add($data);
				}
    			$this->success("删除成功！", U("Question/index"));
    		} else {
    			$this->error('删除失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
}