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
class TotalController extends AdminbaseController {
	public function index()
	{
		// 会员总消费
		$pricetotal =M('orders')->where("orderstatus=1")->sum('orderprice');
		$pricetotal =$pricetotal ? $pricetotal:'0';
		$pricewk =M('orders')->where("orderstatus=1 and type='购买微课'")->sum('tccoin');
		$priceds =M('orders')->where("orderstatus=1 and type='为TA充电'")->sum('tccoin');
		$pricezy =M('orders')->where("orderstatus=1 and type='购买资源'")->sum('tccoin');
		// 会员注册人数
		$mcount =M('member')->count();
		// 教师注册人数
		$tcount =M('teacher')->count();
		$uorderlist =M('orders')->field('userid')->where("orderstatus=1")->group('userid')->select();
		$orderusercount =count($uorderlist);
		if($orderusercount > 0 && $mcount > 0)
		{
			$persont =round($orderusercount/$mcount*100,2);
		}

		$option=M('options')->where("option_id='9'")->find();
		$optionvalue = json_decode($option['option_value'],true);
		
		$ticheng = $pricewk + $priceds +$pricezy;
		$ptprice =$pricetotal-$ticheng;
		$persont= $persont ? $persont :'0';
		$info =array('pricetotal'=>$pricetotal,'mcount'=>$mcount,'tcount'=>$tcount,'persont'=>$persont,'ticheng'=>$ticheng,'ptprice'=>$ptprice);
		$this->assign('info',$info);
		$this->display();
	}
}