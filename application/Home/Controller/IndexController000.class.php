<?php
namespace Home\Controller;
use Think\Controller;
use \Qiniu\Auth;
use \Qiniu\Storage\UploadManager;
use \Qiniu\Storage\BucketManager;
class IndexController extends Controller {
    public function index(){
    	// 测试心联宇互联网
        $jssdk = new \Think\JSSDK("wx72b76eb517a03d9e", "7ba7e78c8702fcf19991c166c7910134");
        $signPackage = $jssdk->GetSignPackage();

        $this->assign('signPackage',$signPackage);
		
        $this->display();
    }
    public function demo()
    {
    	$this->display();
    }
    function getpost()
    {
    	if(IS_POST)
    	{
    		$media_id =trim($_POST['serverId']);
			$access_token =trim($_POST['access_token']);
			
			$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;  
			$filedata = file_get_contents($url);
			if($filedata)
			{
				$imgurl = "./data/upload/luyin/".$media_id.".amr";
				$this->downAndSaveFile($url,$imgurl);
				$imgurls=$this->upchange($imgurl,$media_id);
			    $strfileurl ='http://'.$_SERVER['HTTP_HOST'].'/'.$imgurls;
			     $this->ajaxReturn(array('status'=>1,'fileurl'=>$imgurls,'strfileurl'=>$strfileurl));
			}else{
				$this->ajaxReturn(array('status'=>0));
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
			$bendiurl ='./data/upload/luyin/'.$mediaid.'.mp3';
			$this->downAndSaveFile($url,$bendiurl);
			@unlink('./data/upload/luyin/'.$mediaid.'.amr');
			return $bendiurl;    
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