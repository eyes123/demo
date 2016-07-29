<?php
header("Content-Type: text/html; charset=UTF-8");
class BaseController extends Controller
{
	private $appId;
	private $appSecret;
  
	public function __construct(){
		
		$this->appId = 'wxe9d066f359655a67';
		$this->appSecret = 'b3506fc8abeae67cc8d9ad6da4121247';
		
		import("Org.SessionManage");
        import("Org.Page");

		parent::__construct();
    }

	protected function initJsSDK($userinfo){
		
		vendor('JsSDK.jssdk');
		$share_link = "http://wx.miaobihantang.com/index.php/Mobile/wx/index?t=wx";
		$jssdk = new JSSDK($this->appId, $this->appSecret);
		$signPackage = $jssdk->GetSignPackage();
		$project_id  = $_SESSION['project']['id'];
		
		if( ACTION_NAME == 'index' ){
			$userinfo = $_SESSION['inviUserInfo'];
			$userinfo['openid'] = '9999999';
		}
		
		$user = M('yes_app',null)->field('id')->where(array('openid'=>$userinfo['openid']))->find();
		
		$share_link .=  $user ? "&tiker={$user['id']}" : "";
		$share_link .=  $project_id ? "&project={$project_id}" : '';
		$this->assign('share_title', $userinfo['nickname'] . " 邀你同乘妙笔号友谊的小船，快登船吧！");
		$this->assign('share_image', $userinfo['headimgurl']);
		$this->assign('share_link', "$share_link");
		
		$this->assign('appId', $signPackage['appId']);
		$this->assign('timestamp', $signPackage['timestamp']);
		$this->assign('nonceStr', $signPackage['nonceStr']);
		$this->assign('signature', $signPackage['signature']);
	}
	
	//检测微信授权
	protected function WxAuth(){
		
		// 回调地址
		$redirect_uri = 'http://' .$_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . '?' .$_SERVER["QUERY_STRING"];

		// 授权地址
		$authURL = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe9d066f359655a67&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";
		$openid = '';
		if( isset($_GET['code']) && !empty($_GET['code']) ){
			$code = $_GET['code'];
			// 获取openid
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appId}&secret={$this->appSecret}&code={$code}&grant_type=authorization_code";
			$openInfo = json_decode( file_get_contents($url), true );
			$_SESSION['openInfo'] = $openInfo;
		}
		elseif( isset($_SESSION['openInfo']) && !empty($_SESSION['openInfo']) ){
			
			$openInfo = $_SESSION['openInfo'];
		}
		
		if( !empty($openInfo) ) return $openInfo;
		
		// 发起授权请求
		redirect($authURL);
		exit;
	}

	// 获取当前用户信息
	public function getWxUserInfo($openid, $access_token){
		// 判断用户信息是否存在
		if( isset($_SESSION['nowUserinfo']) && !empty($_SESSION['nowUserinfo']) ){
			$userInfo = $_SESSION['nowUserinfo'];
		}
		else{

			//获取用户信息
			$inofURL = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}";
			
			$userInfo = file_get_contents($inofURL);
			
			$userInfo = json_decode($userInfo, true);
			
			// 缓存信息
			$_SESSION['nowUserinfo'] = $userInfo;
		}

		return $userInfo;
	}

	// 获取全局token
	public function getAccessToken(){
		$where['id'] = $this->appId;	
		$Token = new Model('access_token','mbht_','mysql://mmbht:mmbht2016m@localhost/mmbhtdb'); 
		$res = $Token->where($where)->find();

		if( time() - $res['addtime'] < 7200 ){
			$access_token = $res['addtime'];
		}
		else{
			// 获取全局TOKEN
			$globalTokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appId}&secret={$this->appSecret}";
			$tokenBox = json_decode( file_get_contents($globalTokenUrl), true );
			$access_token = $tokenBox['access_token'];
			// 更新token
			$Token->where($where)->save( array('access_token'=>$access_token, 'add_time'=>time) );
		}
		return $access_token;
	}
	// 验证用户
}
?>