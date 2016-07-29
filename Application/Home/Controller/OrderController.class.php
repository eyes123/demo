<?php
require_once dirname(dirname(__FILE__)).'/Common/Ext/CsvExcel.php';
class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        SessionManage::checkLogin();
    }

    private function joinwhere()
    {
        if(!empty($_REQUEST))
        {
            if (!empty($_REQUEST['phone'])) {
                $where['yes_app.phone'] = array('like','%'.trim($_REQUEST['phone']).'%');
                $this->phoneWhere = $_REQUEST['phone'];
            }
            if (!empty($_REQUEST['start_time'])) {
                $where['yes_order.create_time'] = array('EGT', $_REQUEST['start_time']);
                $this->startWhere = $_REQUEST['start_time'];
            }

            if (!empty($_REQUEST['end_time'])) {
                if (!empty($where['yes_order.create_time'])) {
                    unset($where['yes_order.create_time']);
                    $where['yes_order.create_time'] = array('between', array($_REQUEST['start_time'], $_REQUEST['end_time']));
                } else {
                    $where['yes_order.create_time'] = array('ELT', $_REQUEST['end_time']);
                }
                $this->endWhere = $_REQUEST['end_time'];
            }
        }
        return $where;

    }

    //订单列表
    public function index()
    {

        $orderMD = D('Order');

        $where = $this->joinWhere();
        if(!empty($_REQUEST['where']))
        {
            $where = json_decode(urldecode($_REQUEST['where']),true);
        }
        $count = $orderMD->getOrderCount($where);
        $limit     = $this->sepePage($count,$_REQUEST);
        $order = $orderMD->getOrderList($limit,$where);

        $this->order = $order;
        $this->where = urlencode(json_encode($where));

        $this->display();
    }

    //导出订单列表
    public function daochuindex()
    {
        $orderDb = D('Order');
        $where = $this->joinWhere();
        $list = $orderDb->getOrderListd($where);

        $data=array();
        $titles=array("用户名","手机号","商品名称","订单金额","支付时间","生成时间","课程状态","红包状态","订单来源");
        $data[]=$titles;
        $clomns = array("nickname","phone","project_name","order_price","pay_time","create_time","state","hongbao_state","project_name");
        $two[] = array();
        foreach ($list as $customer)
        {
            $i = 0;
            foreach ($clomns as $clomn)
            {
                $value = $customer[$clomn];

                if($clomn=='state')
                {

                    if($customer['state']=='1')
                    {

                        $value='已完成';
                    }
                    else
                    {
                        $value='未完成';
                    }

                }
                if($clomn=='hongbao_state')
                {
                    if($customer['hongbao_state']=='1')
                    {
                        $value='已使用';
                    }
                    else
                    {
                        $value='未使用';
                    }

                }
                if($clomn=='pay_time')
                {
                    if($customer['pay_time']=='' or $customer['pay_time']==null)
                    {
                        $value='未支付';
                    }

                }
                $two[$i]=$value;

                $i++;
            }

            $data[]=$two;
        }
        Ext_CsvExcel::outputCsvHeader($data,"订单表".date("Y-m-d h:m",time()));
    }

}