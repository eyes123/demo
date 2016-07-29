<?php
/*
 +---------------------------------------------------------------+
| 名称: BLL/Ext/Validater.php
| 版权：烟台一天科技计算机有限公司
| 作者：David<kdage@163.com>
| 日期：2014-05-14
| 描述：字符串验证
+---------------------------------------------------------------+
*/
class Ext_Validater {
	
	/**
	 * 定长数字字母组合
	 * @param str $str
	 * @param min_length $num1
	 * @param max_length $num2
	 * @return boolean
	 */
	public static function isFixedStr($str,$num1 = 1,$num2 = PHP_INT_MAX)
	{
		return (preg_match("/.{".$num1.",".$num2."}/",$str))?true:false;
	}
	
	/**
	 * 定长数字
	 * @param str $str
	 * @param min_length $num1
	 * @param max_length $num2
	 * @return boolean
	 */
	public static function isFixedNum($str,$num1 = 1,$num2 = 1024)
	{
		return (preg_match("/^[0-9]{".$num1.",".$num2."}$/i",$str))?true:false;
	}
	
	/**
	 * 验证日期
	 * @param 要验证的字符串
	 */
	public static function isDayOrDayTime($str)
	{
		$result =false;
		
		if(!strstr($str,' '))
		{
			$str.=" 00:00:00";
		}
		
		$stime = strtotime($str);
		if($stime>0)
		{
			if($str == date('Y-m-d H:i:s',$stime))
			{
				$result =true;
			}
		}
		return $result;
	}
	
	/**
	 * 验证金额
	 * @param unknown $str
	 * @return boolean
	 */
	public static function isMoney($str,$num = "2")
	{
		return (preg_match("/^([0-9]+|[0-9]{1,3}(,[0-9]{3})*)(.[0-9]{1,$num})?$/",$str))?true:false;
	}
	
	/**
	 * 身份证
	 * @param unknown $str
	 * @return boolean
	 */
	public static function isIDCode($str)
	{
		return (preg_match('/(^([\d]{15}|[\d]{18}|[\d]{17}x)$)/',$str))?true:false;
	}
	
	/**
	 * 邮箱
	 * @param unknown $str
	 * @return boolean
	 */
	public static function isEMail($str){
		return (preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/',$str))?true:false;
	}
	/**
	 * 手机号
	 * @param unknown $str
	 * @return boolean
	 */
	public static function isPhone($str)
	{
		return (preg_match('/^1[358]{1}[0-9]{9}$/',$str))?true:false;
	}
	/**
	 * 电话号码
	 * @param unknown $str
	 * @return boolean
	 */
	public static function isTelNumber($str)
	{
		return (preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/",$str))?true:false;
	}
	/**
	 * 邮编
	 * @param unknown $str
	 * @return boolean
	 */
	public static function isZip($str)
	{
		return (preg_match("/^\d{6}$/",$str))?true:false;
	}
	/**
	 * Url地址
	 * @param unknown $str
	 * @return boolean
	 */
	public static function isUrl($str)
	{
		return (preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/",$str))?true:false;
	}
	/**
	 * 计算字符串长度
	 * @param 字符串
	 * @return 长度
	 */
	public static function strlenUtf8($str)
	{
		$i = 0;
		$count = 0;
		$len = strlen ($str);
		while ($i < $len) 
		{
			$chr = ord ($str[$i]);
			$count++;
			$i++;
			if($i >= $len)
			{
				break;
			}
			if($chr & 0x80) 
			{
				$chr <<= 1;
				while ($chr & 0x80) 
				{
					$i++;
					$chr <<= 1;
				}
			}
		}
		return $count;
	}
	/**
	 * 去除空白
	 * @param unknown $str
	 * @return string
	 */
	public static function trimall($str)//删除空格  
	{  
	    $qian=array(" ","　","\t","\n","\r");
	    $hou=array("","","","","");  
	    return str_replace($qian,$hou,$str);      
	} 
}
?>
