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

        $filed = array("yes_school.id as school_id,yes_class.id as class_id,count(distinct(yes_bespoke.id)) as counts,yes_class.times,yes_class.timeslot,yes_class.number");
        $rows = $this->field($filed)->where($where)
            ->join("left join yes_school on yes_class.school_id=yes_school.id")
            ->join("left join yes_project on yes_project.id=yes_class.project_id")
            ->join("left join yes_bespoke on yes_bespoke.class_id=yes_class.id")
            ->group("yes_class.id")
            ->select();

        return $rows;

    }



}

?>