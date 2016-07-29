<?php
/**
* 	配置账号信息
*/
class WxPayConf_pub {
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wxe9d066f359655a67';
	//受理商ID，身份标识
	const MCHID = '1324102501';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = '2016mbht0425MiaoBiHanTang0002016';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = 'b3506fc8abeae67cc8d9ad6da4121247';
	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = 'http://wx.miaobihantang.com/index.php?s=/Mobile/wx/buy';
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = '/www/web/wx_miaobihantang_com/public_html/ThinkPHP/Library/Vendor/Weixinpay/cacert/apiclient_cert.pem';
	
	const SSLKEY_PATH =  '/www/web/wx_miaobihantang_com/public_html/ThinkPHP/Library/Vendor/Weixinpay/cacert/apiclient_key.pem';
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = 'http://wx.miaobihantang.com/index.php/Mobile/wx/notify_url.html';
	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
}	
?>