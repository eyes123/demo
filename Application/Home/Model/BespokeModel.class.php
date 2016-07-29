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
    public function getBespokeByAppId($AppId)
    {
        $rows = $this->field(array("yes_class.id as class_id,yes_class.times,yes_class.times,yes_class.timeslot,yes_project.project_name,yes_school.school_name"))
            ->where("app_id='".$AppId."'")
            ->join("left join yes_class on yes_class.id=yes_bespoke.class_id")
            ->join("left join yes_school on yes_school.id=yes_class.school_id")
            ->join("left join yes_project on yes_project.id=yes_class.project_id")
            ->select();
        return $rows;
    }

    //获取列表
    public function getBespokeList($id)
    {

        $rows = $this->field(array("yes_app.id as app_id,yes_app.phone,yes_app.nickname"))
            ->where("class_id='".$id."'")
            ->join("left join yes_app on yes_app.id=yes_bespoke.app_id")
            ->select();
        return $rows;
    }

    //添加
    public function addBespokeApp($data)
    {
        $result = $this->add($data);
        return $result;

    }
    //查询学员是否已经排完课程
    public function getBespokeAppCount($where)
    {
        $count = $this->where($where)->count();
        return $count;
    }

    //删除
    public function deleteBespokeApp($where)
    {
        $result = $this->where($where)->delete();

        return $result;
    }




}

?>