<?php
class JpushTest
{
	private static  $url="https://api.jpush.cn/v3/push";
	//若实例化的时候传入相应的值则按新的相应值进行
	public function __construct($url=null)
	 {  
	 	//global $app_key=C('app_key');
		if ($url)
		{
			$this->url = $url;
		}
	}
	
	public static function file_get_contents_post($url, $header,$post)
	 {
		$options = array(
				'http' => array(
						'method' => 'POST',
						'header' =>$header,
						//'content' => http_build_query($post),
					 'content' => $post,
				),
		);
		$result = file_get_contents($url, false, stream_context_create($options));
		//var_dump($result);exit;
		return $result;
	}
	//推送的Curl方法
	public static  function push_curl($param="",$header="")
	 {
		if (empty($param)) { return false; }
		$postUrl = self::$url;
		$curlPost = $param;
		$ch = curl_init();                                      //初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);           // 增加 HTTP Header（头）里的字段
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($ch);                                 //运行curl
		curl_close($ch);
		return $data;
	}
	/**
	 * 
	 * @param string $receiver接收者信息
	 * @param string $content推送内容
	 * @param string $m_type推送附加类型
	 * @param string $m_txt推送附加内容
	 * @param string $m_time 保存离线时间默认一天
	 * @param string $platform接收设备
	 * @return string|boolean
	 */
	public function send($receiver='all',$platform='android',$content='',$m_type='',$m_txt='',$m_time='86400')
	{
		//$base64=base64_encode(self::$app_key.':'.self::$master_secret);
		$base64=base64_encode(C('app_key').':'.C('master_secret'));
// 		echo C('app_key')."<br/>";
// 		echo C('master_secret')."<br/>";
		$header=array("Authorization:Basic $base64","Content-Type:application/json");
		$data = array();
		$data['platform'] = $platform;          //目标用户终端手机的平台类型android,ios,winphone
		$data['audience'] = $receiver ;
		$data['notification'] = array(
				//统一的模式--标准模式
				"alert"=>$content,
				//安卓自定义
				"android"=>array(
						"alert"=>$content,
						"title"=>"",
						"builder_id"=>1,
						//"extras"=>array("type"=>$m_type, "txt"=>$m_txt)
						"extras"=>array("url"=>$m_txt)
				),
				//ios的自定义
				"ios"=>array(
						"alert"=>$content,
						"sound"=>"default",
						"badge"=>"1",
						"content-available"=>true,
						//"extras"=>array("type"=>$m_type, "txt"=>$m_txt)
				),
		);
		$data['message'] = array(
				"msg_content"=>$content,
				//"extras"=>array("type"=>$m_type, "txt"=>$m_txt)
		);
		//附加选项
		$data['options'] = array(
				"sendno"=>time(),
				"time_to_live"=>$m_time, //保存离线时间的秒数默认为一天
				"apns_production"=>0,        //指定 APNS 通知发送环境：0开发环境，1生产环境。
		);
       $param = json_encode($data);
     // $result =self::file_get_contents_post(self::$url, $header, $param);
      $result =self::push_curl($param,$header);
       if($result)
		{       //得到返回值--成功已否后面判断
     	  	return $result;
       }else
		{          //未得到返回值--返回失败
      	 	return false;
       }
      
	}
	
}



?>