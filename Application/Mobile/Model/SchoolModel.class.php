<?php

class SchoolModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_school';
		
	public function __construct()
	{
		parent::__construct();
		
	}

    //获取列表
    public function getSchoolList()
    {
        $rows = $this->select();
        return $rows;
    }

    //获取学校已经排课列表
    public function getSchoolListProject($where)
    {
        $rows = $this->field(array('yes_school.*'))->where($where)->join('left join yes_class on yes_class.school_id=yes_school.id')->group('yes_school.id')->
        select();

        return $rows;
    }

}

?>