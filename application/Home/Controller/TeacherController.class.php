<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: gaoqiang <649180397@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
/**
 * 教师列表
 */
class TeacherController extends Controller {
	public function index()
	{
		$type=I('type','0','intval');
		if($type < 3 || $type > 9)
		{
			redirect(U('Home/index/index'));
		}
		switch ($type) {
			case '3':
				$typename ='语文';
				$qtypelist[0]['typename'] ='中国文化趣谈';
				$qtypelist[1]['typename'] ='西方文化趣谈';
				$qtypelist[2]['typename'] ='基础知识应试技巧';
				$qtypelist[3]['typename'] ='综合性学习应试技巧';
				$qtypelist[4]['typename'] ='记叙文小说应试技巧';
				$qtypelist[5]['typename'] ='说明文应试技巧';
				$qtypelist[6]['typename'] ='议论文应试技巧';
				$qtypelist[7]['typename'] ='作文应试技巧';
				$qtypelist[8]['typename'] ='课内现代文导读';
				$qtypelist[9]['typename'] ='课内古诗文导读';
				$qtypelist[10]['typename'] ='课外阅读指南';
				$qtypelist[11]['typename'] ='学科渗透及其他';
				break;
			case '4':
				$typename ='数学';
				$qtypelist[0]['typename'] ='实数';
				$qtypelist[1]['typename'] ='代数式';
				$qtypelist[2]['typename'] ='整式';
				$qtypelist[3]['typename'] ='分式';
				$qtypelist[4]['typename'] ='方程（组）与不等式组';
				$qtypelist[5]['typename'] ='变量与函数';
				$qtypelist[6]['typename'] ='图形的认识';
				$qtypelist[7]['typename'] ='圆';
				$qtypelist[8]['typename'] ='空间与图形';
				$qtypelist[9]['typename'] ='统计与概率';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '5':
				$typename ='英语';
				$qtypelist[0]['typename'] ='听力';
				$qtypelist[1]['typename'] ='单选';
				$qtypelist[2]['typename'] ='完型';
				$qtypelist[3]['typename'] ='阅读';
				$qtypelist[4]['typename'] ='任务性阅读';
				$qtypelist[5]['typename'] ='正确形式填空';
				$qtypelist[6]['typename'] ='完成句子';
				$qtypelist[7]['typename'] ='短文填空';
				$qtypelist[8]['typename'] ='作文';
				$qtypelist[9]['typename'] ='口语交际';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '6':
				$typename ='物理';
				$qtypelist[0]['typename'] ='质量密度';
				$qtypelist[1]['typename'] ='压力压强';
				$qtypelist[2]['typename'] ='浮力';
				$qtypelist[3]['typename'] ='简单机械';
				$qtypelist[4]['typename'] ='功率和机械效率';
				$qtypelist[5]['typename'] ='电学';
				$qtypelist[6]['typename'] ='光学';
				$qtypelist[7]['typename'] ='运动学';
				$qtypelist[8]['typename'] ='热学';
				$qtypelist[9]['typename'] ='其他';
				break;
			case '7':
				$typename ='化学';
				$qtypelist[0]['typename'] ='空气与O２';
				$qtypelist[1]['typename'] ='碳和碳的氧化物';
				$qtypelist[2]['typename'] ='水及溶液';
				$qtypelist[3]['typename'] ='金属与金属材料';
				$qtypelist[4]['typename'] ='酸和碱';
				$qtypelist[5]['typename'] ='盐和化肥';
				$qtypelist[6]['typename'] ='常见气体的制取';
				$qtypelist[7]['typename'] ='化学式和化合价、构成物质的微粒';
				$qtypelist[8]['typename'] ='化学与生活、化学与能源';
				$qtypelist[9]['typename'] ='化学计算';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '8':
				$typename ='政治';
				$qtypelist[0]['typename'] ='尊重、宽容、理解';
				$qtypelist[1]['typename'] ='诚信、竞争、合作';
				$qtypelist[2]['typename'] ='个人、集体、责任、公平、正义';
				$qtypelist[3]['typename'] ='网络的利与弊';
				$qtypelist[4]['typename'] ='法律基本知识';
				$qtypelist[5]['typename'] ='公民的权利与义务';
				$qtypelist[6]['typename'] ='未成年人的特殊保护';
				$qtypelist[7]['typename'] ='国策、战略、理念';
				$qtypelist[8]['typename'] ='发展道路、理论体系、伟人旗帜';
				$qtypelist[9]['typename'] ='政治学科核心观点';
				$qtypelist[10]['typename'] ='其他';
				break;
			case '9':
				$typename ='历史';
				$qtypelist[0]['typename'] ='古今中外文明交往';
				$qtypelist[1]['typename'] ='中国古代科技文化';
				$qtypelist[2]['typename'] ='大国关系';
				$qtypelist[3]['typename'] ='中华民族复兴';
				$qtypelist[4]['typename'] ='两次世界大战';
				$qtypelist[5]['typename'] ='省市本土历史';
				$qtypelist[6]['typename'] ='中共党史';
				$qtypelist[7]['typename'] ='重要历史人物';
				$qtypelist[8]['typename'] ='热点时事连线';					
				$qtypelist[9]['typename'] ='其他';
				break;
			default:
				# code...
				break;
		}
		$this->assign('qtypelist',$qtypelist);
		$tlist =M('teacher')->field('id,nicename,truename,headimg,honors,isonline')->where("status=1 and xueke='$typename'")->order('isonline ASC')->select();
		foreach($tlist as $k=>$val){
			$tlist[$k]['qcount'] = M('answer')->where("teacherid='".$val['id']."'")->count();
			$tlist[$k]['colcount'] = M('collect_task')->where("taskid='".$val['id']."' and type='教师'")->count();
			$info =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$val['id']."' and isend=1")->find();
			$tlist[$k]['star'] = number_format($info['star'],1);

			$starttime =time()-7*3600*24;
			$count =M('answer')->where("teacherid='".$val['id']."' and addtime > '$starttime'")->count();
			M('teacher')->where("id='".$val['id']."'")->save(array('number' =>$count));
			
			$tlist[$k]['iscollect'] = M('collect_task')->where("taskid='".$val['id']."' and userid='".$_SESSION['student']['id']."'  and type='教师'")->count();
		}
		
		$this->assign('tlist',$tlist);
		$this->assign('type',$type);
		$this->display();
	}
	public function teacher_info()
	{
		$id=I('id','','intval');
		$tinfo =M('teacher')->find($id);
		$tinfo['qcount'] =M('answer')->where("teacherid='".$tinfo['id']."'")->count();
		$tinfo['colcount'] =M('collect_task')->where("taskid='".$tinfo['id']."' and type='教师'")->count();
		$tinfo['iscollect'] =M('collect_task')->where("taskid='".$tinfo['id']."' and userid='".$_SESSION['student']['id']."' and type='教师'")->count();
		$this->assign('tinfo',$tinfo);

		//题库列表
		$plist =D()->field('b.*,a.addtime as addtime2')->table(C('DB_PREFIX')."answer a,".C('DB_PREFIX').'question b')->where("b.id=a.questionid and b.isfree=2 and b.parentid=0 and a.teacherid='".$tinfo['id']."'")->order("a.addtime desc")->select();
		foreach ($plist as $key => $value) {
			$plist[$key]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
		}
		$this->assign('plist',$plist);
		// 微课
		$wklist = M('task')->where("status=1 and type='微课' and userid='".$tinfo['id']."'")->select();
		foreach ($wklist as $ky => $val) {
			$wklist[$ky]['colcount'] =M('collect_task')->where("taskid='".$val['id']."' and type='微课'")->count();
		}
		// 资源
		$zylist = M('task')->where("status=1 and type='资源' and userid='".$tinfo['id']."'")->select();
		foreach ($zylist as $ky => $va) {
			$zylist[$ky]['colcount'] =M('collect_task')->where("taskid='".$tinfo['id']."' and type='资源'")->count();
		}
		// 专题
		$ztlist = M('zhuantis')->where("teacherid='$id'")->order('addtime desc')->select();
		foreach($ztlist as $k=>$v)
		{
			$ztlist[$k]['colcount'] =M('collect_task')->where("taskid='".$v['id']."' and type='专题'")->count();
		}
		$this->assign('ztlist',$ztlist);
		$this->assign('wklist',$wklist);
		$this->assign('zylist',$zylist);
		$this->display();
	}
	function getteacherlist()
	{
		if(IS_POST)
		{
			$title =I('title','','trim');
			$schoolname =I('schoolname','','trim');
			$questiontype =I('questiontype','','trim');
			$number  =I('number','','trim');
			$type=I('type','','intval');
			switch ($type) {
				case '3':
					$typename ='语文';
					break;
				case '4':
					$typename ='数学';
					break;
				case '5':
					$typename ='英语';
					break;
				case '6':
					$typename ='物理';
					break;
				case '7':
					$typename ='化学';
					break;
				case '8':
					$typename ='政治';
					break;
				case '9':
					$typename ='历史';
					break;
				default:
					# code...
					break;
			}
			$where =array("status=1 and xueke='$typename'");
			if($title && $title!='职称')
			{
				$where['title'] = $title;
			}
			if($schoolname && $schoolname!='学校')
			{
				$where['schoolname'] = $schoolname;
			}
			if($questiontype && $questiontype!='教师擅长')
			{
				$where['questiontype'] =  array('like', "%$questiontype%");
			}
			if($number && $number!='本周答题数')
			{
				$num =explode('-', $number);
				$where['number'] =  array('between',array($num[0],$num[1]));
			}
			
			$tlist =M('teacher')->field('id,nicename,truename,headimg,honors,isonline')->where($where)->order('isonline asc')->select();
			file_put_contents('a3232.txt',M('teacher')->getLastSql());
			foreach ($tlist as $key => $val) {
				$starttime =time()-7*3600*24;
				$count =M('answer')->where("teacherid='".$val['id']."' and addtime > '$starttime'")->count();
				M('teacher')->where("id='".$val['id']."'")->save(array('number' =>$count));
				$tlist[$key]['iscollect'] = M('collect_task')->where("taskid='".$val['id']."' and userid='".$_SESSION['student']['id']."'  and type='教师'")->count();
			}
			
			$html='';
			foreach($tlist as $k=>$val){
				$tlist[$k]['qcount'] = M('answer')->where("teacherid='".$val['id']."'")->count();
				$tlist[$k]['colcount'] = M('collect_task')->where("userid='".$val['id']."' and type='教师'")->count();
				$info =M('question')->field("avg(star) as star")->where("parentid=0 and teacherid='".$val['id']."' and isend=1")->find();
				$tlist[$k]['star'] = number_format($info['star'],1);
				$html.="<li class=\"list-item\">
						<a href=".U('Home/Teacher/teacher_info',array('id'=>$val['id']))." class=\"app-flex\" style=\"width:100%\">";
				switch ($val['isonline']) {
					case '1':
						$html.="<div class=\"teacher-avatar\">";
						break;
					case '2':
						$html.="<div class=\"teacher-avatar busy\">";
						break;
					case '3':
						$html.="<div class=\"teacher-avatar offline\">";
						break;
					default:
						# code...
						break;
				}
				
				$html.="<img src=".$val['headimg']." alt=\"img\">
							</div>
							<div class=\"teacher-info app-basis\">
								<h4 style=\"font-size:0.8rem;color:#333\">".$val['truename']."</h4>
								<p style=\"font-size:.8rem;color:#999\">".$val['honors']."</p>
								<p style=\"font-size:.8rem;color:#999\">综合评分: ".$tlist[$k]['star']."</p>
								<div class=\"teacher-attention-num app-flex\">
									<h4>".$tlist[$k]['qcount']."</h4>
									<h5>".$tlist[$k]['colcount']."</h5>
								</div>
							</div>";
				if($val['iscollect'] ==1)
				{
					$html.="<div class=\"favar-btn favared\" @click=\"add_favar_or_cancel($event,'".$val['id']."');\"></div>";
				}else
				{
					$html.="<div class=\"favar-btn\" @click=\"add_favar_or_cancel($event,'".$val['id']."');\"></div>";
				}
							
				$html.="</a></li>";
			}
			$this->ajaxReturn(array('status'=>1,'html'=>$html));
		}
	}
}