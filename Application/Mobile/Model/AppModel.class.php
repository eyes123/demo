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

    //编辑用户信息（修改）
    public function editApp($data)
    {
        $result = $this->where("id='".$data['id']."'")->save($data);
        return $result;
    }


    //获取用户数目
    public function getAppPhoneId($phone)
    {
        $row = $this->where("phone='".$phone."'")->select();
        return $row[0];

    }

    //根据id查询
    public function getAppId($id)
    {
        $rows = $this->where("id='".$id."'")->select();

        return $rows[0];
    }


    //判断手机号是否已注册
    public function getAppPhoneCount($phone)
    {
        $count = $this->where("phone='".$phone."'")->count();

        return $count;

    }

    //根据poenid查询用户信息
    public function getAppOpenid($openid)
    {
        $rows = $this->where("openid='".$openid."'")->select();

        return $rows[0];
    }

    //根据poenid查询用户信息
    public function getAppPhone($phone)
    {
        $rows = $this->where("phone='".$phone."'")->select();

        return $rows[0]['id'];
    }
	
	// 获取用户ID
	public function getUserId($phone){
		$res = $this->where("phone='".$phone."'")->find();
		if( !$res || !is_array($res)) return  false;
		
		return $res['id'];
	}

    //查询待预约课程
    public function getAppProName($where)
    {
        $filed = array("yes_project.project_name,yes_project.id as project_id");
        $rows = $this->field($filed)->where($where)
            ->join('left join yes_order on yes_app.id=yes_order.app_id')
            ->join('left join yes_project on yes_project.id=yes_order.project_id')
            ->join('left join yes_coupon on yes_coupon.app_id=yes_app.id')
            ->select();
//        echo $this->getLastSql();exit;
        return $rows;

    }

    //根据openid  查询用户名称和手机号
    public function getAppNameOpenid($where)
    {
        $row = $this->field(array('id,nickname','phone'))->where($where)->select();

        return $row[0];
    }

}

?>