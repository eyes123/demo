<?php
require_once dirname(dirname(__FILE__)).'/Common/Ext/CsvExcel.php';
class CouponController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //筛选条件
    private function joinWhere()
    {
        if(!empty($_REQUEST))
        {
            if (!empty($_REQUEST['phone'])) {
                $where['yes_app.phone'] = array('like','%'.trim($_REQUEST['phone']).'%');
                $this->phoneWhere = $_REQUEST['phone'];
            }
            if (!empty($_REQUEST['start_time'])) {
                $where['yes_coupon.receive_time'] = array('EGT', $_REQUEST['start_time']);
                $this->startWhere = $_REQUEST['start_time'];
            }

            if (!empty($_REQUEST['end_time'])) {
                if (!empty($where['yes_coupon.receive_time'])) {
                    unset($where['yes_coupon.receive_time']);
                    $where['yes_coupon.receive_time'] = array('between', array($_REQUEST['start_time'], $_REQUEST['end_time']));
                } else {
                    $where['yes_coupon.receive_time'] = array('ELT', $_REQUEST['end_time']);
                }
                $this->endWhere = $_REQUEST['end_time'];
            }
        }
//        print_r($_REQUEST['start_time']);
        return $where;
    }

    //券码列表
    public function index()
    {
        SessionManage::checkLogin();
        $couponMD = D('Coupon');
        $where = array();
        $where = $this->joinWhere();
//        print_r($where);exit;
        if(!empty($_REQUEST['where']))
        {
            $where = json_decode(urldecode($_REQUEST['where']),true);
        }
        $count = $couponMD->getCouponCount($where);
        $limit     = $this->sepePage($count,$_REQUEST);
        $coupon = $couponMD->getCouponList($limit,$where);
//        print_r($coupon);exit;
        $this->coupon = $coupon;
        $this->where = urlencode(json_encode($where));

        $this->display();
    }

    //验证券码是否正确
    public function yzCoupon()
    {
        SessionManage::checkLogin();
        $id = $_POST['id'];
        $quanma = $_POST['qm'];
        $mima = $_POST['mi'];
        $md5 = md5($mima);

        //查询券码并验证券码是否正确
        $couponDb = D('Coupon');
        $sqm = $couponDb->yzCoupon($id);
        $name = '';
        if($quanma==$sqm)
        {
            $data = array();
            $useDb = D('User');
            //判断密码是否存在数据库
            $count = $useDb->getUserPcount($md5);
            if($count>0)
            {
                $row  = $useDb->getUserPasswd($md5);

                $data['id'] =$id;
                $data['veri_id'] = $row['id'];
                $data['state'] = '1';
                $data['veri_time'] = date("Y-m-d H:i:s");
                $result = $couponDb ->editCoupon($data);

                if($result)
                {
                    $message = '0';
                    $name = $row['name'];
                }
                else
                {
                    $message = '1';
                }
            }
            else
            {
                //密码输入错误
                $message = '输入密码错误';
            }
        }
        else
        {
            //验证码错误
            $message = '验证码错误';
        }
        echo  json_encode(array($message,$name));
    }

    //导出订单列表
    public function daochuindex()
    {

        $couponMD = D('Coupon');
        $where = array();
        $where = $this->joinWhere();

        $list = $couponMD->getCouponListd($where);

        $data=array();
        $titles=array("券码类型","券码面值","用户名","手机号","领取时间","验证时间","券码来源","验证状态");
        $data[]=$titles;
        $clomns = array("coupon_type","coupon_price","nickname","phone","receive_time","veri_time","project_name","veri_id");
        $two[] = array();
        foreach ($list as $customer)
        {
            $i = 0;
            foreach ($clomns as $clomn)
            {
                $value = $customer[$clomn];

                if($clomn=='veri_id')
                {
                    if($customer['veri_id']=='0')
                    {
                        $value = '未验证';
                    }
                    else
                    {
                        $value = $customer['name'].'验证';
                    }
                }
                if($clomn=='veri_time')
                {
                    if($customer['veri_time']==null)
                    {
                        $value = '未消费';
                    }
                }

                $two[$i]=$value;

                $i++;
            }

            $data[]=$two;
        }

        Ext_CsvExcel::outputCsvHeader($data,"券码表".date("Y-m-d h:m",time()));

    }
}