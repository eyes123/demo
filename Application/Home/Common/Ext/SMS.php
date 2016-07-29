<?php
/******************************************************************
*
##  Project:SKPHP,A concise and easy framework for PHP
##  Copyright: 2012 All rights reserved
##  version: 0.0.1
##  Author: Sun Kid <hujw@bronco1.com>
*
##  File: SMS.php (SKFrame_Ext_SMS)
******************************************************************/
class SKFrame_Ext_SMS {
	
	public $UserName ;	//用户账号
	public $PassWord ;	//用户密码
	public $Http ;		//发送地址
	/**
	 * 
	 * @param username $uid
	 * @param password $pwd
	 * @param webservice  $http
	 */
	function __construct($uid='',$pwd='',$http = 'http://61.156.38.47:8080/CPDXT/SendSms'){
		$this->Http = $http;
		$this->PassWord = $pwd;
		$this->UserName = $uid;
	}

	/**
	 * 发送信息
	 * @param unknown $mobile
	 * @param unknown $content
	 * @return string
	 */
	public function sendSMS($mobile,$content,$needRport = 0,$split = FALSE)
	{
		$data = array(
			'commandID' => 3,//发送命令
			'username' => $this->UserName,//用户账号
			'password' => $this->PassWord,//密码
			'mobile' => $mobile,//被叫号码
			'content' => $content,//内容
			'needReport' => $needRport,
			'encoding'=>'utf-8',
			'split' =>$split
		);
		$result = $this->postSMS($data);
		switch (substr($result,0,9)){
			case 'return=0;':
				if(empty($needRport))
					$result = '成功';
				else {
					$result = explode(';', $result);
					$result = explode('=', $result[1]);
					$result = $result[1];
				}
				break;
			case 'return=1;':
				$result = '无此用户';
				break;
			case 'return=2;':
				$result = '密码错误';
				break;
			case 'return=3;':
				$result = '余额不足';
				break;
			case 'return=4;':
				$result = '请求参数错误';
				break;
			case 'return=5;':
				$result = '发送限制。晚上8点半 到第二天早上6点不能发送';
				break;
			case 'return=6;':
				$result = 'IP错误';
				break;
			case 'return=7;':
				$result = '内容超过长度限制';
				break;
			case 'return=8;':
				$result = '发送号码格式错误';
				break;
		}
		return $result; 
	}

	/**
	 * 判断手机号码的类型
	 * @param unknown $number
	 * @return string LT:联通|DX:电信|YD:移动|WZ:未知
	 */
	public function GetMobileType($number) {
		$number = preg_replace('/^(0|\+860)/','',$number);
		$LT = array("130","131","132","155","156","185","186");
		$DX = array("133","153","180","189");
		$YD = array("134","135","136","137","138","139","147","150","151","152","157","158","159","182","187","188");
		if(preg_match('/^('.implode('|', $LT).')/', $number))
			return 'LT'	;
		elseif(preg_match('/^('.implode('|', $DX).')/', $number))
			return 'DX'	;
		elseif(preg_match('/^('.implode('|', $YD).')/', $number))
			return 'YD'	;
		else
			return  'WZ';
	}

	/**
	 * 查询账户
	 * @param unknown $mobile
	 * @param unknown $content
	 * @return string
	 */
	public function seeSMS()
	{
		$data = array(
				'commandID' => 2,//发送命令
				'username' => $this->UserName,//用户账号
				'password' => $this->PassWord//密码
		);
		$result = $this->postSMS($data);
		switch ($result){
			case 'return=1;':
				$result = '无此用户';
				break;
			case 'return=2;':
				$result = '密码错误';
				break;
			case 'return=3;':
				$result = '余额不足';
				break;
			case 'return=4;':
				$result = '请求参数错误';
				break;
			default:
				$result = split(';', $result);
				break;
		}
		return $result;
	}

	/** 
	 * @param unknown $data
	 * @return string
	 */
	private function postSMS($data){
		$row = parse_url($this->Http);
		$host = $row['host'];
		$port = $row['port'] ? $row['port']:8080;
		$file = $row['path'];
		$post = '';
		while (list($k,$v) = each($data))
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.1\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}	
}
?>
