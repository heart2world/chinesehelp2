<?php

// 微信支付接口
namespace Home\Controller;
use Think\Controller;
header("Content-Type: text/html; charset=utf-8");
class WxJsAPIController extends Controller{

    public function _initialize()
    {
        //引入WxPayPubHelper
        vendor('WxPayPubHelper.WxPayPubHelper');
    }  
    public function jsApiCall()
    {
        
        $ordernum = I('orderNum','','trim');

        $orders = M('orders')->where("ordersn='$ordernum'")->find();
        
        $total_price = $orders['orderprice']*100;
        
        //使用jsapi接口
        $jsApi = new \JsApi_pub();     

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code']))        {
            //触发微信返回code码            
            $url = $jsApi->createOauthUrlForCode("http://".$_SERVER['HTTP_HOST']."/WxJsAPI/jsApiCall?orderNum=".$ordernum);
            Header("Location: $url");
           
        }else
        {
            //获取code码，以获取openid
            $code = $_GET['code'];  
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId(); 
        }
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();
        
        $unifiedOrder->setParameter("openid","$openid");//商品描述
        $unifiedOrder->setParameter("body","问学帮");//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $unifiedOrder->setParameter("out_trade_no", "$ordernum");//商户订单号
        $unifiedOrder->setParameter("total_fee", $total_price);//总金额
        $unifiedOrder->setParameter("notify_url","http://".$_SERVER['HTTP_HOST']."/WxJsAPI/notify");
        //通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		
        $prepay_id = $unifiedOrder->getPrepayId();
       
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);        
        $jsApiParameters = $jsApi->getParameters();
		
        switch ($orders['type']) {
				case '购买微课':
					$backurl = 'http://'.$_SERVER['HTTP_HOST'].'/Task/lesson_info/isscore/9/id/'.$orders['tid'];
					$backurl2 = 'http://'.$_SERVER['HTTP_HOST'].'/Task/lesson_info/id/'.$orders['tid'];
					break;
				case '购买资源':
					$backurl = 'http://'.$_SERVER['HTTP_HOST'].'/Resource/lesson_info/isscore/9/id/'.$orders['tid'];
					$backurl2 = 'http://'.$_SERVER['HTTP_HOST'].'/Resource/lesson_info/id/'.$orders['tid'];
					break;
				case '为TA充电':
					$backurl = 'http://'.$_SERVER['HTTP_HOST'].'/Problem/detail/id/'.$orders['tid'];
					$backurl2 = 'http://'.$_SERVER['HTTP_HOST'].'/Problem/detail/id/'.$orders['tid'];
					break;
				default:
					# code...
					break;
			}  

        $html = '<script type="text/javascript">';
            //调用微信JS api 支付
        $html .= 'function jsApiCall(){
                    WeixinJSBridge.invoke(
                        "getBrandWCPayRequest",
                        '.$jsApiParameters.',
                        function(res){   
                                if(res.err_msg=="get_brand_wcpay_request:ok"){ 
                                    window.location.href = "'.$backurl.'";
                                }else if (res.err_msg == "get_brand_wcpay_request:cancel") {  
                                    window.location.href = "'.$backurl2.'";
                                } 
                        }
                    );
                }';
        $html .= "function callpay()
                {
                    if (typeof WeixinJSBridge == 'undefined'){
                       
                        if( document.addEventListener ){                            
                            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                        }else if (document.attachEvent){                            
                            document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
                            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                        }
                    }else{  
                          
                        jsApiCall();
                    }
                }";
        $html .= "window.onload = function(){callpay();}";
        $html .= "</script>";        
        echo $html;
    }
  
    public function notify()
    {
        //使用通用通知接口     
        $notify = new \Notify_pub();       
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;      
      
        $log_name= __ROOT__."/Public/notify_url.log";//log文件路径
        
        $this->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");
       
        if($notify->checkSign() == TRUE)
        {
            
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                $this->log_result($log_name,"【通信出错】:\n".$xml."\n");
            }
            elseif($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                $this->log_result($log_name,"【业务出错】:\n".$xml."\n");
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作
                 $out_trade_no=$notify->data["out_trade_no"];
                 file_put_contents('a899.txt',$out_trade_no);
                 if(!$this->check_orderstatus($out_trade_no)){
                    $model=M('orders');
					$orders = $model->where("ordersn ='$out_trade_no'")->find();
					if($orders['orderstatus'] == 1){
						return true;
					}
                    $transaction_id = $notify->data['transaction_id'];
					//更新支付状态
					$model->where( array('ordersn'=>$out_trade_no,'orderstatus'=>0) )->save(array('orderstatus'=>1,'paytime'=>time(),'transaction_id'=>$transaction_id));
					
					// 按比例提成					
					M('teacher')->where("id='".$orders['teacherid']."'")->setInc("coin",$orders['tccoin']);
					$data['coin'] =$orders['tccoin'];
					$data['orderid']=$orders['id'];
					$data['teacherid'] =$orders['teacherid'];
					$data['userid'] =$orders['userid'];
					$data['type'] =$orders['type'];
					M('commissionlog')->add($data);
					// 学生是否有上级教师
					$techinfo=D()->field('m.*')->table(C('DB_PREFIX').'orders o,'.C('DB_PREFIX').'member m')->where("m.id=o.userid and o.id='".$orders['id']."'")->find();
					if($techinfo['agentid'])
					{
						M('teacher')->where("id='".$techinfo['agentid']."'")->setInc('coin',$orders['commission2']);
						$data['coin'] =$orders['commission2'];
						$data['orderid']=$orders['id'];
						$data['teacherid'] =$techinfo['agentid'];
						$data['userid'] =$orders['userid'];
						$data['type'] ='消费分红';
						M('commissionlog')->add($data);
						// 上级教师是否有代理
						$agentinfo =M('teacher')->where("id='".$techinfo['agentid']."'")->find();
						if($agentinfo['parentid'])
						{
							M('teacher')->where("id='".$agentinfo['parentid']."'")->setInc('coin',$orders['commission']);
							$data['coin'] =$orders['commission'];
							$data['orderid']=$orders['id'];
							$data['teacherid'] =$agentinfo['parentid'];
							$data['userid'] =$orders['userid'];
							$data['type'] ='代理分红';
							M('commissionlog')->add($data);
						}
					}
				}            
                
            }
        }
    }
        // 打印log
    function  log_result($file,$word) 
    {
        $fp = fopen($file,"a");
        flock($fp, LOCK_EX) ;
        fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }
	function check_orderstatus($order_id){
        $model = M('Orders');
        $order_status = $model->where('ordersn="'.$order_id.'"')->getField('orderstatus');

        if($order_status == 1){
            return true;
        }else{
            return false;
        }
    }
    
    

   /**
     * 发送请求
     * @param $url
     * @param $data
     * @return mixed
     */
     function http_data_send($url,$data=[]){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if(!empty($data)){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output=curl_exec($ch);

        curl_close($ch);
        return $output;
    }
     function _request($curl,$https=true,$method='GET',$data=null){
        $header = array('Expect:');
        $ch=  curl_init();
        curl_setopt($ch,CURLOPT_URL,$curl);
        curl_setopt($ch,CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        if($https){
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,TRUE);
        }
        if($method=='POST'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        }
        $content=  curl_exec($ch);
        //返回结果
          if($content){
              curl_close($ch);
              return $content;
          }
          else {
             $errno = curl_errno( $ch );
             $info  = curl_getinfo( $ch );
             $info['errno'] = $errno;
                curl_close( $ch );
             $log = json_encode( $info );
             
              return false;
          }
    }
}