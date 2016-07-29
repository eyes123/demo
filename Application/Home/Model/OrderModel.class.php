<?php

class OrderModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_order';
		
	public function __construct()
	{
		parent::__construct();
		
	}

    //获取订单列表
    public function getOrderList($limit,$where)
    {
        $sort = empty($sort)?'yes_order.create_time desc':$sort;
        $filed = array("yes_order.*,yes_app.nickname,yes_app.phone,yes_coupon.coupon_type,yes_coupon.coupon_price,yes_coupon.state,d.state as hongbao_state,yes_project.project_name");
        $rows = $this->field($filed)->where($where)->page($limit)
            ->join("left join yes_app on yes_app.id=yes_order.app_id")
            ->join("left join yes_coupon on yes_coupon.order_code=yes_order.order_code")
            ->join("left join yes_project on yes_project.id=yes_order.project_id")
            ->join("left join yes_coupon d on d.app_id=yes_order.app_id and d.coupon_type='2'")->group('yes_order.id')->
        order($sort)->select();
//        echo $this->getLastSql();exit;
        return $rows;
    }

    //导出订单列表
    public function getOrderListd($where)
    {
        $sort = empty($sort)?'yes_order.create_time desc':$sort;
        $filed = array("yes_order.*,yes_app.nickname,yes_app.phone,yes_coupon.coupon_type,yes_coupon.coupon_price,yes_coupon.state,d.state as hongbao_state,yes_project.project_name");
        $rows = $this->field($filed)->where($where)
            ->join("left join yes_app on yes_app.id=yes_order.app_id")
            ->join("left join yes_coupon on yes_coupon.order_code=yes_order.order_code")
            ->join("left join yes_project on yes_project.id=yes_order.project_id")
            ->join("left join yes_coupon d on d.app_id=yes_order.app_id and d.coupon_type='2'")->group('yes_order.id')->
            order($sort)->select();
//        echo $this->getLastSql();exit;
        return $rows;
    }

    //获取数目
    public function getOrderCount($where)
    {
        $count = $this->where($where)->count();
        return $count;
    }

    //根据id查询
    public function getOrderId($id)
    {
        $rows = $this->where("id='".$id."'")->select();
        return $rows[0];
    }

    //根据条件 查询订单id
    public function getOrderIdWhere($where)
    {
        $rows = $this->field(array("id"))->where($where)->select();
        return $rows[0]['id'];
    }

    //查询原始订单数
    public function getOrderByProjectId($where)
    {
        $rows = $this->field(array('yes_order.order_code','yes_app.nickname','yes_order.order_price','yes_order.pay_time'))->where($where)
            ->join('left join yes_app on yes_app.id=yes_order.app_id')
            ->select();
//        echo $this->getLastSql();
        return $rows;
    }

}

?>