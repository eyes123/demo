<?php

//微信端，第二部分，预约部分
class BespokeController extends BaseController
{
    private $appId;
    private $appSecret;
    public function __construct()
    {
        parent::__construct();
        $this->appId = 'wxe9d066f359655a67';
        $this->appSecret = 'b3506fc8abeae67cc8d9ad6da4121247';
    }
    /*==============================================================================================*/

    private function curPageURL()
    {
        $pageURL = 'http';

        if ($_SERVER["HTTPS"] == "on")
        {
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }
        else
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    //授权获取openid
    private function getOpenid()
    {
        // 回调地址 授权成功之后跳转的地址
        $redirect_uri = urlencode($this->curPageURL());

        // 授权地址  获取code
        $authURL = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe9d066f359655a67&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&connect_redirect=1#wechat_redirect";

        $openid = '';
        if( isset($_GET['code']) && !empty($_GET['code']) ){
            $code = $_GET['code'];

            // 通过code换取网页授权access_token,openid
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appId}&secret={$this->appSecret}&code={$code}&grant_type=authorization_code";
            $openInfo = json_decode( file_get_contents($url), true );

            $_SESSION['openInfo'] = $openInfo;
        }
        elseif( isset($_SESSION['openInfo']['openid']) && !empty($_SESSION['openInfo']['openid']) ){

            $openInfo = $_SESSION['openInfo'];
        }

        if( !empty($openInfo) ) return $openInfo;

        // 发起授权请求
        redirect($authURL);
        exit;
    }

    //根据openid,获取用户id
    private function getAppId()
    {
        // 根据当前用户OPENID
        $openApp = $this->getOpenid();
        $openId = $openApp['openid'];
//        $openId = 'odavgszCTGZzSwI1zqZKxf2MFWkA';
        $appDb = D('App');
        $where = "openid='" . $openId . "'";
        $app = $appDb->getAppNameOpenid($where);

        return $app;
    }

    //待预约页面
    public function etc_appointment()
    {
        // 获取当前用户OPENID
        $openApp = $this->getOpenid();
        $openId = $openApp['openid'];
//        $openId = 'odavgszCTGZzSwI1zqZKxf2MFWkA';
        //当前用户,已经购买,券码表没有消费,订单id不存在预约表
        $where = "yes_app.openid='".$openId."' and yes_order.order_status=1 and yes_coupon.coupon_type=1 and yes_coupon.state=0 and yes_order.id not in (select order_id from yes_bespoke)";
        $appDb = D('App');
        $rows = $appDb->getAppProName($where);

        $this->rows = $rows;
        $this->display();

    }

    //准备预约页面
    public function index()
    {
        $six = strtotime('Y-m-d') . ' 18:00:00';

        $sub = strtotime($six) - strtotime("now");

        //如果在18:00之前，那么就可以预约明天开始，如果在18:00之后，预约从后天开始
        if ($sub <= 0) {
            //计算时间
            $time = date('Y-m-d', strtotime("+2 days"));
            $end = date('Y-m-d', strtotime("+8 days"));
        } else {
            //计算时间
            $time = date('Y-m-d', strtotime("+1 days"));
            $end = date('Y-m-d', strtotime("+7 days"));
        }

        //选中某个学校获取id
        $where = "yes_school.id in (select school_id from yes_class group by yes_class.school_id) and yes_class.times>='" . $time . "' and yes_class.times<='" . $end . "'";

        //查询已经安排完排课的学校
        $schooldb = D('School');
        $schools = $schooldb->getSchoolListProject($where);
        $this->schools = $schools;

        if(!empty($_REQUEST['bespokeId']))
        {
            //根据预约id,查询上课地点和时间
            $bespokeDb = D('Bespoke');
            $where = "yes_bespoke.id='".$_REQUEST['bespokeId']."'";
            $row = $bespokeDb->getBespokes($where);
        }

        //根据课程id  查询当前课程名称
        $projectDb = D('Project');
        $where = "id='" . $_REQUEST['project_id'] . "'";
        $project = $projectDb->getProjectName($where);

        // 获取当前用户OPENID，并查询当前用户信息
        $app = $this->getAppId();

        $this->projectname = $project['project_name'];
        $this->project_id = $_REQUEST['project_id'];
        $this->bespokeId = $_REQUEST['bespokeId'];
        $this->bespoke = $row;
        $this->app = $app;
        $this->url = __MODULE__.'/Bespoke/ok_appointment';
        $this->display();

    }

    //已预约页面
    public function ok_appointment()
    {
         //查询用户id
        $app = $this->getAppId();

        $bespokeDb = D('Bespoke');
        $rows = $bespokeDb->getBespokeAppId($app['id']);

        $this->rows = $rows;
        $this->display();
    }

    //预约完成页面
    public function complete()
    {
        //查询用户id
        $app = $this->getAppId();

        $bespokeDb = D('Bespoke');
        $rows = $bespokeDb->getBespokeByAppId($app['id']);

        $this->rows = $rows;
        $this->display();
    }

    //地图页面
    public function map()
    {
        $this->lg = $_REQUEST['lg'];
        $this->lt = $_REQUEST['lt'];
        $this->display();
    }

    //查询该课程已经预约的人数
    public function getBespoke()
    {
        $schoolId = $_POST['school_id'];
        $class = null;
        if(!empty($schoolId))
        {
            $classDb = D('Class');
            $projectId = $_POST['project_id'];

            $six = strtotime('Y-m-d') . ' 18:00:00';

            $sub = strtotime($six) - strtotime("now");

            //如果在18:00之前，那么就可以预约明天开始，如果在18:00之后，预约从后天开始
            if ($sub <= 0) {
                //计算时间
                $time = date('Y-m-d', strtotime("+2 days"));
                $end = date('Y-m-d', strtotime("+8 days"));
            } else {
                //计算时间
                $time = date('Y-m-d', strtotime("+1 days"));
                $end = date('Y-m-d', strtotime("+7 days"));
            }
            //选中某个学校获取id
            $where = "yes_class.project_id='" . $projectId . "' and yes_class.school_id='" . $schoolId . "' and yes_class.times>='" . $time . "' and yes_class.times<='" . $end . "'";
            $classes = $classDb->getClassList($where);
            $weekarray = array("开始","一","二","三","四","五","六","日");
            foreach($classes as $key=>$value)
            {
                $times = $value['times'];
                $week = "星期".$weekarray[date('N',strtotime("$times"))];
                $classes[$key]['week'] = $week;
            }
            if(!empty($classes))
            {
                $class = $classes;
            }
            else
            {
                $message = '该学校无排课，请选择其他校区！';
            }
        }
        else
        {
            $message = '请选择校区！';
        }

        echo json_encode(array($class, $message));

    }

    //点击马上预约按钮,第一次预约
    public function zb_yuyue()
    {
        if(empty($_REQUEST['for_time1']) && empty($_REQUEST['for_time2']))
        {
            $message = '请选择校区和上课时间!';
        }
        else {
            if (empty($_REQUEST['for_time1']) && !empty($_REQUEST['for_time2'])) {
                $message = '请选择校区!';
            } else {
                if (!empty($_REQUEST['for_time1']) && empty($_REQUEST['for_time2'])) {
                    $message = '请选择上课时间!';
                } else {
                    if ($_REQUEST['counts'] == $_REQUEST['number']) {
                        $message = '该时间段已满员，请选择其他时间或校区!';
                    } else {
                        if (!empty($_REQUEST['project_id'])) {
                            if (!empty($_REQUEST['class_id'])) {

                                //第一次预约
                                // 获取当前用户OPENID
                                $app = $this->getAppId();

                                //查询订单id
                                $orderDb = D('Order');
                                $where1 = "order_status=1 and project_id='" . $_REQUEST['project_id'] . "' and app_id='" . $app['id'] . "'";
                                $order_id = $orderDb->getOrderId($where1);

                                if (isset($order_id) && !empty($order_id)) {
                                    $bespokeDb = D('Bespoke');
                                    $data = array();
                                    $data['class_id'] = $_REQUEST['class_id'];
                                    $data['project_id'] = $_REQUEST['project_id'];
                                    $data['order_id'] = $order_id;
                                    $data['app_id'] = $app['id'];
                                    $data['create_time'] = date('Y-m-d H:i:s');

                                    //判断是否已经预约
                                    $where = "class_id='" . $data['class_id'] . "' and project_id='" . $data['project_id'] . "' and order_id='" . $data['order_id'] . "' and app_id='" . $data['app_id'] . "'";
                                    $count = $bespokeDb->getBespokeCount($where);
                                    if (empty($count)) {
                                        $result = $bespokeDb->addData($data);
                                        if ($result) {
                                            $message = '0';
                                        } else {
                                            $message = '预约失败！';
                                        }
                                    } else {
                                        $message = '您已经预约成功！';
                                    }

                                } else {
                                    $message = '您还没有购买该课程！';
                                }

                            } else {
                                $message = "请选择预约时间！";
                            }
                        } else {
                            $message = "没有获取到课程！";
                        }
                    }
                }
            }
        }
        $url = __MODULE__.'/Bespoke/ok_appointment';
        echo json_encode(array($message,$url));
    }

    //点击马上预约按钮,进行重新预约
    public function up_yuyue()
    {
        if(empty($_REQUEST['for_time1']) && empty($_REQUEST['for_time2']))
        {
            $message = '请选择校区和上课时间!';
        }
        else
        {
            if(empty($_REQUEST['for_time1']) && !empty($_REQUEST['for_time2']))
            {
                $message = '请选择校区!';
            }
            else
            {
                if(!empty($_REQUEST['for_time1']) && empty($_REQUEST['for_time2']))
                {
                    $message = '请选择上课时间!';
                }
                else
                {
                    if($_REQUEST['counts']==$_REQUEST['number'])
                    {
                        $message ='该时间段已满员，请选择其他时间或校区!';
                    }
                    else
                    {
                        $bespokeDb = D('Bespoke');
                        $data = array();
                        $data['id'] = $_REQUEST['bespoke_id'];
                        $data['class_id'] = $_REQUEST['class_id'];
                        $data['update_time'] = date('Y-m-d H:i:s');
                        $result = $bespokeDb->edit($data);
                        if($result)
                        {
                            $message = '0';
                        }
                        else
                        {
                            $message = '重新预约失败！';
                        }
                    }
                }

            }
        }
        $url = __MODULE__.'/Bespoke/ok_appointment';
        echo json_encode(array($message,$url));
    }

    //点击重新预约按钮
    public  function updateBespoke()
    {
        //1.用户无法修改已预约在当日的课程，该类课程点击<重新预约>弹框提示：您无法修改当天的课程预约。
        //2.当日18点以后，用户无法修改已预约在次日的课程，该类课程点击<重新预约>弹框提示：每日18点后无法修改明日的课程预约
        $time = date('Y-m-d');
        if($_POST['Times']==$time)
        {
            $message = '您无法修改当天的课程预约!';
        }
        else
        {
            $time2 = date('Y-m-d', strtotime("+1 days"));
            if($_POST['Times']==$time2)
            {
                $six = strtotime('Y-m-d') . ' 18:00:00';
                $sub = strtotime($six) - strtotime("now");

                if($sub<0)
                {
                    $message = '每日18点后无法修改明日的课程预约!';
                }
                else
                {
                    $message = '0';
                }
            }
            else
            {
                $message = '0';
            }
        }
        $bespokeId = $_POST['bespokeId'];
        $projectId = $_POST['projectId'];

        echo json_encode(array($message,$bespokeId,$projectId));
    }

    /*=============================================================================================*/

}

?>