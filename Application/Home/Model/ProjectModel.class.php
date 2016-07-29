<?php

class ProjectModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_project';
		
	public function __construct()
	{
		parent::__construct();
		
	}

    //添加课程
    public function addProject($data)
    {
        $result = $this->add($data);

        return $result;
    }

    //获取课程列表
    public function getProjectList($limit)
    {

        $filed = array("yes_project.*,count(distinct(yes_app.id)) as app_number,count(distinct(yes_order.id)) as order_number,count(distinct(orders.id)) as w_number");
        $rows = $this->field($filed)->page($limit)
            ->join("left join yes_app on yes_app.project_id=yes_project.id")
            ->join("left join yes_order on yes_order.project_id=yes_project.id and yes_order.order_status=1")
            ->join("left join yes_order as orders on orders.project_id=yes_project.id and orders.invi_openid=0 and orders.order_status=1")
            ->group("yes_project.id")
            ->select();

        return $rows;

    }

    //获取数目
    public function getProjectCount()
    {
        $count = $this->count();
        return $count;
    }

    //根据id查询
    public function getProjectId($id)
    {
        $rows = $this->where("id='".$id."'")->select();
        return $rows[0];
    }

    //查询课程
    public function getProjectName()
    {
        $row = $this->field(array("id,project_name,default_id"))->select();
//        echo $this->getLastSql();exit;
        return $row;
    }




}

?>