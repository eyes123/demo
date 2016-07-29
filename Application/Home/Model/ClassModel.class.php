<?php

class ClassModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_class';
		
	public function __construct()
	{
		parent::__construct();
		
	}


    //获取列表
    public function getClassList($where)
    {

        $filed = array("yes_school.id as school_id,yes_project.id as project_id,yes_class.id as class_id,count(distinct(yes_bespoke.id)) as counts,yes_class.times,yes_class.timeslot,yes_class.number,yes_project.project_name,yes_project.id as project_id");
        $rows = $this->field($filed)->where($where)
            ->join("left join yes_bespoke on yes_class.id=yes_bespoke.class_id")
            ->join("left join yes_school on yes_class.school_id=yes_school.id")
            ->join("left join yes_project on yes_project.id=yes_class.project_id")
            ->join("left join yes_app on yes_app.id=yes_bespoke.app_id")
            ->group("yes_class.id")
            ->select();

        return $rows;

    }

    //添加排课
    public function addClass($data)
    {
        $result = $this->add($data);

        return $result;
    }

    //删除排课
    public function deleteClass($id)
    {
        $result = $this->where("id='".$id."'")->delete();
  
        return $result;
    }

    //查询排课id
    public function getClassId($where)
    {
        $id = $this->field(array("id"))->where($where)->select();

        return $id[0]['id'];
    }





}

?>