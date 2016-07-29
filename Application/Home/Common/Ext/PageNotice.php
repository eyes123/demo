<?php
/*
 +---------------------------------------------------------------+
| 名称: BLL/Ext/PageNotice.php
| 版权：烟台一天科技计算机有限公司
| 作者：David<kdage@163.com>
| 日期：2014-05-14
| 描述：消息提示
+---------------------------------------------------------------+
*/
define('DefaultTime',"2000");

class Ext_PageNotice
{
	/// <summary>
	/// 页面提示后跳转
	/// </summary>
	/// <param name="message"></param>
	/// <param name="url">跳转url,为空时表示不跳转</param>
	/// <param name="time"></param>
	public static function showMessage($message, $url='', $time= DefaultTime)
	{
		if($url=='1')
		{
			$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		$js = "<script type=\"text/javascript\">showMessage(\"".$message."\",\"".$url."\",".$time.");</script>";
		echo $js;
	}
	
	/// <summary>
	/// 页面提示后跳转
	/// </summary>
	/// <param name="result">结果：0：成功；-1：失败</param>
	/// <param name="url1">成功跳转url,为空时表示不跳转</param>
	/// <param name="url2">失败跳转url,为空时表示不跳转</param>
	/// <param name="id">要修改的id，为空表示添加</param>
	public static function showMessageByResultAndId($result, $url1, $url2, $id, $message='')
	{
		$message = ((null == $id || "" == $id) ? "添加" : "修改").$message;
		self::showMessageByState($result, $url1, $url2, $message);
	}
	
	/// <summary>
	/// 页面提示后跳转
	/// </summary>
	/// <param name="result">结果：0：成功；-1：失败</param>
	/// <param name="url1">成功跳转url,为空时表示不跳转;1:当前页面</param>
	/// <param name="url2">失败跳转url,为空时表示不跳转</param>
	/// <param name="message"></param>
	public static function showMessageByState($result, $url1, $url2, $message)
	{
		$url = "";
		$time = DefaultTime;
		if ($result == 0)
		{
			$message = $message."成功";
			$time = 1500;
			$url = $url1;
		}
		else
		{
			$message = $message."失败";
			$url = $url2;
		}
		if($url1=='1')
		{
			$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		self::showMessage($message, $url, $time);
	}
}
?>