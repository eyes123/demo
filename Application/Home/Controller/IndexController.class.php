<?php
class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        import('Think.Verity');
    }
    /**
     *
     * 验证码生成
     */
    public function verify_c(){

    $Verify = new Think_Verify();
    $Verify->fontSize = 18;
    $Verify->length   = 4;
    $Verify->useNoise = false;
    $Verify->codeSet = '0123456789';
    $Verify->imageW = 130;
    $Verify->imageH = 50;

    $Verify->entry();
}
    //登录页面及登录验证
    public function login()
    {
        if (!empty($_REQUEST)) {
            $userName = trim($_REQUEST['username']);
            $pwd = trim($_REQUEST['password']);
            if (!empty($userName) && !empty($pwd))
            {
                // 检查验证码
                $verify = I('param.verify','');
                if(!check_verify($verify)){
                    $this->error("亲,验证码输入错误！",$this->site_url,3);
                }
                else
                {
                    $userDb = D("User");
                    $user = $userDb->login($userName, $pwd);
                    if ($user == 0) {
                        $this->error('登录失败，用户名或密码有误！');
                    }
                    else
                    {
                        //获取权限id
                        $userPowDb = D('UserPow');
                        $user['action_id'] = $userPowDb->getUserPowIdByUserId($user['id']);
                        SessionManage::setSession(C('SystemRole'), $user);//(C('SystemRole'),$user);
                        $functionDb = D('Function');
                        $name = 'menuList'.$user['action_id'];
                        $menuList = $functionDb->getMenuListByActionId($user['action_id']);

                        S($name,$menuList,3600);
                        header('Location:' . __APP__ . '/Home/Index/index');
                    }
                }
            }
        }
        $this->display();
    }

    //退出
    public function logout()
    {
        session(null);
        echo '<script>parent.location.reload();</script>';
        exit;
    }

    //首页
    public function index()
    {
        SessionManage::checkLogin();
        $this->display();
    }

    //头部
    public function top()
    {
        $user = session(C('SystemRole'));
        $this->userName = $user['name'];
        $this->dateTime = date('Y-m-d H:i:s');
        $this->ip = $this->getIP();
        $userTypes = C('user_type');
        $userType = $user['user_type'];
        $this->userType = $userTypes[$userType];
        $this->display();
    }

    // 获取客户端ip地址 
    private function getIP()
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (!empty($_SERVER["REMOTE_ADDR"])) {
            $cip = $_SERVER["REMOTE_ADDR"];
        } else {
            $cip = '';
        }
        return $cip;
    }

    //左边菜单
    public function left()
    {
        $userPowDb = D('UserPow');
        $menuList = array();
        //获取缓存数据
        $actionId = SessionManage::getUserActionId();
        if(!empty($actionId))
        {
            $name = 'menuList'.$actionId;
            $menuList = S($name);
            if(empty($menuList))
            {
                $functionDb = D('Function');
                $menuList = $functionDb->getMenuListByActionId($actionId);
                S($name,$menuList,3600);
                //'这个是直接从数据库中读取的文件';
            }
        }
        $this->menuList = $menuList;
        $this->display();
    }

    //中间部分
    public function center()
    {
        $this->display();
    }

    //主要部分(右边菜单)
    public function main()
    {
        $this->name = SessionManage::getUserName();
        $this->display();
    }

    //底部
    public function down()
    {
        $this->display();
    }

    /**
     * 返回所有符合条件的结果，以数组返回
     */
    protected function fetchAll($sqlStr = null)
    {
        if ($sqlStr != null)
        {
            $this->QueryString = $sqlStr;
        }
        $this->query();
        $array = array();
        while ($temp_array = $this->fetchArray($this->Resource)) {
            $array[] = $temp_array;
        }
        return $array;
    }

    //文件上传
    public function upload()
    {
        $this->display();
    }


}