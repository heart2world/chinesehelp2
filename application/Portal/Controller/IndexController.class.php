<?php

// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomebaseController; 
/**
 * 首页
 */
class IndexController extends HomebaseController {
	
    //首页 小夏是老猫除外最帅的男人了
	public function index() {
		$this->check_login();
		$this->check_user();
		if(!empty($_SESSION['user']['id']))
		{
			$uinfo =M('teacher')->where("id='".$_SESSION['user']['id']."'")->find();
			$this->assign('uinfo', $uinfo);			
			if($uinfo['status'] != 1)
			{
				redirect(U('User/Center/apply'));exit();
			}
			
		}
		// 轮播图
		$imgs =M('posts')->field('id,post_title,link_url,post_img')->where("post_term=2 and post_status=1 and isterm=1 and position like '%1%'")->select();
		foreach ($imgs as $k => $val) {
			if(!empty($val['post_img']))
			{
				$imgs[$k]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$val['post_img'];
			}			
		}		
		// 上架的平台公告
		$article =M('posts')->field('id,post_title,post_date,post_excerpt,link_url,post_img')->where("post_term=1 and post_status=1 and position like '%1%'")->order('post_date desc')->limit(5)->select();
		foreach ($article as $key => $value) {
			$article[$key]['post_excerpt'] = mb_substr(strip_tags($value['post_excerpt']),0,30,'utf-8');
			$article[$key]['addtime'] =  date('Y-m-d',strtotime($value['post_date']));
			if(!empty($value['post_img']))
			{
				$article[$key]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$value['post_img'];
			}
		}
		$option=get_caiwu_options();
		if($_SESSION['user']['id'])
		{
			$ancount =M('question')->where("isdo=0 and teacherid='".$_SESSION['user']['id']."'")->count();
			$this->assign('ancount', $ancount);
		}
		updateTeacher();
		
		$this->assign('option', $option);
		$this->assign('article',$article);
		$this->assign('imgs',$imgs);
    	$this->display(":index");
    }
	public function articlelist()
	{
		// 上架的平台公告
		$article =M('posts')->field('id,post_title,post_date,post_excerpt,link_url,post_img')->where("post_term=1 and post_status=1 and position like '%1%'")->order('post_date desc')->select();
		
		foreach ($article as $key => $value) {
			$article[$key]['post_excerpt'] = mb_substr(strip_tags($value['post_excerpt']),0,30,'utf-8');
			$article[$key]['addtime'] =  date('Y-m-d',strtotime($value['post_date']));
			if(!empty($value['post_img']))
			{
				$article[$key]['post_img'] ='http://'.$_SERVER['HTTP_HOST'].'/'.$value['post_img'];
			}
		}
		$this->assign('article',$article);
		$this->display(':articlelist');
	}
    public function article()
    {
    	$id=I('id','','intval');
    	$article =M('posts')->field('id,post_title,post_excerpt,post_content')->where("id='$id'")->find();
    	$this->assign('article',$article);
    	
    	$this->display(':article');
    }
    public function share_code()
	{
		$mid=I('mid','','intval');
		$codeimg =M('teacher')->where("id='".$mid."'")->getField('scode');
		if($codeimg)
		{
			$codeimg ='http://'.$_SERVER['HTTP_HOST'].'/'.$codeimg;
		}
		$this->assign('codeimg',$codeimg);
		$this->display(':scode');
	}
	public function teacher_code()
	{
		$mid=I('mid','','intval');
		$codeimg =M('teacher')->where("id='".$mid."'")->getField('tcode');
		if($codeimg)
		{
			$codeimg ='http://'.$_SERVER['HTTP_HOST'].'/'.$codeimg;
		}
		$this->assign('codeimg',$codeimg);
		$this->display(':tcode');
	}
}


