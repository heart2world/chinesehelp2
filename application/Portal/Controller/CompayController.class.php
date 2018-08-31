<?php
/**
 * 微信企业付款接口
 * @author jorsh20160108
 */
namespace Home\Controller;
use Think\Controller;
class CompanyController extends Controller {
 
    protected $payurl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    protected $appid = 'wx34dd37f9256128a8'; //appid
    protected $mchid = '1499636962';
    protected $signkey ='ywbsd8DGFi8e4osdfg0234moldfgwsed';//支付密钥
    
    //这里的路径很重要  一定要写相对路径
    protected $cacab =  array(
        'api_cert'=>'./data/cacert/apiclient_cert.pem',	
        'api_key'=>'./data/cacert/apiclient_key.pem',
        'api_ca'=>'./data/cacert/rootca.pem',
    );


    //企业付款测试
    public function test(){
        $data = array(
            'userid' => '10',       //用户ID   做更新状态使用
            'openid' => 'ozOUuxM-Y53xHT1JwVq_KUfF2-JY',     //收钱的人微信 OPENID
            'refundid' => 1,        //退款申请ID
            'money'    => 1.5,      //金额
            'desc'     => '提现测试',
        );
 
        $res = $this->wxbuild($data, '');
        var_dump($res);
    }
    
    //$data 要传递的参数， $wxchat微信企业支付等信息 
    /** $data 格式如下
     *  $data = array(
            'userid' //申请退款者ID
            'openid' //退款者openid
            'refundid' //退款申请ID
            'money' //退款金额
            'desc'  //退款描述
        );
     *
     */
    public function wxbuild($data, $wxchat){
        //判断有没有CA证书及支付信息
        if(empty($wxchat['api_cert']) || empty($wxchat['api_key']) || empty($wxchat['api_ca']) || empty($wxchat['appid']) || empty($wxchat['mchid'])){
            $wxchat['appid'] = $this->appid;
            $wxchat['mchid'] = $this->mchid;
            $wxchat['api_cert'] = $this->cacab['api_cert'];
            $wxchat['api_key'] = $this->cacab['api_key'];
            $wxchat['api_ca'] = $this->cacab['api_ca'];
        }
        $webdata = array(
            'mch_appid' => $wxchat['appid'],
            'mchid'     => $wxchat['mchid'],
            'nonce_str' => md5(time()),
            //'device_info' => '1000',
            'partner_trade_no'  => date('ymdHis').rand(100,999), //商户订单号，需要唯一
            'openid'    => $data['openid'],
            'check_name'=> 'NO_CHECK', //OPTION_CHECK不强制校验真实姓名, FORCE_CHECK：强制 NO_CHECK：
            //'re_user_name' => 'jorsh', //收款人用户姓名
            'amount'    => $data['money'] * 100, //付款金额单位为分
            'desc'      => empty($data['desc'])? '退款' : $data['desc'],
            'spbill_create_ip' => $this->getip(),
        );
        foreach ($webdata as $k => $v) {
            $tarr[] =$k.'='.$v;
        }
        sort($tarr);
        $sign = implode($tarr, '&');
        $sign .= '&key='.$this->signkey;
        $webdata['sign']=strtoupper(md5($sign));
        $wget = $this->array2xml($webdata);
		
        $res = $this->curl_post_ssl($this->payurl,$wget);
        if(!$res){
            return array('status'=>1, 'msg'=>"Can't connect the server" );
        }
        $content = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
        if(strval($content->return_code) == 'FAIL'){
            return array('status'=>1, 'msg'=>strval($content->return_msg));
        }
        if(strval($content->result_code) == 'FAIL'){
            return array('status'=>1, 'msg'=>strval($content->err_code),':'.strval($content->err_code_des));
        }
        $rdata = array(
            'mch_appid'        => strval($content->mch_appid),
            'mchid'            => strval($content->mchid),
            'device_info'      => strval($content->device_info),
            'nonce_str'        => strval($content->nonce_str),
            'result_code'      => strval($content->result_code),
            'partner_trade_no' => strval($content->partner_trade_no),
            'payment_no'       => strval($content->payment_no),
            'payment_time'     => strval($content->payment_time),
        );
        return $rdata;
    }
 
    public function getip() {
        static $ip = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
 
        /**
     * 将一个数组转换为 XML 结构的字符串
     * @param array $arr 要转换的数组
     * @param int $level 节点层级, 1 为 Root.
     * @return string XML 结构的字符串
     */
    public function array2xml($arr, $level = 1) {
        $s = $level == 1 ? "<xml>" : '';
        foreach($arr as $tagname => $value) {
            if (is_numeric($tagname)) {
                $tagname = $value['TagName'];
                unset($value['TagName']);
            }
            if(!is_array($value)) {
                $s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
            } else {
                $s .= "<{$tagname}>" . $this->array2xml($value, $level + 1)."</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $level == 1 ? $s."</xml>" : $s;
    }
	/**
	 * 企业付款发起请求
	 * 此函数来自:https://pay.weixin.qq.com/wiki/doc/api/download/cert.zip
	 */
	public function curl_post_ssl($url, $xmldata, $second=30,$aHeader=array()){
		$ch = curl_init();
		//超时时间
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		
		//以下两种方式需选择一种
		
		//第一种方法，cert 与 key 分别属于两个.pem文件
		//默认格式为PEM，可以注释
		curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLCERT,$this->cacab['api_cert']);
		//默认格式为PEM，可以注释
		curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLKEY,$this->cacab['api_key']);
		
		//第二种方式，两个文件合成一个.pem文件
		//curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
	 
		if( count($aHeader) >= 1 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
	 
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$xmldata);
		$data = curl_exec($ch);
		if($data){
			curl_close($ch);
			return $data;
		}
		else { 
			$error = curl_errno($ch);
			echo "call faild, errorCode:$error\n"; 
			curl_close($ch);
			return false;
		}
	}
 
}

?>