<?php

class Outbound
{
	// 一心科技	宁波跨境平台资料
	const userid2 = 'ytytkjcs';//测试账号
	const userid = 'yt9cmall';//正式账号
	const OrderFrom = "0000"; // 购物网站代码
	const CustomsCode = "3310444301"; // 电商企业海关代码
	const OrgName = "烟台一心信息技术有限公司"; // 电商企业名称
	
	const OrderShop 	= "10368";	//店铺代码   
	const miyue2 		= '63b8e2aa-71f3-4f94-ade7-7c134bcf64c4';
	const miyue 		= 'ed80931c-9cb5-468b-a227-a86541be2922';
	const api 			= "http://i.kjb2c.com/msg/";
	const testapi 		= "http://i.trainer.kjb2c.com/msg/";
	const regapi 		= 'regapi.do';// HTTP-消费者备案
	const ordermsg		= 'ordermsg.do';// HTTP-进口订单
	const paymsg 		= 'paymsg.do';// HTTP-进口支付单
	const logisticsmsg	= 'logisticsmsg.do';// HTTP-进口运单
	const ordercancel	= 'ordercancel.do';// HTTP-进口订单关闭
	const rejectedmsg	= 'rejectedmsg.do';// HTTP-退换货申请
	const logisticsfirm	= 'logisticsfirm.do';// HTTP-物流快递企业查询
	const getrejected 	= 'getrejected.do'; //退换货状态

		
	/**
	 * 进口订单
	 * $order $order=array('OrderNo','','','','','','');
	 */
	public static function ordermsg($order)
	{
// 		$orderFrom = self::OrderFrom;//购物网站代码
// 		$orderShop = self::OrderShop;//购物商铺代码
// 		$cusromsCode = self::CustomsCode;
// 		$orgName = self::OrgName;
		$now = date("Y-m-d H:i:s");
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
       	<Message>
			<Header>
       			<CustomsCode>'.self::CustomsCode.'</CustomsCode>
				<OrgName>'.self::OrgName.'</OrgName>
				<CreateTime>'.$now.'</CreateTime>
       		</Header>
			<Body>
				<Order>
					<OrderFrom>'.self::OrderFrom.'</OrderFrom>
					<OrderShop>'.self::OrderShop.'</OrderShop>
					<OrderNo>'.$order['OrderNo'].'</OrderNo>
					<GoodsAmount>'.$order['GoodsAmount'].'</GoodsAmount>
					<PostFee>'.$order['PostFee'].'</PostFee>
					<Amount>'.$order['Amount'].'</Amount>
					<BuyerAccount>'.$order['BuyerAccount'].'</BuyerAccount>';
	// 		       	if($order['TaxAmount']>0)
	// 		       	{
			       		$xml .= '<TaxAmount>'.$order['TaxAmount'].'</TaxAmount>';
	// 		       	}
	// 		       	if($order['DisAmount']>0)
	// 		       	{
			       		$xml .= '<DisAmount>'.$order['DisAmount'].'</DisAmount>';
	// 		       	}
			       	if(!empty($order['Promotions']))
			       	{
			       		$xml .= '
			       	<Promotions>';
			       		foreach ($order['Promotions'] as $pros)
			       		{
			       				$xml .= '<Promotion>
			       					<ProAmount>'.$pros["ProAmount"].'</ProAmount>
			       					<ProRemark>'.$pros["ProRemark"].'</ProRemark>
			       				</Promotion>';
			       		}
			       		$xml .= '
			       	</Promotions>';
			       	}
			       	$xml .= '
			       	<Goods>';
		       		foreach ($order['Goods'] as $goods)
		       		{
		       			$xml .= '<Detail>
		       					<ProductId>'.$goods["ProAmount"].'</ProductId>
		       					<GoodsName>'.$goods["ProRemark"].'</GoodsName>
		       					<Qty>'.$goods["Qty"].'</Qty>
		       					<Unit>'.$goods["Unit"].'</Unit>
		       					<Price>'.$goods["Price"].'</Price>
		       					<Amount>'.$goods["Amount"].'</Amount>
		       			</Detail>';
		       		}		       		 
		       		$xml .= '
					</Goods>
		       	</Order>
			</Body>
		</Message>';
// 	    echo $xml;
// 	    exit;
		$result = self::commonapi(self::ordermsg,$xml,$now);
		return $result;
	}
	/**
	 * 进口支付单
	 * 调用API-进口订单成功发送订单后，再调用该接口发送进口支付单
	 * @param $pay
	 * 	<PaymentNo>		VARCHAR2(30)	是	支付单号（交易流水号）
		<OrderNo>		VARCHAR2(20)	是	订单号
		<OrderSeqNo>	VARCHAR2(30)	是	商家订单交易号（必须和送银联的交易号一致）
		<Amount>		NUMBER (19,3)	是	金额
		<CurrCode>		VARCHAR2(20)	是	币种（目前仅限RMB）
		<BuyerAccount>	VARCHAR2(200)	是	买家账号
		<Source>		VARCHAR2(50)	是	支付方式代码
	 * @return Ambigous <NULL, unknown>
	 */
	public static function paymsg($pay)
	{
		$now = date("Y-m-d H:i:s");
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
		<Message>	
			<Header>
       			<CustomsCode>'.self::CustomsCode.'</CustomsCode>
				<OrgName>'.self::OrgName.'</OrgName>
				<CreateTime>'.$pay['CreateTime'].'</CreateTime>
       		</Header>
			<Body>
				<Pay>
					<PaymentNo>'.$pay["PaymentNo"].'</PaymentNo>
					<OrderNo>'.$pay["OrderNo"].'</OrderNo>
					<OrderSeqNo>'.$pay["OrderSeqNo"].'</OrderSeqNo>
					<Amount>'.$pay["Amount"].'</Amount>
					<CurrCode>'.$pay["CurrCode"].'</CurrCode>
					<BuyerAccount>'.$pay["BuyerAccount"].'</BuyerAccount>
					<Source>'.$pay["Source"].'</Source>
				</Pay>
			</Body>
		</Message>';
		$result = self::commonapi(self::paymsg,$xml,$now);
// 		$return = self::xmlToArray($result);
		//print_r($return);exit;
		return $result;
	}
	
	/**
	 * 进口运单
	 * @param unknown $logistics
	 * <Message>																						
		<Header>																					
			<CustomsCode>		VARCHAR2(10)	是		电商企业海关代码				
			<OrgName>			VARCHAR2(200)	是		电商企业名称				
			<CreateTime>		Date			是		交易时调银联接口的时间，如没有可以填当前时间				
		</Header>																					
		<Body>																					
			<Logistics>																				
				<LogisticsNo>	VARCHAR2(14)	否		运单号（可为空）				
				<OrderNo>		VARCHAR2(20)	是		订单号				
				<LogisticsName>	VARCHAR2(60)	是		物流企业名称（必需与物流快递查询接口查出的名称一致）	(顺丰速运,邮政速递,中通速递,邮政小包)			
				<Consignee>		VARCHAR2(20)	是		收货人名称				
				<Province>		VARCHAR2(100)	是		省				
				<City>			VARCHAR2(100)	是		市				
				<District>		VARCHAR2(100)	是		区				
				<ConsigneeAddr>	VARCHAR2(300)	是		收货地址（包含省、市、区）				
				<ConsigneeTel>	VARCHAR2(20)	是		收货电话				
				<GoodsName>		VARCHAR2(1000)	否		货物名称				
			</Logistics>																				
		</Body>																					
	</Message>																						
	 */
	public static function logisticsmsg($data)
	{
		$now = date("Y-m-d H:i:s");
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
       	<Message>
			<Header>
       			<CustomsCode>'.self::CustomsCode.'</CustomsCode>
				<OrgName>'.self::OrgName.'</OrgName>
				<CreateTime>'.$now.'</CreateTime>
       		</Header>
			<Body>
				<Logistics>
					<LogisticsNo></LogisticsNo>
					<OrderNo>'.$data["OrderNo"].'</OrderNo>
					<LogisticsName>'.$data["LogisticsName"].'</LogisticsName>
					<Consignee>'.$data["Consignee"].'</Consignee>
					<Province>'.$data["Province"].'</Province>
					<City>'.$data["City"].'</City>
					<District>'.$data["District"].'</District>
					<ConsigneeAddr>'.$data["ConsigneeAddr"].'</ConsigneeAddr>
					<ConsigneeTel>'.$data["ConsigneeTel"].'</ConsigneeTel>
					<GoodsName>'.$data["GoodsName"].'</GoodsName>
				</Logistics>
			</Body>
		</Message>';
		$return = self::commonapi(self::logisticsmsg,$xml,$now);
// 		print_r($return);exit;
		return $return;
	}
	
	/**
	 * 进口订单关闭
	 * 	<Order>																			
			<OrderNo> VARCHAR2(20) 是 订单号			
		</Order																		
	 */
	public static function ordercancel($orderNo)
	{
		$now = date("Y-m-d H:i:s");
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
       	<Message>
			<Header>
       			<CustomsCode>'.self::CustomsCode.'</CustomsCode>
				<OrgName>'.self::OrgName.'</OrgName>
				<CreateTime>'.$now.'</CreateTime>
       		</Header>
			<Body>
				<Order>
					<OrderNo>'.$orderNo.'</OrderNo>
				</Order>
			</Body>
		</Message>';
		$return = self::commonapi(self::ordercancel,$xml,$now);
		return $return;
	}
	
	/**
	 * 退换货申请
	 * 	<RejectedInfo>																	
			<OrderNo>				VARCHAR2(20)	是		订单号	
			<WaybillNo>				VARCHAR2(50)	是		运单号	
			<Flag>					VARCHAR2(2)		是		退换货标志：00-退货 10-换货	
			<RejectedGoods>			
				<Detail>			商品明细节点可循环	
					<ProductId>		VARCHAR2(20)	是		货号（跨境平台商品备案时产生的唯一编码）	
					<RejectedQty>	NUMBER (19,5)	是		退货数量	
				</Detail>															
			</RejectedGoods>																
		</RejectedInfo>																	
	 */
	public static function rejectedmsg($data)
	{
		$now = date("Y-m-d H:i:s");
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
       	<Message>
			<Header>
       			<CustomsCode>'.self::CustomsCode.'</CustomsCode>
       			
				<CreateTime>'.$now.'</CreateTime>
       		</Header>
			<Body>
				<RejectedInfo>																	
					<OrderNo>'.$data["OrderNo"].'</OrderNo>
					<WaybillNo>'.$data["WaybillNo"].'</WaybillNo>	
					<Flag>'.$data["Flag"].'</Flag>
					<RejectedGoods>';
		       		foreach ($data['Goods'] as $goods)
		       		{
			       			$xml .= '
		       			<Detail>
		       				<ProductId>'.$goods["ProductId"].'</ProductId>	
							<RejectedQty>'.$goods["RejectedQty"].'</RejectedQty>	
		       			</Detail>';
		       		}		       		 
		       		$xml .= '														
					</RejectedGoods>																
				</RejectedInfo>
			</Body>
		</Message>';
//        	echo $xml;
       	//exit;
		$result = self::commonapi(self::rejectedmsg,$xml,$now);
		// 		print_r($return);exit;
		return $result;
	}
	
	
	/**
	 * 查询退换货状态
	 * @param unknown $order
	 * @return Ambigous <NULL, unknown>
	 */
	public static function getrejected($order)
	{
		$now = date("Y-m-d H:i:s");
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
       	<Message>
			<Header>
				<OrderNo>'.$order["OrderNo"].'</OrderNo>		
				<WaybillNo>'.$order["WaybillNo"].'</WaybillNo>	
				<Flag>'.$order["Flag"].'</Flag>
       		</Header>
		</Message>';
		//        	echo $xml;
		//exit;
		$result = self::commonapi(self::getrejected,$xml,$now);
		// 		print_r($return);exit;
		return $result;
	}
	/**
	 * 物流快递企业查询
	 * @param unknown $logistics
	 * @return 
	 */
	public static function logisticsfirm($logistics)
	{
		$now = date("Y-m-d H:i:s");
		$xml = '';
		$return = self::commonapi(self::logisticsfirm,$xml,$now);
// 		print_r($return);exit;
		/**
		 * [Body] => Array
		        (
		            [Lgs] => Array
		                (
		                    [0] => Array
		                        (
		                            [LgsCode] => 66849640-5
		                            [LgsName] => 顺丰速运
		                        )
		
		                    [1] => Array
		                        (
		                            [LgsCode] => 55796739-0
		                            [LgsName] => 邮政速递
		                        )
		
		                    [2] => Array
		                        (
		                            [LgsCode] => 73698071-8
		                            [LgsName] => 中通速递
		                        )
		
		                    [3] => Array
		                        (
		                            [LgsCode] => 41956181-9
		                            [LgsName] => 邮政小包
		                        )
		                )
		        )
		 */
		return $return;
	}
	
	/**
	 * 	userid			账号																			
		timestamp		urlencode(当前时间(格式：yyyy-MM-dd HH:mm:ss), utf-8)																			
					后的字符串，当前时间前后20分中内都有效																			
		sign			(用户名+密码(此密码为服务申请时产生的密钥，非平台登录密码)																			
					+当前时间(格式：yyyy-MM-dd HH:mm:ss))字符串																			
					拼接后MD5编码																			
		xmlstr			各单证xml文件组装后的内容，需UTF-8编码，																			
					即xml头部以<?xml version="1.0" encoding="UTF-8" ?>申明																			
					详见各sheet定义的格式说明																			
	 */
	public static function commonapi($api,$xml,$now='')
	{
		$url = self::testapi.$api;
		if(empty($now))
		{
			$now = date('Y-m-d H:i:s');
		}
		$str	= self::userid.self::miyue.$now;

		$post	= array(
				'userid'	=> self::userid,
				'timestamp' => $now,	
				'sign'		=> md5($str),
				'xmlstr'	=> $xml,
				);
// 		echo $url."<br/>";
		//print_r($post);
		$result	= self::file_get_contents_post($url,$post);
// 		print_r($result);
		$array	= self::xmlToArray($result);
// 		print_r($array);exit;
		return $array;
	}
	
	/**
	 * @param 
		账号（身份证号大写）
		真实姓名
		购物网站账号
		手机号
		邮箱
	 */
	public static function regapi($idnum,$name,$login_name,$phone,$email)
	{
		$orderFrom = self::OrderFrom;//购物网站代码
		$xml = <<<EOD
        <?xml version="1.0" encoding="UTF-8" ?>
       	<Message>
		<Body>
			<OrderFrom>$orderFrom</OrderFrom>
			<Idnum>$idnum</Idnum>
			<Name>$name</Name>
			<Account>$login_name</Account>
			<Phone>$phone</Phone>
			<Email>$email</Email>
		</Body>
		</Message>
EOD;
			
		$result = self::commonapi(self::regapi,$xml);
		return $result;
	}
	
	public static function xmlToArray($xmlString)
	{
		$data = simplexml_load_string($xmlString);
		$result = self::objectToArray($data);
		return $result;
	}
	
	public static function objectToArray($obj)
	{
		$arr = null;
		$_arr = is_object($obj)? get_object_vars($obj) :$obj;
		foreach ($_arr as $key => $val)
		{
			$val=(is_array($val)) || is_object($val) ? self::objectToArray($val):$val;
			$arr[$key] = $val;
		}
		return $arr;
	}
	
	/**
	 * php模拟post方法
	 * @param unknown $url
	 * @param unknown $post
	 * @return string
	 */
	public static function file_get_contents_post($url, $post) {
		$options = array(
			'http' => array(
				'method' => 'POST',
				'content' => http_build_query($post),
				'header' => "Content-type: application/x-www-form-urlencoded",
			),
		);
		$result = file_get_contents($url, false, stream_context_create($options));
		return $result;
	}
	
}