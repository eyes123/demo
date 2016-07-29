<?php
/**
 * 提示消息,并跳转
 * @param unknown $message
 * @param unknown $url
 * @param number $time
 */
function myMessage($message,$url,$time=2)
{
	$public = __ROOT__.'/Public';
	echo "<meta http-equiv='refresh' content='$time;url=$url'/>";
	$str = <<<EOD
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="$public/Css/mobile/index.css"/>

		<script type="text/javascript" src="$public/Js/Jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function()
			{
				if($("#message_div").attr("id")==null)
				{
					$("body").append('<div id="message_div"><div class="notice_title">提示</div><div class="notice_body"></div></div>');
				}
				$(".notice_body").text('$message');
	            $("#message_div").css("display","block");
			});
		</script>
EOD;
	echo $str;
}

/**
 * 提示消息,并跳转
 * @param unknown $message
 * @param unknown $url
 * @param number $time
 */
function myMessage2($message,$url1,$url2,$result)
{
    if($result)
    {
        $message.='成功！';
        $time = 1000;
        $url = $url1;
    }
    else
    {
        $message.='失败！';
        $time = 2500;
        $url = $url2;
    }
    $public = __ROOT__.'/Public';
    //echo "<meta http-equiv='refresh' content='$time;url=$url'/>";
    $str = <<<EOD
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="$public/Js/diashow/skins/css/diashow.css"/>
		<script src="$public/Js/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="$public/Js/diashow/diashow.js" type="text/javascript"></script>
		<script type="text/javascript" src="$public/Js/Jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function()
			{
				showMessage('$message','$url',$time);
			});
		</script>
EOD;
    echo $str;exit;
}



function json($data, $type='eval',$error) {
	$type = strtolower($type);
	$allow = array('eval','alert','updater','dialog','mix', 'refresh');
	if (false==in_array($type, $allow))
		return false;
	Output::Json(array( 'data' => $data, 'type' => $type,),$error);
}

function myjson($error, $message,$data=array()) {
	if($data==array())
	{
		die( json_encode(array( 'error' => $error, 'message' => $message,)) );
	}
	else 
	{
		die( json_encode(array( 'error' => $error, 'message' => $message, 'data' => $data,)) );
	}
}

function objectToArray($obj)
{
	$arr = is_object($obj)? get_object_vars($obj) :$obj;
	foreach ($arr as $key => $val)
	{
		$val=(is_array($val)) || is_object($val) ? objectToArray($val):$val;
		$arr[$key] = $val;
	}
	return $arr;
}

/**
02. * 验证码检查
03. */
function check_verify($code, $id = ""){
    import('Think.Verity');
    $Verify = new Think_Verify();
    return $Verify->check($code, $id);
}
/**
 * 获取客户端ip地址
 */
function getIP()
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
/**
 * 获取保存图片的路径
 */
function getPublicImgPath()
{
    $public = $_SERVER["DOCUMENT_ROOT"].__ROOT__.'/Public/Upload/Img/';
    return $public;
}

function file_get_contents_post($url, $post=array()) {
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

/**
 * 设置页面id
 * @param $data 数据
 */
function setPageId($control)
{
	if(!isset($_POST['page_id']))
	{
		$pageId = Model::create_guid();
	}
	else 
	{
		$pageId = $_POST['page_id'];
	}
	$control->page_id = $pageId;
	return $pageId;
}


?>