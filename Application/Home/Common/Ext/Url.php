<?php
/*
 +---------------------------------------------------------------+
| 名称: BLL/Ext/Url.cs
| 版权：烟台一天科技计算机有限公司
| 作者：David<kdage@163.com>
| 日期：2014-03-11
| 描述：Url管理的操作
+---------------------------------------------------------------+
*/
class Ext_Url
{
	/**
	 * 获取当前页面
	 */
	public static function getThisUrl()
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		return $url;
	}
	
	/**
	 * 获取当前页面,不带?及后面参数
	 */
	public static function getLocalUrlAlone()
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		return $url;
	}
	
	/**
	 * 获取url参数
	 */
	public static function getParams()
	{
		$parmas = self::convertUrlQuery($_SERVER['QUERY_STRING']);
		return $parmas;
	}
	
	/**
	 * 添加或者修改url参数
	 */
	public static function editParams($keyStr,$valueStr)
	{
		$parmas = self::convertUrlQuery($_SERVER['QUERY_STRING']);
		$parmas[$keyStr]=$valueStr;
		$request = self::getUrlQuery($parmas);
		return $request;
	}
	
	/** 
	 * Returns the url query as associative array 
	 * 
	 * @param    string    query 
	 * @return    array    params 
	 */ 
	public static function convertUrlQuery($query)
	{ 
	    $queryParts = explode('&', $query); 
	    
	    $params = array(); 
	    foreach ($queryParts as $param) 
		{ 
	        $item = explode('=', $param);
	        if(!empty($item))
	        {
	        	if(isset($item[1]))
	        	{
	        		$params[$item[0]] = $item[1];
	        	}
	        }
	    }
	    return $params; 
	}
	
	public static function getUrlQuery($array_query)
	{
		$tmp = array();
		foreach($array_query as $k=>$param)
		{
			$tmp[] = $k.'='.$param;
		}
		$params = implode('&',$tmp);
		return $params;
	}
}