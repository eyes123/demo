<?php

class WxController extends BaseController
{
	private $projectModel;
	
    public function __construct() {
        $this->projectModel = M('yes_project', null);
		parent::__construct();
    }
	
	// 首页
    public function index() {
	
		// 获取当前用户OPENID
		$openInfo = $this->WxAuth();
		
		// 检测推荐用户
		$userInfo = $this->checkTiker();	
		
		$this->userExists($openInfo);
		
		// 初始化JSsdk
		$this->initJsSDK( $_SESSION['nowUserinfo'] );
		$this->setTitle();

		extract($userInfo);
		
		$this->assign('nickname', $nickname);
		$this->assign('headimgurl', $headimgurl);
		$this->display();
    }

	private function userExists($openInfo){

		// 获取当前用户微信信息
		$nowUserinfo = $this->getWxUserInfo($openInfo['openid'], $openInfo['access_token']);

		// 查询用户是否存在
		$users = M('yes_app',null)->field('id,phone')->where(array('openid'=>$nowUserinfo['openid'],'nickname'=>array('exp','is not null')))->find();
		$order = M('yes_order',null)->field('id')->where(array('app_id'=>$users['id'], 'order_status'=>1))->find();

		if($users && $order){
			$jump = '/Mobile/wx/pay_success';
		}elseif( $users ){
			$jump = '/Mobile/wx/details';
		}
		if( isset($jump) ){
			$_SESSION['phone']	= $users['phone'];
			redirect($jump);
		}
	}
	
	// 检测推荐用户
	private function checkTiker(){
		$userInfo = array(
			'nickname'	=>	'妙笔菡塘',
			'headimgurl'	=> 'http://wx.miaobihantang.com/Public/images/mbhtlogo.jpg',
		);

		// 获取邀请人信息
		$invi_openid = (isset($_GET['tiker']) && !empty($_GET['tiker'])) ? trim($_GET['tiker']) : 0;
		
		// 获取课程ID
		$project_id = (isset($_GET['project']) && !empty($_GET['project'])) ? trim($_GET['project']) : 0;
		
		// 检测课程ID
		if( isset($_GET['project']) && !empty($_GET['project']) && (int)$_GET['project'] > 0 ){
			$projectInfo = $this->projectModel->field('id,project_name,price')->where(array('id'=>$project_id))->find();
		}
		
		if( !isset($projectInfo) || !$projectInfo || !is_array($projectInfo) ){

			$projectInfo = $this->projectModel->field('id,project_name,price')->where(array('default_id'=>1))->find();
		}

		if( $invi_openid !== 0 || is_numeric($invi_openid) ){
			$localUser = M('yes_app',null)->where(array('id'=>$invi_openid))->find();

			if( $localUser != NULL && $localUser !== false && is_array($localUser) ){
				$userInfo = array(
					'nickname'	=>	$localUser['nickname'],
					'headimgurl'	=> $localUser['headimgurl'],
				);
			}
		}
		$_SESSION['inviUserInfo'] = $userInfo;
		
		// 保存邀请用户ID
		$_SESSION['invi_openid'] = $invi_openid;
		
		// 保存课程信息
		$_SESSION['project'] = $projectInfo;
		
		return $userInfo;
	}
	
	// 设置Title
	private function setTitle(){
		$site_name = $_SESSION['inviUserInfo']['nickname'] . "邀你同乘妙笔号友谊的小船，快登船吧！";
		$this->assign('site_name', $site_name);
	}
	
	// 活动详情页
	public function details(){

		$nowUserinfo = $_SESSION['nowUserinfo'];
		// 保存当前用户信息
		R('Index/saveUserInfo',array($nowUserinfo, $_SESSION['project']['id'] , $_SESSION['invi_openid'], $_SESSION['phone']));
		
		// 初始化JSsdk
		$this->initJsSDK( $nowUserinfo );
		$this->setTitle();
		extract($_SESSION['inviUserInfo']);
		$this->assign('nickname', $nickname);
		$this->assign('headimgurl', $headimgurl);
		$this->display();
	}
	
	// 活动详情页
	public function details2(){
		$nowUserinfo = $_SESSION['nowUserinfo'];
		// 初始化JSsdk
		$this->initJsSDK( $nowUserinfo );
		$this->setTitle();
		
		$this->display();
	}
	
	
	// 发送邀请函
	public function send_share(){

		// 获取当前用户信息
		$nowUserinfo = $_SESSION['nowUserinfo'];
		
		// 初始化JSsdk
		$this->initJsSDK($nowUserinfo);
		$this->setTitle();
		extract($nowUserinfo);
		
		$this->assign('nickname', $nickname);
		$this->assign('headimgurl', $headimgurl);
		$this->display();
	}
	
	
	// 邀请函页面分享成功操作
	public function share_success(){
	
		$jump = '/Mobile/wx/details';	
		// 查询用户是否存在已购买订单
		$orderStatus = $this->getUserOrder();

		if( $orderStatus !== NULL || $orderStatus !== false && is_array($orderStatus)){
			$jump = "/Mobile/wx/details2";
		}
		
		$this->sendRedpacket();
		// 跳转
		redirect($jump);
		exit;
		
	}
	
	
	public  function sendRedpacket(){

		if( !isset($_SESSION['phone']) || empty($_SESSION['phone']) ){
			return false;
		}
		
		$users = M('yes_app', null)->field('id')->where( array('phone'=>$_SESSION['phone']) )->find();

		if(!$users){
			return false;
		}

		$count  = M('yes_coupon', null)->field('id')->where(array('app_id'=>$users['id'], 'coupon_type'=>2))->count();

		if( $count < 1 ){

			// 发送红包
			R('Index/send_redpacket');
		}

	}
	
	// 查询当前用户是否存在订单
	private function getUserOrder(){
		
		// 获取订单号
		$where = array(
			'a.phone'	=> $_SESSION['phone'],
			'o.order_status'	=> 1,
		);

		return M('yes_app as a',null)->join("LEFT JOIN yes_order as o ON a.id=o.app_id")->where($where)->find();
	}
	
	
	// 立即购买
	public function buy(){

		// 获取当前用户信息
		$nowUserinfo = $_SESSION['nowUserinfo'];
        extract($_SESSION);
        extract($nowUserinfo);
		$orderInfo = array(
			'order_price'	=> 100*sprintf("%.2f", $_SESSION['project']['price']),

			'project_name'	=> $_SESSION['project']['project_name'],
			'invi_openid'	=> $_SESSION['invi_openid'] ? $_SESSION['invi_openid'] : 0,
		);

		// 生成订单号
		$order = R('Index/order',array($orderInfo));

		// 保存订单号
		$out_trade_no = $_SESSION['out_trade_no'] = $order['order_code'];
		
		// 初始化JSsdk
		$this->initJsSDK($nowUserinfo);
		$this->setTitle();
		
		// 初始化微信支付
		$wxpay = array(
			'openid'	=>	$nowUserinfo['openid'],
			'out_trade_no'	=>	$out_trade_no,
			'total_fee'		=>	$orderInfo['order_price'],
			'body'			=>	$orderInfo['project_name'],
		);
		
		$jsApiParameters = $this->initWxPay($wxpay);
		extract($order);
//		print_r(extract($order));exit;
		$this->assign('jsApiParameters', $jsApiParameters);
		$this->assign('order_code', $order_code);
		$this->assign('project_name', $project_name);
		$this->assign('nickname', $nickname);
		$this->assign('phone', $phone);
		$this->assign('order_price', $order_price);
		$this->display();
	}
	
	// 支付完成页
	public function pay_success(){
		
		if( isset($_SESSION['out_trade_no']) && !empty($_SESSION['out_trade_no'])){
			$state = $this->requestWxOrder($_SESSION['out_trade_no']);
			if( intval($state)  == 0){
				R('Index/send_project', array($_SESSION['out_trade_no']));
				unset($_SESSION['out_trade_no']);
			}
		}
		// 获取当前用户信息
		$nowUserinfo = $_SESSION['nowUserinfo'];
		
		// 初始化JSsdk
		$this->initJsSDK($nowUserinfo);
		$this->setTitle();
		$lists = $this->getUserOrder();
		extract($lists);
		$this->assign('out_trade_no', $order_code);
		$this->assign('project_name', $project_name);
		$this->assign('price', $order_price);
		$this->assign('pay_time', $pay_time);
		$this->display();
	}
	
	private function initWxPay($param){
		extract($param);
		vendor('Weixinpay.WxPayPubHelper');
		//使用jsapi接口
		$jsApi = new JsApi_pub();
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub();
		
		$unifiedOrder->setParameter("openid","$openid");//用户描述
		$unifiedOrder->setParameter("body","$body");//商品描述
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$unifiedOrder->setParameter("total_fee",$total_fee);//总金额
		$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		$unifiedOrder->setParameter("notify_url", "http://wx.miaobihantang.com/index.php/Mobile/wx/notify_url.html");
		
		$prepay_id = $unifiedOrder->getPrepayId();

		//=========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_id);
		$jsApiParameters = $jsApi->getParameters();
		return $jsApiParameters;
	}
	
	
	//异步通知url，商户根据实际开发过程设定
	public function notify_url() {
		vendor('Weixinpay.WxPayPubHelper');
		
		//使用通用通知接口
		$notify = new Notify_pub();

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
		
		//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		
		//以log文件形式记录回调信息
		$log_name="./notify_url.log";//log文件路径
		file_put_contents($log_name, "【接收到的notify通知】:\n", FILE_APPEND);
		
		$parameter = $notify->xmlToArray($xml);
	  
		if($notify->checkSign() == TRUE)
		{
			if ($notify->data["return_code"] == "FAIL") {
				//此处应该更新一下订单状态，商户自行增删操作
				file_put_contents($log_name, "【通信出错】:\n", FILE_APPEND);
			}
			elseif($notify->data["result_code"] == "FAIL"){
				//此处应该更新一下订单状态，商户自行增删操作
				file_put_contents($log_name, "【业务出错】:\n", FILE_APPEND);
			}
			else{
				//此处应该更新一下订单状态，商户自行增删操作
				file_put_contents($log_name, "【支付成功】:\n".$xml."\n", FILE_APPEND);
				$this->process($parameter);
			}
		}
	}
	
	//订单处理
    private function process($parameter) {
		R('Index/orderCode',array($parameter['out_trade_no']));
        return true;
    }
	
	
	// 向微信发起订单请求信息
	private function requestWxOrder( $out_trade_no ){
		vendor('Weixinpay.WxPayPubHelper');
		
		//使用订单查询接口
		$orderQuery = new OrderQuery_pub();
		
		//商户订单号
		$orderQuery->setParameter("out_trade_no","$out_trade_no"); 
		//获取订单查询结果
		$orderQueryResult = $orderQuery->getResult();
		
		//商户根据实际情况设置相应的处理流程,此处仅作举例
		if ($orderQueryResult["return_code"] == "FAIL" || $orderQueryResult["result_code"] == "FAIL") {
			return false;
		}
		else{
			return $orderQueryResult['trade_state'];
		}
		
	}
}