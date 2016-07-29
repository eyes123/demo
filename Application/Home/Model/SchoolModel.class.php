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




}

?>