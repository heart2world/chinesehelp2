<?php
// +----------------------------------------------------------------------
// | 会员消费管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class OrdersController extends AdminbaseController {
	public function index()
	{
		$where = array("orderstatus"=>1);
		/**搜索条件**/
		$request=I('request.');
		$typename = I('request.typename');
		$username = I('request.username');
		$starttime =I('starttime','','trim');
        $endtime   =I('endtime','','trim');
		if(!empty($typename)){
			$where['type'] = array('like',"%$typename%");
            $this->assign('typename',$typename);
		}		
		if($username){
			$where['username'] = array('like',"%$username%");;
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
		$count=M('orders')->where($where)->count();
		$page = $this->page($count, 20);
        $users = M('orders')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
        foreach ($users as $key => $value) {
        	$datalist[$key]['id'] =$value['id'];
        	$datalist[$key]['ordersn'] =$value['ordersn'];
        	$datalist[$key]['addtime'] =date('Y-m-d H:i',$value['addtime']);
        	$datalist[$key]['username'] =$value['username'];
        	$datalist[$key]['type'] =$value['type'];
        	$datalist[$key]['orderprice'] =$value['orderprice'];
        }
        $typelist =M('orders')->field('type')->group('type')->select();
		if($request['export'] == '导出Excel')
        {
            $xlsCell  = array(
                array('id','序号'),
                array('ordersn','单号'),
                array('addtime','消费时间'),
                array('username','会员'),
                array('type','消费类型'),
                array('orderprice','消费金额')     
            );
            exportExcel("会员消费记录",$xlsCell,$datalist);
        }
        // 类型
		$this->assign("page", $page->show('Admin'));
		$this->assign("typelist",$typelist);
		$this->assign("orders",$users);
        $this->display();
	}
}