<?php

class UserPowModel extends Model
{
	protected $trueTableName = 'act_user_pow';
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 添加权限操作
	 */
	public function addUserPow($data)
	{
		$result = $this->add($data);

		return $result;
	}	

	/**
	 * 删除权限操作
	 */
	public function deleteUserPowByIds($ids)
	{
		$affectRow = $this->where("id in ($ids)")->delete();

		$result=false;
		if($affectRow > 0)
		{
			$result = true;
		}

		return $result;
	}
	
	/**
	 * 编辑功能名
	 */
	public function editUserPow($data,$where='')
	{
		if($where=='')
		{
			$where = "id = '".$data["id"]."'";
		}
		$result = $this->where($where)->save($data);

		return $result;
	}
	
	/**
	 * 通过功能id值查询功能
	 */
	public function getUserPowById($id)
	{
		$arr = $this->where('id='.$id)->select();
		$one = empty($arr)?null:$arr[0];
		return $one;
	}
	
	/**
	 * 通过功能id值查询功能
	 */
	public function getUserPowById1($ids)
	{
		$arr = $this->where("pow_id in ($ids)")->select();
		$one = empty($arr)?null:$arr[0];
		return $one;
	}
	/**
	 *获取列表
	 */
	public function getUserPowLists($where = '1=1',$order = ' order_no ')
	{
		$arr = $this->where($where)->order($order)->select();
		return $arr;
	}
	
	/**
	 * 通过用户id值找到权限的id
	 */
	public function getUserPowIdByUserId($id)
	{
		$arr = $this->field('pow_id')->where("user_id='$id'")->select();
		$name = empty($arr)?"":$arr[0]['pow_id'];
		return $name;
	}
	
	/**
	 * 通过功能id值找到功能的名字
	 */
	public function getUserPowCountByName($name)
	{
		$count = $this->where("pow_name='.$name'")->count();
		return $count;
	}
	/**
	 * 通过功能id值找到功能的名字
	 */
	public function getUserPowCountByWhere($where)
	{
		$count = $this->where($where)->count();
		return $count;
	}
}
?>