<?php


class UserModel extends Model
{
	protected $connection = 'DB_DSN';
	protected $trueTableName  = 'yes_user';
		
	public function __construct()
	{
		parent::__construct();
		
	}
	
	/**
	 * 
	 * 功能：用户登录函数
	 * 返回：
	 *     登录失败--0
	 *     登录成功--返回用户信息
	 */
	public function login($userName, $pwd)
	{
		$arr['name']   = $userName;
		$arr['passwd'] = md5($pwd);

		$rows = $this->where($arr)->select();
//		echo $this->getLastSql();exit;
		if(count($rows) <= 0)
		{
			return 0;
		}
		
		return $rows['0'];
	}
	
	/**
	 * 获取用户的条数
	 */
	public function getUserCount()
	{
		$count = $this->count();
		return $count;
	}
	/**
	 * 判断用户名是否重复
	 */
	public function getUserCountWhere($name)
	{
		$count = $this->where("name='$name'")->count();
		return $count;
	}
	/**
	 * 判断用户名是否重复
	 */
	public function getUserCountWhere1($name,$id)
	{
		$count = $this->where("name='$name' and id!='$id'")->count();
		return $count;
	}
	
	/**
	 * 获取所有用户
	 */
	public function getUserList($limit)
	{
		$rows=$this->page($limit)->select();
		return $rows;
	}

	
	//添加
	public function addData($data)
	{
		if(empty($data['id']))
		{
			$data['id']=$this->create_guid();
		}
		if(empty($data['phone']))
		{
			$data['phone']='null';
		}

		$result = $this->add($data);

		
		return $result;
	}
	
	//获取用户信息
	public function getUserById($id)
	{
		$user=null;
		$rows=$this->where("id='".$id."'")->select();
		if(!empty($rows))
		{
			$user = $rows['0'];
		}
// 		echo $this->getLastSql();
		return $user;
	}
	
	//修改用户信息
	public function editUser($data)
	{
		$result= $this->where("id='".$data['id']."'")->save($data);

		
		return $result;
	}

	//批量删除
	public function delAds($ids)
	{
		
		$result= $this->where('id in('.$ids.')')->delete();

		return $result;
	}
	
	//单个删除
	public function delAd($id)
	{
		
		$result=$this->where('id="'.$id.'"')->delete();

		
		return $result;
	}
	
	/**
	 * 查询名称
	 * @param unknown $appId
	 */
	public function getUserName($id)
	{
		$name = '';
		$rows = $this->field('name')->where("id='".$id."'")->select();
// 		print_r($this->getLastSql());
		if(!empty($rows))
		{
			
			$name = $rows[0]["name"];
		}
		return $name;
	}

    //判断手机号是否已注册
    public function getUserPcount($pd)
    {
        $count = $this->where("passwd='".$pd."'")->count();

        return $count;

    }

    //根据密码查询用户信息
    public function getUserPasswd($pd)
    {
        $rows = $this->field('id,name')->where("passwd='".$pd."'")->select();

        return $rows[0];
    }
}

?>