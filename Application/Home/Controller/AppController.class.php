<?php

require_once dirname(dirname(__FILE__)).'/Common/Ext/Csv.class.php';
class AppController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        SessionManage::checkLogin();
    }
    
    //查询条件
    private function joinwhere()
    {
        if(!empty($_REQUEST))
        {
            if (!empty($_REQUEST['phone']))
            {
                $where['yes_app.phone'] = array('like','%'.trim($_REQUEST['phone']).'%');
                $this->phoneWhere = $_REQUEST['phone'];
            }
            if (!empty($_REQUEST['start_time']))
            {
                $where['yes_app.create_time'] = array('EGT', $_REQUEST['start_time']);
                $this->startWhere = $_REQUEST['start_time'];
            }
            if (!empty($_REQUEST['end_time']))
            {
                if (!empty($where['yes_app.create_time']))
                {
                    unset($where['yes_app.create_time']);
                    $where['yes_app.create_time'] = array('between', array($_REQUEST['start_time'], $_REQUEST['end_time']));
                }
                else
                {
                    $where['yes_app.create_time'] = array('ELT', $_REQUEST['end_time']);
                }
                $this->endWhere = $_REQUEST['end_time'];
            }
        }
        return $where;
    }

    //用户列表
    public function index()
    {
        import("Org.Page");
        $user = D('App');
        $where = $this->joinwhere();
        if(!empty($_REQUEST['where']))
        {
            //解码 变成数组
            $where = json_decode(urldecode($_REQUEST['where']),true);
        }
        $count = $user->getAppCount($where);
        $limit     = $this->sepePage($count,$_REQUEST);
        $users = $user->getAppList($limit,$where);

        $this->users = $users;
        $this->where = urlencode(json_encode($where));
        $this->display();
    }

    //邀请函页
    public function yqh()
    {
        if(!empty($_REQUEST))
        {
            $user_id = $_REQUEST['app_id'];
            $users = D('App');
            $yqh = $users->getAppId($user_id);
            $this->yqh = $yqh;
        }
        $url = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/index.php/Mobile/wx/index?tiker=' . $yqh["id"];
        $this->url = $url;
        $this->display();
    }

    //邀请人数
    public function yqrs()
    {
        $user = D('App');
        $id = $_REQUEST['app_id'];
        $yqrs = $user->getAppRs($id);
        $this->yqrs = $yqrs;
        $this->display();
    }

    //邀请人详情
    public function yqr()
    {
        $user = D('App');
        $invi_people = $_REQUEST['invi_people'];
        $yqr = $user->getAppR($invi_people);
        $this->yqr = $yqr;
        $this->display();
    }

    //邀请单数详情
    public function yqds()
    {

        $user = D('App');
        $id = $_REQUEST['app_id'];
        $yqds = $user->getAppDs($id);
        $this->yqds = $yqds;
        $this->display();
    }

    // 扫描用户二维码
    public function getQrcode()
    {
        import ( 'Org.QRcode' );
        $value = "http://".$_SERVER['HTTP_HOST'].__ROOT__.'/index.php/Mobile/Wx/index?tiker=' . $_REQUEST["tiker"]  ;
        $errorCorrectionLevel = "Q";
        $matrixPointSize = "4";
        ob_clean();
        QRcode::png ($value,false,$errorCorrectionLevel,$matrixPointSize);
        exit ();
    }

    //导出用户列表
    public function daochuindex()
    {
        $userDb = D('App');
        $where = $this->joinWhere();
        $list = $userDb->getAppListd($where);

        for ($i=0; $i < count($list); $i++) {
            if($list[$i]['invitatiom'] == 0)
            {
                $list[$i]['invitatiom'] = '未生成';
            }
            elseif($list[$i]['invitatiom'] == 1)
            {
                $list[$i]['invitatiom'] = '已生成';
            }
        }
        $titles=array("用户名","手机号","邀请函页","邀请人数","邀请单数","邀请人","生成时间","用户来源");
        Csv::put_csv($list,$titles);
    }
}