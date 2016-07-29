<?php

class Settle
{
	// 一心资料
	const CUST_ID = "SDP310444301#001"; // 客户识别号
	const USER_ID = "WLPT01"; // 操作员号
	const PASSWORD = "yixin123"; // 操作员密码
	const LANGUAGE = "CN"; // 语言   中文
	const COMPANY_ACCNO = "37001666660050171556"; // 公司账号
	const ACC_BRANCH_CODE = "370000000"; // 转入一级行号
	const YIXIN_OPENACC_DEPT = "中国建设银行烟台开发支行"; // 开户机构名称
	const YIXIN_UBANKNO = "105456001309"; // 开户机构行号
	const BILL_CODE = "7201"; // 代发代扣编号(7201跨行)
	const BILL_CODE2 = "3761";// 代发代扣编号(3761行内)
	const USEOF_CODE = "00000009"; // 用途编号(00000001工资，00000006报销，00000007差旅，00000009奖金)
	const FLOW_FLAG = ""; // 网银审批标识 (空或0.不需审批  1.网银审批)
	
	// 外网
	const IP = "222.173.221.226";
	const PORT = 8580;
	

	
	/**
	 * @param unknown $ACC_NO2	对方账户
	 * @param unknown $OTHER_NAME	对方姓名
	 * @param unknown $AMOUNT	金额
	 * @param unknown $UBANK_NO	收款账户支付系统行号
	 * @param unknown $REM1	备注1
	 * @param unknown $REM2	备注2
	 * @return 结算结果
	 */
	
	public static function settleByUser($ACC_NO2,$OTHER_NAME,$AMOUNT,$UBANK_NO,$REM1='app推广奖金结算',$REM2='php结算')
	{
		$returnData = '';
		//echo 'settleByUser开始:';
		//echo $ACC_NO2.$OTHER_NAME.$AMOUNT;
		if(!empty($ACC_NO2) && !empty($OTHER_NAME) && !empty($AMOUNT))
		{
			$REM1 = iconv("UTF-8", "gb2312" , $REM1);
			$REM2 = iconv("UTF-8", "gb2312" , $REM2);
			$OTHER_NAME = iconv("UTF-8", "gb2312" , $OTHER_NAME);
			
			$AMOUNT = round($AMOUNT,2);			
			$COMPANY_ACCNO = self::COMPANY_ACCNO; // 本方企业账户
			$USEOF_CODE = self::USEOF_CODE; // 用途编号
			$FLOW_FLAG = self::FLOW_FLAG; // 网银审批标识
			$BILL_CODE = empty($UBANK_NO)?self::BILL_CODE2:self::BILL_CODE; // 代发代扣编号
			$TX_INFO  = "<ACC_NO1>".$COMPANY_ACCNO."</ACC_NO1> ";
			$TX_INFO .= "<BILL_CODE>".$BILL_CODE."</BILL_CODE>";
			$TX_INFO .= "<ACC_NO2>".$ACC_NO2."</ACC_NO2>";
			$TX_INFO .= "<OTHER_NAME>".$OTHER_NAME."</OTHER_NAME>";
			$TX_INFO .= "<AMOUNT>".$AMOUNT."</AMOUNT>";
			$TX_INFO .= "<USEOF_CODE>".$USEOF_CODE."</USEOF_CODE>";
			$TX_INFO .= "<FLOW_FLAG>".$FLOW_FLAG."</FLOW_FLAG>";
			$TX_INFO .= "<UBANK_NO>".$UBANK_NO."</UBANK_NO>";
			$TX_INFO .= "<REM1>".$REM1."</REM1>";
			$TX_INFO .= "<REM2>".$REM2."</REM2>";
// 			echo 'TX_INFO：'.$TX_INFO."<br/>";exit;
			$sendData = self::getXML("6W1303",$TX_INFO);
			//echo '$sendData:'.$sendData;
			$returnData = self::get_data_from_server(self::IP,self::PORT,$sendData);
		}
		return $returnData;
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
	
	private function getXML($TX_CODE, $TX_INFO, $OTHER='')
	{
		$REQUEST_SN = time().substr(microtime(), 2,6);
		$sb = "<?xml version=\"1.0\" encoding=\"GB2312\" standalone=\"yes\" ?>";
		$sb.="<TX>";
		$sb.="<REQUEST_SN>" . $REQUEST_SN . "</REQUEST_SN>";
		$sb.="<CUST_ID>" . self::CUST_ID . "</CUST_ID>";
		$sb.="<USER_ID>" . self::USER_ID . "</USER_ID>";
		$sb.="<PASSWORD>" . self::PASSWORD . "</PASSWORD>";
		$sb.="<TX_CODE>" . $TX_CODE . "</TX_CODE>";
		$sb.="<LANGUAGE>" . self::LANGUAGE . "</LANGUAGE>";
		$sb.="<TX_INFO>";
		$sb.=$TX_INFO;
		$sb.="</TX_INFO>";
		if (!empty($OTHER)) {
			$sb.=OTHER;
		}
		$sb.="</TX>";
		return $sb;
	}
	public static function get_data_from_server($address, $service_port, $send_data)
	{
		//echo '$send_data:'.$send_data."<br/>";exit;
		$message 	= '';
		$outData 	= '';
		$error 		= 0;
		$socket 	= socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket < 0)
		{
			$message = "socket创建失败原因: " . socket_strerror($socket) . "\n";
		}
		else
		{
			$result = socket_connect($socket, $address, $service_port);
			if ($result < 0) {
				$message = "SOCKET连接失败原因: ($result) " . socket_strerror($result) . "\n";
			} else {
				//发送命令
				$in = $send_data;
				$out = '';
				//echo "Send ..........";
				socket_write($socket, $in, strlen($in));
				//echo "OK.\n";
				//echo "Reading Backinformatin:\n\n";
				while ($out = socket_read($socket, 2048)) {
							//echo $out;
					$outData .= $out;
				}
			}
		}
		//echo "outData:".$outData ."<br/>";
		//echo "Close socket........";
		socket_close($socket);
		//echo "OK,He He.\n\n";
		return $outData;
	}
}