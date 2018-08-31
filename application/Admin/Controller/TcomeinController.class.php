<?php
// +----------------------------------------------------------------------
// | 教师收入管理
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TcomeinController extends AdminbaseController {
	public function index()
	{
		$where = array('coin > 0');
		/**搜索条件**/
		$request=I('request.');
		$nicename = I('request.nicename');
		$starttime =I('starttime','','trim');
        $endtime   =I('endtime','','trim');
			
		if($nicename){
			$where['nicename'] = array('like',"%$nicename%");;
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
		$count=M('teacher')->where($where)->count();
		$page = $this->page($count, 20);
        $users = M('teacher')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
        foreach ($users as $key => $value) {
            // 已提现金额 
            $comein =M('orders')->where("teacherid='".$value['id']."' and orderstatus=1")->sum('tccoin');
            $users[$key]['totalin'] = $comein ? $comein :'0.00';
            $tixianprice =M('tixianlog')->where("teacherid='".$value['id']."' and status=1")->sum('price');
            $users[$key]['tixianprice'] =$tixianprice ? $tixianprice : '0.00';
        	$datalist[$key]['id'] =$value['id'];
        	$datalist[$key]['nicename'] =$value['nicename'];
        	$datalist[$key]['mobile'] =$value['mobile'];
        	$datalist[$key]['totalin'] =$users[$key]['totalin'];
        	$datalist[$key]['tixianprice'] =$users[$key]['tixianprice'];
        	$datalist[$key]['coin'] =$value['coin'];
        }
		if($request['export'] == '导出Excel')
        {
            $xlsCell  = array(
                array('id','序号'),
                array('nicename','教师姓名'),
                array('mobile','账号'),
                array('totalin','收入金额（元）'),
                array('tixianprice','已提现金额'),
                array('coin','未提现金额')     
            );
            exportExcel("教师收入记录",$xlsCell,$datalist);
        }
		$this->assign("page", $page->show('Admin'));
		
		$this->assign("list",$users);
        $this->display();
	}
    // 收入明细
    public function dlist()
    {
        $id =I('id','','intval');
        $where = array("orderstatus"=>1,'teacherid'=>$id);
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
        // 类型
        $typelist =M('orders')->field('type')->group('type')->select();
        foreach ($users as $key => $value) {
            $users[$key]['mobile'] =M('teacher')->where("id='".$value['teacherid']."'")->getField('mobile');
            $datalist[$key]['id'] =$value['id'];
            $datalist[$key]['ordersn'] =$value['ordersn'];
            $datalist[$key]['addtime'] =date('Y-m-d H:i',$value['addtime']);
            $datalist[$key]['teachername'] =$value['teachername'];
            $datalist[$key]['mobile'] =$users[$key]['mobile'];
            $datalist[$key]['username'] =$value['username'];
            $datalist[$key]['type'] =$value['type'];
            $datalist[$key]['tccoin'] =$value['tccoin'];
        }
        if($request['export'] == '导出Excel')
        {
            $xlsCell  = array(
                array('id','序号'),
                array('ordersn','单号'),
                array('addtime','收入时间'),
                array('teachername','教师姓名'),
                array('mobile','教师账号'),
                array('username','支付会员'),
                array('type','收入类型'),
                array('orderprice','收入金额')     
            );
            exportExcel2("收入明细记录",$xlsCell,$datalist);
        }
        $this->assign("list",$users);
        $this->assign("page", $page->show('Admin'));
        $this->assign("typelist",$typelist);
        $this->assign('id',$id);
        $this->display();
    }

    public function tixianlist()
    {

        $id =I('id','','intval');
        $where = array("teacherid"=>$id);
        /**搜索条件**/
        
        $starttime =I('starttime','','trim');
        $endtime   =I('endtime','','trim');
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
        $count=M('tixianlog')->where($where)->count();
        $page = $this->page($count, 20);
        $list = M('tixianlog')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
        foreach ($list as $key => $value) {
            $info =M('teacher')->where("id='".$value['teacherid']."'")->find();

            $list[$key]['teachername'] = $info['nicename'];
            $list[$key]['mobile'] = $info['mobile'];
            if($value['status'] == 0)
            {
                $list[$key]['statusname'] = '未提现';
            }else
            {
                $list[$key]['statusname'] = '已提现';
            }
        }
        $this->assign('list',$list);
        $this->assign("page", $page->show('Admin'));
        $this->display();
    }

    // 提现明细
    public function txdetaillist()
    {
        $id =I('id','','intval');
        $where = array("logid"=>$id);
        /**搜索条件**/
         
        $count=M('orders')->where($where)->count();
        $page = $this->page($count, 20);
        $list = M('orders')
            ->where($where)
            ->order("addtime DESC")
            ->limit($page->firstRow, $page->listRows)
            ->select();
        foreach ($list as $key => $value) {
            $info =M('teacher')->field('mobile')->where("id='".$value['teacherid']."'")->find();
            $list[$key]['mobile'] =$info['mobile'];
        }
        $this->assign('list',$list);
        $this->assign("page", $page->show('Admin'));
        $this->display();
    }
}