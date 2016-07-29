<?php

class AppModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_app';
	public function __construct()
	{
		parent::__construct();
	}
    //添加用户
    public function addApp($data)
    {
        $result  = $this->add($data);
        return $result;
    }
    //获取用户列表
    public function getAppList($limit,$where)
    {
        $sort = empty($sort)?'yes_app.create_time desc':$sort;
//        $filed = array("yes_app.*,yes_project.project_name,count(a.id) as number,b.nickname as referees,count(orders.id) as orders_no");
        $filed = array("yes_app.*,count(distinct(a.id)) as number,b.nickname as referees,count(distinct(orders.id)) as orders_no,yes_project.project_name");
        $rows = $this->field($filed)->where($where)->page($limit)
            ->join("left join yes_order on yes_app.id=yes_order.app_id")
            ->join("left join yes_project on yes_project.id=yes_app.project_id")
            ->join("left join yes_app a on a.invi_people=yes_app.id")
            ->join("left join yes_app b on b.id=yes_app.invi_people")
            ->join("left join yes_order orders on orders.invi_openid=yes_app.id and orders.order_status=1")
            ->group("yes_app.id")
            ->order($sort)->select();
//        echo  $this->getLastSql();
        return $rows;
    }

    //获取用户列表
    public function getAppListd($where)
    {
        $sort = empty($sort)?'yes_app.create_time desc':$sort;
//        $filed = array("yes_app.*,yes_project.project_name,count(a.id) as number,b.nickname as referees,count(orders.id) as orders_no");
        $filed = array("yes_app.nickname,yes_app.phone,yes_app.invitatiom,yes_app.invitatiom,count(distinct(a.id)) as number,count(discount(orders.id)) as orders_no,b.nickname as referees,yes_app.create_time,yes_project.project_name");
        $rows = $this->field($filed)->where($where)
            ->join("left join yes_order on yes_app.id=yes_order.app_id")
            ->join("left join yes_project on yes_project.id=yes_app.project_id")
            ->join("left join yes_app a on a.invi_people=yes_app.id")
            ->join("left join yes_app b on b.id=yes_app.invi_people")
            ->join("left join yes_order orders on orders.invi_openid=yes_app.id and orders.order_status=1")
            ->group("yes_app.id")
            ->order($sort)->select();
//        echo $this->getLastSql();exit;
        return $rows;

    }

    //获取用户数目
    public function getAppCount($where)
    {

        $count = $this->where($where)->count();
//           print_r($count);exit;
        return $count;
    }

    //根据id查询
    public function getAppId($id)
    {
        $rows = $this->where("id='".$id."'")->select();
        return $rows[0];
    }

    //查询邀请人数
    public function  getAppRs($id)
    {
        $filed = array("yes_app.*,count(distinct(a.id)) as number,b.nickname as referees,count(distinct(orders.id)) as orders_no,yes_project.project_name");
        $rows = $this->field($filed)->where("yes_app.invi_people='".$id."'")
            ->join("left join yes_order on yes_app.id=yes_order.app_id")
            ->join("left join yes_project on yes_project.id=yes_app.project_id")
            ->join("left join yes_app a on a.invi_people=yes_app.id")
            ->join("left join yes_app b on b.id=yes_app.invi_people ")
            ->join("left join yes_order orders on orders.app_id=a.id and orders.order_status=1")
            ->group("yes_app.id")->select();
//        echo $this->getLastSql();exit;
        return $rows;
    }

    //查询邀请详情
    public function  getAppR($invi_people)
    {
        $filed = array("yes_app.*,count(distinct(a.id)) as number,b.nickname as referees,count(distinct(orders.id)) as orders_no,yes_project.project_name");
        $rows = $this->field($filed)->where("yes_app.id='".$invi_people."'")
            ->join("left join yes_order on yes_app.id=yes_order.app_id")
            ->join("left join yes_project on yes_project.id=yes_app.project_id")
            ->join("left join yes_app a on a.invi_people=yes_app.id")
            ->join("left join yes_app b on b.id=yes_app.invi_people ")
            ->join("left join yes_order orders on orders.app_id=a.id and orders.order_status=1")
            ->group("yes_app.id")->select();
//        echo $this->getLastSql();exit;
        return $rows;
    }

    //查询邀请人数
    public function  getAppDs($id)
    {
        $filed = array("yes_app.nickname,yes_order.order_code,yes_order.create_time,yes_order.order_price,b.nickname as referees");
        $rows = $this->field($filed)->where("yes_order.invi_openid='".$id."' and yes_order.order_status='1'")
            ->join("left join yes_order on yes_app.id=yes_order.app_id")
            ->join("left join yes_app b on b.id=yes_app.invi_people")
            ->group("yes_app.id")->select();
//        echo $this->getLastSql();exit;
        return $rows;
    }

    //判断手机号是否已注册
    public function getAppPhoneCount($phone)
    {
        $count = $this->where("phone='".$phone."'")->count();

        return $count;

    }

    //根据手机号查询用户id
    public function getAppPhone($phone)
    {
        $row = $this->field(array("id","nickname"))->where("phone='".$phone."'")->select();

        return $row[0];
    }

}

?>