<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;

use Common\Controller\AdminbaseController;

class AdminPostController extends AdminbaseController {
    
	protected $posts_model;
	protected $term_relationships_model;
	protected $terms_model;
	
	function _initialize() {
		parent::_initialize();
		$this->posts_model = D("Portal/Posts");
		$this->terms_model = D("Portal/Terms");
		$this->term_relationships_model = D("Portal/TermRelationships");
	}
	
	// 后台文章管理列表
	public function index(){
		$this->_lists(array("post_status"=>array('neq',3)));
		$this->_getTree();
		$this->display();
	}
	
	// 文章添加
	public function add(){
		$terms = $this->terms_model->order(array("listorder"=>"asc"))->select();
		$term_id = I("get.term",0,'intval');
		$this->_getTermTree();
		$term=$this->terms_model->where(array('term_id'=>$term_id))->find();
		$this->assign("term",$term);
		$this->assign("terms",$terms);
		$this->display();
	}
	
	// 文章添加提交
	public function add_post(){
		if (IS_POST) {
			$pdata =I('post.');			
			$article=array();
			// 公告
			if($pdata['post_term'] == 1)
			{
				if(empty($pdata['post_title']))
				{
					$this->ajaxReturn(array('msg'=>"请输入标题",'status'=>1));
				}
				if(empty($pdata['post_excerpt']))
				{
					$this->ajaxReturn(array('msg'=>"请输入描述简介",'status'=>1));
				}
				if(count($pdata['isterm']) == 0)
				{
					$this->ajaxReturn(array('msg'=>"请选择位置",'status'=>1));
				}
				if(empty($pdata['post_imgs']))
				{
					$this->ajaxReturn(array('msg'=>"请上传轮播图",'status'=>1));
				}
				if(empty($pdata['post_content']))
				{
					$this->ajaxReturn(array('msg'=>"请输入文章内容",'status'=>1));
				}
				$article['post_title'] =strcontentjs($pdata['post_title']);
				$article['position'] =implode(',',$pdata['isterm']);
				$article['isterm'] =0;
				$article['post_excerpt'] =strcontentjs($pdata['post_excerpt']);
				$article['post_content']=strcontentjs(htmlspecialchars_decode($pdata['post_content']));
				$article['post_date'] = date('Y-m-d H:i:s');
				$article['post_img']  = $pdata['post_imgs'];
				$article['post_status'] =1;
			}else
			{
				if(empty($pdata['post_title']))
				{
					$this->ajaxReturn(array('msg'=>"请输入标题",'status'=>1));
				}
				
				if(count($pdata['isterms'])==0 && $pdata['isterm'] ==2)
				{
					$this->ajaxReturn(array('msg'=>"请选择位置",'status'=>1));
				}
				if(empty($pdata['post_img']))
				{
					$this->ajaxReturn(array('msg'=>"请上传轮播图",'status'=>1));
				}
				// 不是文章类
				if(!empty($pdata['gtype']))
				{
					switch($pdata['gtype'])
					{
						case '微课':
							if($pdata['isterm'] == 1)
							{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Task/detail',array('id'=>$pdata['ids']));
							}else{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Task/lesson_info',array('id'=>$pdata['ids']));
							}
							break;
						case '资源':
							if($pdata['isterm'] == 1)
							{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Resource/detail',array('id'=>$pdata['ids']));
							}else{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Resource/lesson_info',array('id'=>$pdata['ids']));
							}
							break;
						case '问答':
							if($pdata['isterm'] == 1)
							{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Problem/detail',array('id'=>$pdata['ids']));
							}else{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Problem/detail',array('id'=>$pdata['ids']));
							}
							break;
						default:
							break;
					}
				}else{
					$article['link_url'] =$pdata['link_url'];
				}
				if($pdata['isterm'] == 1)
				{
					$article['position'] =$pdata['isterm'];
				}else{
					$article['position'] =implode(',',$pdata['isterms']);
				}
				
				$article['isterm'] =$pdata['isterm'];
				$article['post_title'] =htmlspecialchars_decode($pdata['post_title']);
				$article['post_content']='';
				$article['post_img']=$pdata['post_img'];
				
				$article['post_date'] = date('Y-m-d H:i:s');
				$article['post_status'] =1;
			}
			
			$article['post_term'] =$pdata['post_term'];
			$result=$this->posts_model->add($article);
			if ($result) {
				if($pdata['post_term'] == 1)
				{
					$this->posts_model->where("id='$result'")->save(array('link_url'=>'http://'.$_SERVER['HTTP_HOST'].U('portal/index/article',array('id'=>$result))));
				}
				
				$this->ajaxReturn(array('msg'=>"添加成功！",'status'=>0));
			} else {
				
				$this->ajaxReturn(array('msg'=>"添加失败！",'status'=>1));
			}
			 
		}
	}
	function getopurl()
	{
		if(IS_POST)
		{
			$gtype =I('gtype','','trim');
			$isterm =I('isterm','','intval');
			$id =I('id','','intval');
			switch($gtype)
			{
				case '微课':
					if($isterm ==1)
					{
						$url ='http://'.$_SERVER['HTTP_HOST'].U('Portal/Task/detail',array('id'=>$id));
					}else{
						$url ='http://'.$_SERVER['HTTP_HOST'].U('Home/Task/lesson_info',array('id'=>$id));
					}
					break;
				case '资源':
					if($isterm ==1)
					{
						$url ='http://'.$_SERVER['HTTP_HOST'].U('Portal/Resource/detail',array('id'=>$id));
					}else{
						$url ='http://'.$_SERVER['HTTP_HOST'].U('Home/Resource/lesson_info',array('id'=>$id));
					}
					break;
				case '问答':
					if($isterm ==1)
					{
						$url ='http://'.$_SERVER['HTTP_HOST'].U('Portal/Problem/detail',array('id'=>$id));
					}else{
						$url ='http://'.$_SERVER['HTTP_HOST'].U('Home/Problem/detail',array('id'=>$id));
					}
					break;	
				default:
					break;
			}
			$this->ajaxReturn(array('status'=>0,'url'=>$url,'isterm'=>$isterm));
		}
	}
	function getoplist()
	{
		if(IS_POST)
		{
			$isterm =I('isterm','','intval');
			$gtype =I('gtype','','trim');
			$html='<option value="">请选择</option>';
							
			switch($gtype)
			{
				case '微课':
					$list=M('task')->field('id,title')->where("status=1 and type='微课'")->select();						
					foreach($list as $k=>$v){
						$html.="<option value='".$v['id']."'>".$v['title']."</option>";
					}
					break;
				case '资源':
					$list=M('task')->field('id,title')->where("status=1 and type='资源'")->select();						
					foreach($list as $k=>$v){
						$html.="<option value='".$v['id']."'>".$v['title']."</option>";
					}
					break;
				case '问答':
					$list=M('question')->field('id,title')->where("parentid=0 and type=0")->select();						
					foreach($list as $k=>$v){
						$html.="<option value='".$v['id']."'>".$v['title']."</option>";
					}
					break;	
				default:
					break;
			}
			$this->ajaxReturn(array('status'=>0,'html'=>$html,'isterm'=>$isterm));
		}
	}
	// 文章编辑
	public function edit(){
		$id=  I("get.id",0,'intval');
		
		$post=$this->posts_model->where("id=$id")->find();
		
		$post['post_img2'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$post['post_img'];		
		
		$strarray[0]['title'] = '问学帮首页';
		$strarray[0]['id'] = '2';
		$strarray[1]['title'] = '语文帮';
		$strarray[1]['id'] = '3';
		$strarray[2]['title'] = '数学帮';
		$strarray[2]['id'] = '4';
		$strarray[3]['title'] = '英语帮';
		$strarray[3]['id'] = '5';
		$strarray[4]['title'] = '物理帮';
		$strarray[4]['id'] = '6';
		$strarray[5]['title'] = '化学帮';
		$strarray[5]['id'] = '7';
		$strarray[6]['title'] = '政治帮';
		$strarray[6]['id'] = '8';
		$strarray[7]['title'] = '历史帮';
		$strarray[7]['id'] = '9';
		if($post['post_term'] ==2 && $post['isterm'] ==2)
		{
			foreach($strarray as $ke=>$v)
			{
				$result =strpos($post['position'],$v['id']);
				if($result===false)
				{
					$strarray[$ke]['isdo'] =0;
				}else
				{
					$strarray[$ke]['isdo'] =1;
				}
			}
		}
		$this->assign("blist",$strarray);
			
		
		
		$ggao[0]['name'] ='教师端';
		$ggao[0]['id'] ='1';
		$ggao[1]['name'] ='学生端';
		$ggao[1]['id'] ='2';
		if($post['post_term'] ==1)
		{
			foreach($ggao as $key=>$va)
			{
				$result =strpos($post['position'],$va['id']);
				if($result===false)
				{
					$ggao[$key]['isdo'] =0;
				}else
				{
					$ggao[$key]['isdo'] =1;
				}
			}
		}
		$this->assign("glist",$ggao);
		
		
		
		$this->assign("post",$post);
		$this->display();
	}
	public function detail(){
		$id=  I("get.id",0,'intval');
		
		$post=$this->posts_model->where("id=$id")->find();
		if($post['post_term'] ==2)
		{
			$post['post_img2'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$post['post_img'];
		}
		$this->assign("post",$post);

		$this->display();
	}
	// 文章编辑提交
	public function edit_post(){
		if (IS_POST) {			
			$pdata=I("post.");			
			$article=array();
			//file_put_contents('a90.txt',var_export($pdata,true));
			// 公告
			if($pdata['post_term'] == 1)
			{
				if(empty($pdata['post_title']))
				{
					$this->ajaxReturn(array('msg'=>"请输入标题",'status'=>1));
				}
				if(empty($pdata['post_excerpt']))
				{
					$this->ajaxReturn(array('msg'=>"请输入描述简介",'status'=>1));
				}
				if(count($pdata['isterm']) == 0)
				{
					$this->ajaxReturn(array('msg'=>"请选择位置",'status'=>1));
				}
				if(empty($pdata['post_imgs']))
				{
					$this->ajaxReturn(array('msg'=>"请上传轮播图",'status'=>1));
				}
				if(empty($pdata['post_content']))
				{
					$this->ajaxReturn(array('msg'=>"请输入文章内容",'status'=>1));
				}
				$article['position'] =implode(',',$pdata['isterm']);
				$article['isterm'] =0;
				$article['post_title'] =strcontentjs($pdata['post_title']);
				$article['post_excerpt'] =strcontentjs($pdata['post_excerpt']);
				$article['post_img'] =$pdata['post_imgs'];
				$article['post_content']=strcontentjs(htmlspecialchars_decode($pdata['post_content']));
			}else
			{
				if(empty($pdata['post_title']))
				{
					$this->ajaxReturn(array('msg'=>"请输入标题",'status'=>1));
				}
				if(count($pdata['isterms'])==0 && $pdata['isterm'] ==2)
				{
					$this->ajaxReturn(array('msg'=>"请选择位置",'status'=>1));
				}
				if(empty($pdata['post_img']))
				{
					$this->ajaxReturn(array('msg'=>"请上传轮播图",'status'=>1));
				}
				// 不是文章类
				if(!empty($pdata['gtype']))
				{
					switch($pdata['gtype'])
					{
						case '微课':
							if($pdata['istermstr'] == 1)
							{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Task/detail',array('id'=>$pdata['ids']));
							}else{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Home/Task/lesson_info',array('id'=>$pdata['ids']));
							}
							break;
						case '资源':
							if($pdata['istermstr'] == 1)
							{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Resource/detail',array('id'=>$pdata['ids']));
							}else{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Home/Resource/lesson_info',array('id'=>$pdata['ids']));
							}
							break;
						case '问答':
							if($pdata['istermstr'] == 1)
							{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Portal/Problem/detail',array('id'=>$pdata['ids']));
							}else{
								$article['link_url']='http://'.$_SERVER['HTTP_HOST'].U('Home/Problem/detail',array('id'=>$pdata['ids']));
							}
							break;
						default:
							break;
					}
				}else{
					$article['link_url'] =$pdata['link_url'];
				}
				if($pdata['istermstr'] == 1)
				{
					$article['position'] =$pdata['istermstr'];
				}else{
					$article['position'] =implode(',',$pdata['isterms']);
				}				
				$article['isterm'] =$pdata['istermstr'];
				$article['post_title'] =strcontentjs($pdata['post_title']);
				$article['post_content']='';
				$article['post_img']=$pdata['post_img'];
				
			}
			
			$article['post_term'] =$pdata['post_term'];
			$result=$this->posts_model->where("id='".$pdata['id']."'")->save($article);
			
			if ($result!==false) {
				if($pdata['post_term'] == 1)
				{
					$this->posts_model->where("id='".$pdata['id']."'")->save(array('link_url'=>'http://'.$_SERVER['HTTP_HOST'].U('portal/index/article',array('id'=>$pdata['id']))));
				}
				$this->ajaxReturn(array('msg'=>'保存成功！','status'=>0));
			} else {
				$this->ajaxReturn(array('msg'=>'保存失败！','status'=>1));
			}
		}
	}
	
	// 文章排序
	public function listorders() {
		$status = parent::_listorders($this->term_relationships_model);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	/**
	 * 文章列表处理方法,根据不同条件显示不同的列表
	 * @param array $where 查询条件
	 */
	private function _lists($where=array()){
		$term_id=I('request.term',0,'intval');
		
		$where=array();
		
		if(!empty($term_id)){
		    $where['post_term']=$term_id;
		    $this->assign('post_term',$term_id);
		}
		
		$keyword=I('request.keyword');
		if(!empty($keyword)){
		    $where['post_title']=array('like',"%$keyword%");
		}
		$count=$this->posts_model->where($where)->count();
			
		$page = $this->page($count, 20);
			
		$posts=$this->posts_model
		->where($where)
		->limit($page->firstRow , $page->listRows)
		->order("post_date DESC")
		->select();
		
		foreach ($posts as $key => $value) {
			if($value['post_term'] == 2)
			{
				$posts[$key]['post_img2'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$value['post_img'];
			}
			if($value['post_content'])
			{
				$posts[$key]['post_content'] =mb_substr(strip_tags($value['post_content']),0,30,'utf-8');
			}
			$position=explode(',',$value['position']);
			if($value['post_term'] == 2)
			{
				$positionstr='';
				foreach($position as $k=>$v)
				{
					switch ($v) {
						case '1':
							$title ='教师端';
							break;
						case '2':
							$title ='问学帮首页';
							break;
						case '3':
							$title='语文帮';
							break;
						case '4':
							$title='数学帮';
							break;
						case '5':
							$title='英语帮';
							break;
						case '6':
							$title='物理帮';
							break;
						case '7':
							$title='化学帮';
							break;
						case '8':
							$title='政治帮';
							break;
						case '9':
							$title='历史帮';
							break;
						default:
							# code...
							break;
					}
					$positionstr .=$title.',';
				}
				if($positionstr)
				{
					$positionstr =substr($positionstr,0,-1);
				}
				$posts[$key]['positionstr'] =$positionstr;
				$positionstr='';
			}else{
				$positionstr='';
				foreach($position as $k=>$v)
				{
					switch ($v) {
						case '1':
							$title ='教师端';
							break;
						case '2':
							$title ='学生端';
							break;						
						default:
							# code...
							break;
					}
					$positionstr .=$title.',';
				}
				if($positionstr)
				{
					$positionstr =substr($positionstr,0,-1);
				}
				$posts[$key]['positionstr'] =$positionstr;
				$positionstr='';
			}
			
		}
		$this->assign("page", $page->show('Admin'));
		$this->assign("formget",array_merge($_GET,$_POST));
		$this->assign("posts",$posts);
	}
	
	// 获取文章分类树结构 select 形式
	private function _getTree(){
		$term_id=empty($_REQUEST['term'])?0:intval($_REQUEST['term']);
		$result = $this->terms_model->order(array("listorder"=>"asc"))->select();
		
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("AdminTerm/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("AdminTerm/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="js-ajax-delete" href="' . U("AdminTerm/delete", array("id" => $r['term_id'])) . '">删除</a> ';
			$r['visit'] = "<a href='#'>访问</a>";
			$r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['selected']=$term_id==$r['term_id']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
	
	// 获取文章分类树结构 
	private function _getTermTree($term=array()){
		$result = $this->terms_model->order(array("listorder"=>"asc"))->select();
		
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("AdminTerm/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("AdminTerm/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="js-ajax-delete" href="' . U("AdminTerm/delete", array("id" => $r['term_id'])) . '">删除</a> ';
			$r['visit'] = "<a href='#'>访问</a>";
			$r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['selected']=in_array($r['term_id'], $term)?"selected":"";
			$r['checked'] =in_array($r['term_id'], $term)?"checked":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
	
	// 文章删除
	public function delete(){
		if(isset($_GET['id'])){
			$id = I("get.id",0,'intval');
			if ($this->posts_model->where(array('id'=>$id))->delete() !==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
		
	}
	
	// 文章审核
	public function check(){
		if(isset($_POST['ids']) && $_GET["check"]){
		    $ids = I('post.ids/a');
			
			if ( $this->posts_model->where(array('id'=>array('in',$ids)))->save(array('post_status'=>1)) !== false ) {
				$this->success("审核成功！");
			} else {
				$this->error("审核失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
		    $ids = I('post.ids/a');
		    
			if ( $this->posts_model->where(array('id'=>array('in',$ids)))->save(array('post_status'=>0)) !== false) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
	}
	
	// 文章置顶
	public function top(){
		if(isset($_POST['ids']) && $_GET["top"]){
			$ids = I('post.ids/a');
			
			if ( $this->posts_model->where(array('id'=>array('in',$ids)))->save(array('istop'=>1))!==false) {
				$this->success("置顶成功！");
			} else {
				$this->error("置顶失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["untop"]){
		    $ids = I('post.ids/a');
		    
			if ( $this->posts_model->where(array('id'=>array('in',$ids)))->save(array('istop'=>0))!==false) {
				$this->success("取消置顶成功！");
			} else {
				$this->error("取消置顶失败！");
			}
		}
	}
	
	// 文章推荐
	public function recommend(){
		if(isset($_POST['ids']) && $_GET["recommend"]){
			$ids = I('post.ids/a');
			
			if ( $this->posts_model->where(array('id'=>array('in',$ids)))->save(array('recommended'=>1))!==false) {
				$this->success("推荐成功！");
			} else {
				$this->error("推荐失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["unrecommend"]){
		    $ids = I('post.ids/a');
		    
			if ( $this->posts_model->where(array('id'=>array('in',$ids)))->save(array('recommended'=>0))!==false) {
				$this->success("取消推荐成功！");
			} else {
				$this->error("取消推荐失败！");
			}
		}
	}
	
	// 文章批量移动
	public function move(){
		if(IS_POST){
			if(isset($_GET['ids']) && $_GET['old_term_id'] && isset($_POST['term_id'])){
			    $old_term_id=I('get.old_term_id',0,'intval');
			    $term_id=I('post.term_id',0,'intval');
			    if($old_term_id!=$term_id){
			        $ids=explode(',', I('get.ids/s'));
			        $ids=array_map('intval', $ids);
			         
			        foreach ($ids as $id){
			            $this->term_relationships_model->where(array('object_id'=>$id,'term_id'=>$old_term_id))->delete();
			            $find_relation_count=$this->term_relationships_model->where(array('object_id'=>$id,'term_id'=>$term_id))->count();
			            if($find_relation_count==0){
			                $this->term_relationships_model->add(array('object_id'=>$id,'term_id'=>$term_id));
			            }
			        }
			        
			    }
			    
			    $this->success("移动成功！");
			}
		}else{
			$tree = new \Tree();
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$terms = $this->terms_model->order(array("path"=>"ASC"))->select();
			$new_terms=array();
			foreach ($terms as $r) {
				$r['id']=$r['term_id'];
				$r['parentid']=$r['parent'];
				$new_terms[] = $r;
			}
			$tree->init($new_terms);
			$tree_tpl="<option value='\$id'>\$spacer\$name</option>";
			$tree=$tree->get_tree(0,$tree_tpl);
			 
			$this->assign("terms_tree",$tree);
			$this->display();
		}
	}
	
	
    public function ban(){
        $id = I('get.id',0,'intval');
    	if (!empty($id)) {
    		$result = $this->posts_model->where(array("id"=>$id))->setField('post_status','0');
    		if ($result!==false) {
    			$this->success("下架成功！", U("AdminPost/index"));
    		} else {
    			$this->error('下架失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }

   
    public function cancelban(){
    	$id = I('get.id',0,'intval');
    	if (!empty($id)) {
    		$result = $this->posts_model->where(array("id"=>$id))->setField('post_status','1');
    		if ($result!==false) {
    			$this->success("上架成功！", U("AdminPost/index"));
    		} else {
    			$this->error('上架失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
	
}