<?php

vendor('Weixin/Log_');
import("Org.jssdk");
class WeixinController extends BaseController
{


    private $appid = 'wxe9d066f359655a67';
    private $secret = 'b3506fc8abeae67cc8d9ad6da4121247';
    private function CurlGet($url, $method = 'get', $data = '')
    {
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        return $temp;
    }
    private function makeCodeUrl($redirect_url, $state = '', $scope = 'snsapi_base', $response_type = 'code')
    {
        $url = sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=%s&scope=%s&state=%s#wechat_redirect',
            $this->appid, urlencode($redirect_url), $response_type, $scope, urlencode($state)
        );
        return $url;

    }
    private function getAccessToken($code, $grant_type = 'authorization_code')
    {
        $params = sprintf('?appid=%s&secret=%s&code=%s&grant_type=%s',
            $this->appid, $this->secret, $code, $grant_type);
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token' . $params;
        $data = $this->CurlGet($url, 'get');
        $data = json_decode($data, true);
        if ($data["errcode"]) {
            trace($data["errmsg"], '', 'ERR');
            exit();
        } else {
            return $data;
        }
    }
    //远程读取openid
    private function getUserInfo($access_token, $openid, $lang = 'zh_CN', $isarray = true)
    {
        $params = sprintf('?access_token=%s&openid=%s&lang=%s',
            $access_token, $openid, $lang);
        $url = 'https://api.weixin.qq.com/sns/userinfo' . $params;
        $data = $this->CurlGet($url, 'get');
        $data = json_decode($data, $isarray);
        if ($data["errcode"]) {
            trace($data["errmsg"], '', 'ERR');
            exit();
        } else {
            return $data;
        }

    }

    //保存微信用户信息
    public function saveUserInfo($data, $p_id,$phone)
    {
        $appDb = D('App');
        $list = $appDb->where(array('openid' => $data['openid']))->find();
        if (!$list)
        {
            //保存当前用户信息
            $arr =array();

            //当前用户手机号
            $arr['phone'] = $phone;
            //推荐人
            $arr['invi_people'] = $p_id;
            $arr['openid'] =  $data['openid'];
            $arr['nickname'] =  $data['nickname'];
            $arr['headimgurl'] =  $data['headimgurl'];

            $arr['create_time'] = date("Y-m-d h:i:s");
            $id = $appDb->addApp($arr);
            SessionManage::setSession("app_id",$id);
            return $arr;
        }
        else{
            SessionManage::setSession("app_id",$list['id']);
        }
        return $list;
    }


    //点击约字之后，进行授权
    public function shouquan()
    {
        $p_id = 0;
        $phone = '15010309879';
        //回调地址
        $code_url = "http://" . $_SERVER['HTTP_HOST'] . __ROOT__ . "/Mobile/Weixin/wx_project&p_id='".$p_id."'&phone=".$phone;
        redirect($this->makeCodeUrl($code_url, $_GET['p_id']));
    }

    //首页
    public function index()
    {

        $this->display();
    }

    //课程详情页
    public function wx_project()
    {
        //当前用户手机号
        $phone = $_REQUEST['phone'];
        $p_id = $_REQUEST['p_id'];

        session(null);
        if (!session('userInfo'))
        {

            $data = $this->getAccessToken($_GET['code']);
            if ($data['access_token'])
            {
                $data = $this->getUserInfo($data['access_token'], $data['openid']);

                //save中已经做了检查用户是否存在，
                $data = $this->saveUserInfo($data, $p_id,$phone);
                session("userInfo", $data);

            }
            else
            {
                trace('获了access_token 失败', '', "INFO");
                die();
            }
        }

        $this->display();
    }

	/**
	 * 微信支付api
	 */
	public function index1()
	{
		vendor("Weixin/WxPayPubHelper");
		$jsApi = new \JsApi_pub();
		$openid = '';
		$message = '';
		if(!isset($_GET["code"]))
		{
			$redirectUrl =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$url = $jsApi->createOauthUrlForCode($redirectUrl);
			Header("Location: ".$url);
			exit;
		}
		else
		{
			//获取code码，以获取openid
			$code = $_GET['code'];
			$jsApi->setCode($code);
			$openid = $jsApi->getOpenId();
		}

		$orderDealDb = new OrderDealModel();
		$order = $orderDealDb->checkDealId();
		$url =  "http://".$_SERVER['HTTP_HOST'].__ROOT__."/Mobile/index/result_new";

		$webRoot = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/index.php/Mobile/Weixin';
		$notifyUrl = $webRoot."/notifyUrl";
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub();

		//设置统一支付接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//spbill_create_ip
		$unifiedOrder->setParameter("spbill_create_ip",getIP());//["spbill_create_ip"]
		//sign已填,商户无需重复填写

		if(strlen($order["title"])>32)
		{
			$order["title"] = mb_substr($order["title"],0,29,'utf-8')."...";
		}
		$unifiedOrder->setParameter("body",$order["title"]);//商品描述
		$unifiedOrder->setParameter("detail",$order["body"]);//商品详情
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		//$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
		$unifiedOrder->setParameter("out_trade_no", $order["id"]);//商户订单号

		$order["total_fee"] = 100*sprintf("%.2f", $order["total_fee"]);

		$unifiedOrder->setParameter("total_fee",$order["total_fee"]);//总金额
		$unifiedOrder->setParameter("notify_url",$notifyUrl);//通知地址
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		//非必填参数，商户可根据实际情况选填
		//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
		//$unifiedOrder->setParameter("device_info","XXXX");//设备号
		//$unifiedOrder->setParameter("attach","XXXX");//附加数据
		//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
		//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
		//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
		$unifiedOrder->setParameter("openid",$openid);//用户标识
// 		用户标识 openid 否 String(128) rade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识。 下单前需要调用【网页授权获取用户信息】接口获取到用户的Openid
		//$unifiedOrder->setParameter("product_id","XXXX");//商品ID
		//建立请求
		$prepayId = $unifiedOrder->getPrepayId();
		if(!empty($prepayId))
		{
			//=========步骤3：使用jsapi调起支付============
			$jsApi->setPrepayId($prepayId);
			$jsApiParameters = $jsApi->getParameters();
			$this->jsApiParameters = $jsApiParameters;
		}
		$url .= "?deal_id=".$order["id"];
		//$this->html_text = '';
		$this->url  = $url;
		//支付失败后跳转的页面
		$this->url2 = "http://".$_SERVER['HTTP_HOST'].__ROOT__."/Mobile/index/buy?order_id=".$order["id"];
		$this->message = $message;
		$this->display();
	}

    /**
     **	服务器异步通知页面路径
     */
    public function notifyUrl()
    {
        if(!empty($GLOBALS['HTTP_RAW_POST_DATA']))
        {
            vendor("Weixinpay/log_");
            vendor("Weixinpay/WxPayPubHelper");

            //使用通用通知接口
            $notify = new Notify_pub();

            //存储微信的回调
            $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
            $notify->saveData($xml);
            $verifyResult = $notify->checkSign();
            //验证签名，并回应微信。
            //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
            //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
            //尽可能提高通知的成功率，但微信不保证通知最终能成功。
            if($verifyResult == FALSE)
            {
                $notify->setReturnParameter("return_code","FAIL");//返回状态码
                $notify->setReturnParameter("return_msg","签名失败");//返回信息
            }
            else
            {
                $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
            }
            $returnXml = $notify->returnXml();
            echo $returnXml;
            //==商户根据实际情况设置相应的处理流程，此处仅作举例=======
            //以log文件形式记录回调信息
//            $log_ = new Log_();
            $wenjianjia1 = $_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Application/Runtime/WeixinPayLogs';
            //$log_name = "./notify_url.log";//log文件路径
            log_::log_result("【接收到的notify通知】:\n".$xml."\n",$wenjianjia1);

            $n = strtoupper(substr(PHP_OS,0,3))==='WIN'?"\r\n":"\n";

            Log_::log_result($n." 【接收到的notify通知】:".$n.$xml.$n,$wenjianjia1);

            if($verifyResult == TRUE)
            {
                if ($notify->data["return_code"] == "FAIL")
                {
                    //此处应该更新一下订单状态，商户自行增删操作
                    Log_::log_result($n." 【通信出错】。",$wenjianjia1);
                }
                else if($notify->data["result_code"] == "FAIL"){
                    //此处应该更新一下订单状态，商户自行增删操作
                    Log_::log_result($n." 【业务出错】。",$wenjianjia1);
                }
                else
                {
                    if(!empty($notify->data["total_fee"]))
                    {
                        $notify->data["total_fee"] = $notify->data["total_fee"];
                        //此处应该更新一下订单状态，商户自行增删操作
                        Log_::log_result("【支付成功】:\n".$xml."\n",$wenjianjia1);
                        $ordertDb = D('Order');

                        $result = $ordertDb->deal($notify->data);
                        if($result)
                        {
                            //此处应该更新一下订单状态，商户自行增删操作
                            Log_::log_result($n." 【支付成功】。",$wenjianjia1);
                            echo success;
                        }
                    }

                }
                //商户自行增加处理流程,
                //例如：更新订单状态
                //例如：数据库操作
                //例如：推送支付完成信息
            }
        }
    }

}

?>