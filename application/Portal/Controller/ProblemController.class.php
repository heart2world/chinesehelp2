<?php
/**
 * 	 问答
 */
namespace Portal\Controller;
use Common\Controller\MemberbaseController;
use \Qiniu\Auth;
use \Qiniu\Storage\UploadManager;
use \Qiniu\Storage\BucketManager;
class ProblemController extends MemberbaseController {
	const APPID ='wx34dd37f9256128a8';
    const APPSECRET='05adb450c3107e9646b65a97c58742b5';
	 
	function _initialize(){
		parent::_initialize();
	}
	//我的问答
	public function index()
	{
		$uinfo =$this->user;
		//已解答的问题列表
		$plist =D()->field('b.*,a.addtime as addtime2')->table(C('DB_PREFIX')."answer a,".C('DB_PREFIX').'question b')->where("b.id=a.questionid and b.parentid=0 and a.teacherid='".$uinfo['id']."'")->order("a.addtime desc")->select();
		foreach ($plist as $key => $value) {
			$plist[$key]['colcount'] =M('collect_task')->where("taskid='".$value['id']."' and type='问答'")->count();
		}
		$this->assign('plist',$plist);

		// 待解答问题列表
		$unlist =M('question')->where("isdo=0 and teacherid='".$uinfo['id']."'")->order('addtime desc')->select();
		$this->assign('unlist',$unlist);
		$this->display();
	}
	// 解答提问详情
	public function answerinfo()
	{
		$id=I('id','','intval');
		$uinfo =$this->user;
		$qinfo = M('question')->where("id='$id' and teacherid='".$uinfo['id']."'")->find();
		$qinfo['content'] =json_decode($qinfo['content'],true);		
		$this->assign('imgtaudio',$qinfo['content']);
		$this->assign('qinfo',$qinfo);
		// 学生名称
		$username =M('member')->where("id='".$qinfo['userid']."'")->getField('nicename');
		$this->assign('username',$username);

		$qcount =M('question')->where("userid='".$qinfo['userid']."' and teacherid='".$uinfo['id']."'")->count();
		$this->assign('qcount',$qcount);
		$this->display();
	}
	// 解答提问
	public function answerline()
	{
		$id=I('id','','intval');
		
		$uinfo =$this->user;
		$qinfo = M('question')->where("id='$id' and teacherid='".$uinfo['id']."'")->find();
		$qinfo['content'] =json_decode($qinfo['content'],true);		
		$this->assign('imgtaudio',$qinfo['content']);
		$this->assign('qinfo',$qinfo);
		// jssdk微信授权获取信息
		$jssdk = new \Think\JSSDK(self::APPID,self::APPSECRET);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
		
		$this->display();
	}
	// 解答详情
	public function  detail()
	{
		$id=I('id','','intval');
		$uinfo =$this->user;
		// 主问题
		$qinfo = M('question')->where("id='$id' and teacherid='".$uinfo['id']."' and parentid=0")->find();
		$content =json_decode($qinfo['content'],true);		
		$this->assign('imgtaudio',$content);
		
		$this->assign('qinfo',$qinfo);
		// 主问题回答
		$aninfo =M('answer')->where("questionid='$id' and teacherid='".$uinfo['id']."'")->find();
		if($aninfo)
		{
			$content1 =json_decode($aninfo['content'],true);		
			$this->assign('imgtaudio1',$content1);
			$this->assign('aninfo',$aninfo);
			// 追问问题
			$agqinfo =M('question')->where("parentid='".$qinfo['id']."' and teacherid='".$uinfo['id']."'")->find();
			if($agqinfo)
			{
				$content2 =json_decode($agqinfo['content'],true);		
				$this->assign('imgtaudio2',$content2);
				$this->assign('agqinfo',$agqinfo);
				// 追问回答
				 $anaginfo =M('answer')->where("questionid='".$agqinfo['id']."' and teacherid='".$uinfo['id']."'")->find();
				 if($anaginfo)
				 {
					$content3 =json_decode($anaginfo['content'],true);		
					$this->assign('imgtaudio3',$content3);
				 	$this->assign('anaginfo',$anaginfo);
				 }
			}
		}
		$this->display();
	}
	function dofree()
	{
		if(IS_POST)
		{
			$pdata=I('post.');
			$res=M('question')->where("id='".$pdata['id']."'")->save(array('isfree'=>$pdata['isfree']));
			if($res)
			{
				$this->ajaxReturn(array('status'=>0));
			}
		}
	}
	// 上传图片
	function getimgpost()
	{
		if(IS_POST)
		{
			$access_token=I('access_token','','trim');
			$media_id=I('media_id','','trim');
			$url ="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;			
			$urldemo =file_get_contents($url);
			
			if($urldemo)
			{
				 $imgurl = "./data/upload/images/".date('Ymd').rand(10000,99999).".jpg";
				
				 $resource = fopen($imgurl, 'w+');  
				 //将图片内容写入上述新建的文件  
				 fwrite($resource, $urldemo);  
				 //关闭资源  
				 fclose($resource);  
				 $strimgurl ='http://'.$_SERVER['HTTP_HOST'].'/'.$imgurl;								 
				 $this->ajaxReturn(array('status'=>1,'imgurl'=>$imgurl,'strimgurl'=>$strimgurl));
			}else{
				$this->ajaxReturn(array('status'=>0));
			}
		}
	}
	// 上传语音
	function getpost()
    {
    	if(IS_POST)
    	{
    		$media_id =trim($_POST['serverId']);
			$access_token =trim($_POST['access_token']);
			$chatime =intval($_POST['chatime']);			
			$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;  
			$filedata = file_get_contents($url);
			if($filedata)
			{
				$imgurl = "./data/upload/luyin/".$media_id.".amr";
				$this->downAndSaveFile($url,$imgurl);
				$strfileurl=$this->upchange($imgurl,$media_id);		
				$ctime =floor($chatime/1000);// 取整
				
			    $this->ajaxReturn(array('status'=>1,'strfileurl'=>$strfileurl,'chatime'=>$ctime));
			}else{
				$this->ajaxReturn(array('status'=>0));
			}
    	}
    }
	function doanswer()
	{
		if(IS_POST)
		{
			$pdata =I('post.');
			
			if($pdata['content'])
			{
				$adata=array();
				foreach($pdata['content'] as $k=>$value)
				{
					$adata[$k]['text'] =$value;
					$adata[$k]['type'] =$pdata['atype'][$k];
					$adata[$k]['atime']=$pdata['atime'][$k];
				}
				$pdata['content'] =json_encode($adata);
				$pdata['addtime'] =time();
				$pdata['xueke'] =M('teacher')->where("id='".$pdata['teacherid']."'")->getField('xueke');
				$pdata['addtime2']=date('Y-m-d H:i:s');
				$res=M('answer')->add($pdata);
				if($res)
				{
					
					M('question')->where("id='".$pdata['questionid']."'")->save(array('isdo'=>1,'scoretime'=>time()));
					M('teacher')->where("id='".$pdata['teacherid']."'")->setInc('number',1);
					$minfo=D()->field('m.mobile')->table(C('DB_PREFIX').'member m,'.C('DB_PREFIX').'question q')->where("m.id=q.userid and q.id='".$pdata['questionid']."'")->find();
					send_msgtomember($minfo['mobile']);
					$this->ajaxReturn(array('status'=>1,'url'=>U('Portal/Problem/index')));
				}else
				{
					$this->ajaxReturn(array('status'=>2,'msg'=>'解答失败'));
				}
			}else
			{
				$this->ajaxReturn(array('status'=>2,'msg'=>'解答失败'));
			}			
		}
	}
	
	//将本地amr音频文件上传至七牛云并转码生成MP3文件
  	function upchange($filePath,$mediaid){    
        import('Qiniu.functions');
        $setting=C('UPLOAD_SITEIMG_QINIU');
		
	    $accessKey = $setting['driverConfig']['accessKey'];      //七牛公钥    
	    $secretKey = $setting['driverConfig']['secrectKey'];      //七牛私钥    
	    $auth = new Auth($accessKey, $secretKey);    
	           
	    $bucket = trim($setting['driverConfig']['bucket']);    
	    //数据处理队列名称,不设置代表不使用私有队列，使用公有队列。    
	    $pipeline = 'arsenal';    
	            
	    //通过添加'|saveas'参数，指定处理后的文件保存的bucket和key    
	    //不指定默认保存在当前空间，bucket为目标空间，后一个参数为转码之后文件名     
	    $savekey = \Qiniu\base64_urlSafeEncode($bucket.':'.$mediaid.'.mp3');  
		 
	    //设置转码参数    
	    $fops = "avthumb/mp3/ab/320k/ar/44100/acodec/libmp3lame";    
	    $fops = $fops.'|saveas/'.$savekey;    
	    if(!empty($pipeline)){  //使用私有队列    
	        $policy = array(    
	            'persistentOps' => $fops,    
	            'persistentPipeline' => $pipeline    
	        );    
	    }else{                  //使用公有队列    
	        $policy = array(    
	            'persistentOps' => $fops    
	        );    
	    }    
	            
	    //指定上传转码命令    
	    $uptoken = $auth->uploadToken($bucket, null, 3600, $policy);   
		
	    $key = $mediaid.'.amr'; //七牛云中保存的amr文件名    
	    $uploadMgr = new UploadManager();    
	            
	    //上传文件并转码$filePath为本地文件路径    
	    list($ret, $err) = $uploadMgr->putFile($uptoken, $key, $filePath);  
	    if ($err !== null) {    
	        return false;    
	    }else {    
			//此时七牛云中同一段音频文件有amr和MP3两个格式的两个文件同时存在    
			$bucketMgr = new BucketManager($auth);  			
			//为节省空间,删除amr格式文件    
			$results=$bucketMgr->delete($bucket, $key);     
			$url = "http://".$setting['driverConfig']['domain']."/".$mediaid.".mp3";			
			//$bendiurl ='./data/upload/luyin/'.$mediaid.'.mp3';
			//$this->downAndSaveFile($url,$bendiurl);
			@unlink('./data/upload/luyin/'.$mediaid.'.amr');
			return $url;    
		}    
	}  

    //根据URL地址，下载文件
	function downAndSaveFile($url,$savePath){
	    ob_start();
	    readfile($url);
	    $img  = ob_get_contents();
	    ob_end_clean();
	    $size = strlen($img);
	    $fp = fopen($savePath, 'a');
	    fwrite($fp, $img);
	    fclose($fp);
	}
}
?>