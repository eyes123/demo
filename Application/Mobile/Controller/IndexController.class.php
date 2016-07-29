<?php

vendor('Sms/SendMessage');
//微信端，第一部分
class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    /*==============================================================================================*/

    //保存微信用户信息
    public function saveUserInfo($data,$pr_id,$p_id,$phone)
    {
        $appDb = D('App');
        $list = $appDb->where(array('openid' => $data['openid']))->find();
        if (!$list)
        {
            //保存当前用户信息
            $arr =array();
            //当前用户手机号
            $arr['phone'] = $phone;
            //推荐人
            $arr['invi_people'] = $p_id;
            $arr['openid'] =  $data['openid'];
            $arr['nickname'] =  $data['nickname'];
            $arr['headimgurl'] =  $data['headimgurl'];
            $arr['project_id'] =  $pr_id;
            $arr['create_time'] = date("Y-m-d H:i:s");
            $id = $appDb->addApp($arr);

            SessionManage::setSession("app_id",$id);
            SessionManage::setSession("project_id",$pr_id);
            return $arr;
		
        }
		else
        {
            SessionManage::setSession("project_id",$pr_id);
			SessionManage::setSession("app_id",$list['id']);
		}
        return $list;
    }

    //发送验证码
    public function send_yzm()
    {
        $message = '';
        $phone =$_REQUEST['phone'];
        if(empty($phone))
        {
            $message = '手机号不能为空';
        }
        else
        {
            if(!preg_match('/^1([0-9]{9})/',$phone))
            {
                //验证不通过
                $message = '手机号码格式有误';
            }
        }
        if ($message=='') {

            SessionManage::setSession('phone', $phone);
            //发送短信
            $chars_array = array(
                "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            );
            $outputstr = '';
            for ($i = 0; $i < 5; $i++) {
                $outputstr .= $chars_array[mt_rand(0, 9)];
            }
            //将验证码存在session
            SessionManage::setSession('yzm', $outputstr);
            //存当前时间
            SessionManage::setSession('time', time());
            $message = "您的暗号为：" . $outputstr . "，请在3分钟内输入暗号查看TA想怎么约";
            SendMessage::send($phone, trim($message));
        }
            // SessionManage::setSession('sendTime', date('Y-m-d H:i:s'));
        $result = array(
            'state'	=> 2,
            'code'  => $outputstr,
        );

        echo  json_encode($result);
    }

    //判断手机号验证码是否正确
    public function yz_py()
    {
        $message= array();
        $phone = SessionManage::getSession("phone");
        $yzm = SessionManage::getSession("yzm");
        $time = SessionManage::getSession("time");

        $phone1 = trim($_REQUEST['phone']);
        $yzm1 = trim($_REQUEST['yzm']);

        //判断验证码是否失效
        $time = time()-$time;
        if($time<=180)
        {
            if (empty($phone1))
            {
                //5 手机号不能为空!
                $message['code'] = '5';
            } else if (empty($yzm1))
            {
                // 1 请先获取验证码!
                $message['code'] = '1';
                $message['message'] = '请先获取验证码!';

            } else if ($yzm != $yzm1)
            {
                //2 验证码输入错误!
                $message['code'] = '2';
                $message['message'] = '验证码输入错误!';
            } else if ($phone != $phone1)
            {
                //手机号不正确
                $message['code'] = '3';
                $message['message'] = '手机号不正确!';
            }
            if (empty($message))
            {
                $message['code'] = "0";
                $appDb = D('App');
                $orderDb = D('Order');
                $id = $appDb->getUserId($phone);
                if ($id !== false && $orderDb->getOrderApp($id) > 0) {
                    $message['url'] = "/index.php/Mobile/wx/pay_success";
                } else {
                    $message['url'] = "/index.php/Mobile/wx/details";
                }
            }
        }
        else
        {
            //验证码失效
            $message['code'] = '6';
            $message['message'] = '验证码失效!';
        }
        echo json_encode($message);
    }

   //支付成功后，发送课程码,保存用户券码信息
    public function send_project($order_id)
    {
        $couponDb = D('Coupon');
        $app_id = SessionManage::getSession('app_id');
        $count = $couponDb->countCouponPr($app_id);
        //如果已经给用户已经发过验证码,则不再发送;
        if($count>=1)
        {
            return false;
        }
        $phone = SessionManage::getSession('phone');
        //发送短信
        $chars_array = array(
            "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        );
        $outputstr = '';
        for ($i=0; $i<6; $i++)
        {
            $outputstr .= $chars_array[mt_rand(0, 9)];
        }
        SessionManage::setSession('yzm', $outputstr);
        $message = "亲爱的用户，您的课程码为：".$outputstr."。通过致电或公众号联系客服预约课程，客服电话：4008103111；公众号内点击-即可在线预约。";
		
        $result = SendMessage::send($phone, $message);
        if($result['code']==2)
        {
            $data = array();
            $data['coupon_type'] = '1';
            $data['coupon_price'] = '99';
            $data['order_code'] = $order_id;
            $data['app_id'] = SessionManage::getSession("app_id");
            $data['project_id'] = SessionManage::getSession("project_id");
            $data['coupon_number'] = $outputstr;
            $data['receive_time'] = date('Y-m-d H:i:s');

            $couponDb = D('Coupon');
            $couponDb->addCoupon($data);
        }

    }

    //分享成功后，发送红包码
    public function send_redpacket()
    {
        $couponDb = D('Coupon');

        $app_id = SessionManage::getSession('app_id');
        $count = $couponDb->countCouponHb($app_id);
        //如果已经给用户已经发过验证码,则不再发送;
        if($count>=1)
        {
            return false;
        }
            $phone = SessionManage::getSession('phone');
            //发送短信
            $chars_array = array(
                "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            );
            $outputstr = '';
            for ($i = 0; $i < 5; $i++) {
                $outputstr .= $chars_array[mt_rand(0, 9)];
            }
            SessionManage::setSession('yzm', $outputstr);

            $message = "亲爱的用户，500元红包已送达，红包可用于课程价格抵扣，红包码：" . $outputstr . "，红包有效期1个月。致电或关注公众号联系客服，了解红包使用详情。客服：4008103111；公众号：mbhtpx";
            $result = SendMessage::send($phone, $message);

            //修改用户，分享完成之后，改变邀请函生成状态
            $arr = array();
            $arr['id'] = SessionManage::getSession("app_id");
            $arr['invitatiom'] = '1';
            $appDb = D('App');
            $appDb->editApp($arr);

            //添加券码信息
            $data = array();
            $data['coupon_type'] = '2';
            $data['coupon_price'] = '500';
            $data['order_id'] = $arr['order_id'];
            $data['app_id'] = SessionManage::getSession("app_id");
            $data['project_id'] = SessionManage::getSession("project_id");
            $data['coupon_number'] = $outputstr;
            $data['receive_time'] = date('Y-m-d H:i:s');

            $couponDb->addCoupon($data);
    }

    //生成订单
    public function order($arr)
    {
            // 用户id,课程id
            $app_id = SessionManage::getSession("app_id");
            $project_id = SessionManage::getSession("project_id");

            //用户id和课程id同时存在
            if(isset($app_id) && !empty($app_id) && isset($project_id) && !empty($project_id))
            {
                $orderDb = D('Order');
                $where = "app_id='".$app_id."' and project_id='".$project_id."' and order_status=1";
                $count = $orderDb->getOrderCount($where);
                //判断用户是否已经购买,没有购买存到数据库
                if($count<=0)
                {
                    $data = array();
                    $data['order_code'] = $orderDb->createNo();
                    $data['app_id'] = $app_id;
                    $data['project_id'] = $project_id;
                    $data['invi_openid'] = $arr['invi_openid'];
                    $data['project_name'] = $arr['project_name'];
                    $data['order_price'] = $arr['order_price']/100;
                    $data['create_time'] = date("Y-m-d H:i:s");
                    $orderDb->addOrder($data);
                }
            }
            return $data;
    }

    //修改订单状态
    public function orderCode($code)
    {
            $ordertDb = D('Order');

            $ordertDb->deal($code);
    }


    /*=============================================================================================*/


}

?>