<?php

class BespokeModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_bespoke';
		
	public function __construct()
	{
		parent::__construct();
		
	}

    //已经预约
    public function getBespokeList($id)
    {

        $rows = $this->field(array("yes_app.id as app_id,yes_app.phone,yes_app.nickname"))
            ->where("yes_bespoke.app_id='".$id."'")
            ->join("left join yes_class on yes_class.id=yes_bespoke.app_id")
            ->join("left join yes_app on yes_app.id=yes_bespoke.app_id")
            ->join("left join yes_app on yes_app.id=yes_bespoke.app_id")
            ->select();
        return $rows;
    }

    //保存预约信息
    public function addData($data)
    {
        $result = $this->add($data);

        return $result;
    }

    //判断是否已经预约
    public function getBespokeCount($where)
    {

        $count = $this->where($where)->count();

        return $count;
    }

    //根据appid查询是否改预约信息,已经验证
    public function getBespokeAppId($appId)
    {
        $time = date('Y-m-d H:i');
        $where = "yes_bespoke.app_id='".$appId."' and yes_order.order_status=1 and yes_class.start_timeslot>'".$time."'";
        $filed = array('yes_class.times,yes_class.timeslot,yes_project.project_name,yes_school.school_name,yes_bespoke.id as bespoke_id,yes_project.id as project_id');
        $rows = $this->field($filed)->where($where)->join('left join yes_class on yes_class.id=yes_bespoke.class_id')
            ->join('left join yes_school on yes_school.id=yes_class.school_id')
            ->join('left join yes_project on yes_project.id=yes_class.project_id')
            ->join('left join yes_order on yes_order.id=yes_bespoke.order_id')
            ->join('inner join yes_coupon on yes_order.order_code=yes_coupon.order_code and yes_coupon.state=0 ')
            ->select();

        return $rows;

    }

    //已经完成预约
    public function getBespokeByAppId($appId)
    {
        $time = date('Y-m-d H:i');
        $where = "yes_bespoke.app_id='".$appId."' and  (yes_coupon.state=1 or yes_class.start_timeslot<='".$time."')";
        $filed = array('yes_class.times,yes_class.timeslot,yes_project.project_name,yes_school.school_name,yes_bespoke.id as bespoke_id,yes_project.id as project_id');
        $rows = $this->field($filed)->where($where)->join('left join yes_class on yes_class.id=yes_bespoke.class_id')
            ->join('left join yes_school on yes_school.id=yes_class.school_id')
            ->join('left join yes_project on yes_project.id=yes_class.project_id')
            ->join('left join yes_order on yes_order.id=yes_bespoke.order_id')
            ->join('left join yes_coupon on yes_order.order_code=yes_coupon.order_code ')
            ->select();
//echo $this->getLastSql();exit;
        return $rows;
    }

    //根据id查询信息
    public function getBespokes($where)
    {
        $rows = $this->field(array('yes_school.school_name,yes_school.lt,yes_school.lg,yes_school.id as school_id,yes_class.id as class_id,yes_school.area,yes_class.times,yes_class.timeslot,count(distinct(yes_bespoke.id)) as counts,yes_class.number'))
            ->where($where)
            ->join('left join yes_class on yes_class.id=yes_bespoke.class_id')
            ->join('left join yes_school on yes_school.id=yes_class.school_id')
            ->join('left join yes_project on yes_project.id=yes_class.project_id')
            ->group("yes_class.id")
            ->select();
//        echo $this->getLastSql();
        return $rows[0];
    }

    //修改信息
    public function edit($data)
    {
        $result = $this->where("id='".$data['id']."'")->save($data);

        return $result;
    }

}

?>