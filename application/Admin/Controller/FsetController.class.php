<?php
// +----------------------------------------------------------------------
// | 财务设置
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class FsetController extends AdminbaseController {
	public function index()
	{
		$option=M('options')->where("option_id='9'")->find();
		$this->assign(json_decode($option['option_value'],true));
        $this->display();
	}

	public function edit_post()
	{
		if(IS_POST)
		{
			$options=I('post.options/a');
			if(!empty($options['wxpersent']) && $options['wxpersent'] > 100)
			{
				$this->ajaxReturn(array('msg'=>'设置比例不能超出100','status'=>1));
			}
			if(!empty($options['cdpersent']) && $options['cdpersent'] > 100)
			{
				$this->ajaxReturn(array('msg'=>'设置比例不能超出100','status'=>1));
			}
			if(!empty($options['zypersent']) && $options['zypersent'] > 100)
			{
				$this->ajaxReturn(array('msg'=>'设置比例不能超出100','status'=>1));
			}
			$data['option_value']=json_encode($options);
			
			M('options')->where("option_id='9'")->save($data);
			$this->ajaxReturn(array('msg'=>'保存成功','status'=>0));
		}
	}
}