<?php

class CouponModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_coupon';
		
	public function __construct()
	{
		parent::__construct();
		
	}

    //获取券码列表
    public function getCouponList($limit,$where)
    {
        $sort = empty($sort)?'yes_coupon.receive_time desc':$sort;
        $filed = array("yes_app.nickname,yes_app.phone,yes_coupon.*,yes_user.name,yes_project.project_name");
        $rows = $this->field($filed)->where($where)->page($limit)->order($sort)
            ->join("left join yes_app on yes_app.id=yes_coupon.app_id")
            ->join("left join yes_user on yes_user.id=yes_coupon.veri_id")
            ->join("left join yes_project on yes_project.id=yes_coupon.project_id")
        ->select();

//        echo $this->getLastSql();exit;
//         print_r($rows);exit;
        return $rows;

    }

    //获取券码列表
    public function getCouponListd($where)
    {

        $filed = array("yes_app.nickname,yes_app.phone,yes_coupon.*,yes_user.name,yes_project.project_name");
        $rows = $this->field($filed)->where($where)
            ->join("left join yes_app on yes_app.id=yes_coupon.app_id")
            ->join("left join yes_user on yes_user.id=yes_coupon.veri_id")
            ->join("left join yes_project on yes_project.id=yes_coupon.project_id")
            ->select();
//        echo $this->getLastSql();exit;
        return $rows;

    }

    //获取数目
    public function getCouponCount($where)
    {
        $count = $this->where($where)->count();
        return $count;
    }

    //根据id查询
    public function getCouponId($id)
    {
        $rows = $this->where("id='".$id."'")->select();
        return $rows[0];
    }

    //根据id查询券码
    public function yzCoupon($id)
    {
        $rows = $this->field(array("coupon_number"))->where("id='".$id."'")->select();
//        echo $this->getLastSql();exit;
//        print_r($rows);exit;
        return $rows[0]['coupon_number'];
    }

    //保存券码
    public function editCoupon($data)
    {
        $result = $this->where("id='".$data['id']."'")->save($data);
//        echo $this->getLastSql();exit;
        return $result;
    }



}

?>