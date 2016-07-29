<?php

class OrderModel extends Model
{
    protected $connection = 'DB_DSN';
    protected $trueTableName = 'yes_order';

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 生成订单号码
     * @return string
     */
    public function createNo()
    {
        $chars_array = array(
            "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j",
            "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
            "u", "v", "w", "x", "y", "z", "A", "B", "C", "D",
            "E", "F", "G", "H", "I", "J", "K", "L", "M", "N",
            "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X",
            "Y", "Z",
        );

        $outputstr = '';
        for ($i = 0; $i < 2; $i++) {
            $outputstr .= $chars_array[mt_rand(0, 61)];
        }
        $orderSn = date('ymdHis') . substr(microtime(), 2, 6) . $outputstr;
        return $orderSn;
    }

    //添加信息
    public function addOrder($data)
    {
        $result = $this->add($data);

        return $result;
    }

    //根据订单编号查询
    public function getOrderCode($order_code)
    {
        $count = $this->where("order_code='" . $order_code . "'")->count();
        return $count;
    }

    //根据用户id查询是否已经支付
    public function getOrderApp($app_id)
    {
        $count = $this->where("order_status=1 and app_id='" . $app_id . "'")->count();
        return $count;
    }

    //修改订单状态
    public function editOrder($data)
    {
        $result = $this->where("order_code='" . $data['order_code'] . "'")->save($data);

        return $result;
    }


    //支付成功,处理数据库
    public function deal($code)
    {
        //获取有无订单信息
        $ordercount = $this->getOrderCode($code);

        if ($ordercount<=0)
        {
           return false;
        }
        else
        {
            $arr = array();
            $arr['order_code'] = $code;
            $arr['order_status'] = '1';
            $arr['pay_time'] = date("Y-m-d H:i:s");

            $result = $this->where("order_code='" . $code . "'")->save($arr);

        }
        return $result;
    }

    //根据用户id，课程id查询订单id
    public function getOrderId($where)
    {
        $row = $this->field(array('id')) ->where($where)->select();

        return $row[0]['id'];
    }

    //判断是否
    public function getOrderCount($where)
    {
        $count = $this->where($where)->count();

        return $count;
    }

}




?>