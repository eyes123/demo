<?php

class CouponModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_coupon';
		
	public function __construct()
	{
		parent::__construct();
		
	}

    //添加券码
    public function addCoupon($data)
    {
        $result = $this->add($data);
        return $result;
    }

    //判断该用户的红包码是否存在
    public function countCouponHb($app_id)
    {
        $count = $this->where("coupon_type=2 and coupon_number!='' and app_id='".$app_id."'")->count();

        return $count;
    }
    //判断该用户的红包码是否存在
    public function countCouponPr($app_id)
    {
        $count = $this->where("coupon_type=1 and coupon_number!=''and='' and app_id='".$app_id."'")->count();

        return $count;
    }

}

?>