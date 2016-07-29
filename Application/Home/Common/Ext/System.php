<?php
/*
 +---------------------------------------------------------------+
| 名称: BLL/Ext/System.php
| 版权：烟台一天科技计算机有限公司
| 作者：David<kdage@163.com>
| 日期：2014-03-11
| 描述：日志管理的操作
+---------------------------------------------------------------+
*/
class Ext_System
{
    /**
	 * 功能:生成guid字符串
	 */
	public static function create_guid()
	{
		$charid = strtoupper(md5(uniqid(mt_rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid =
		substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12);
		//.chr(125);// "}"//chr(123)// "{".
		return $uuid;
	}
	/**
	 * 功能:获取ip
	 */
	public static function getIp()
	{
		if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else if(!empty($_SERVER["REMOTE_ADDR"]))
		{
			$cip = $_SERVER["REMOTE_ADDR"];
		}
		else
		{
			$cip = '';
		}
		return $cip;
	}
}
?>