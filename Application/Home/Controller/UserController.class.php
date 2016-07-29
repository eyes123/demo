<?php

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        SessionManage::checkLogin();
    }

    //管理员列表
    public function index()
    {
        import("Org.Page");
        $user = D('User');
        $count = $user->getUserCount();
        $limit     = $this->sepePage($count,$_REQUEST);
        $users = $user->getUserList($limit);

        $this->users = $users;
        $this->display();
    }

    //添加用户
    public function add()
    {
        if(!empty($_REQUEST['submit']))
        {
            $userDb = D('User');
            $s = $userDb->getUserCountWhere($_REQUEST['user_name']);
            if(!empty($s))
            {
                echo "用户名已经存在,请重新添加用户名";
            }
            else
            {
                $data = array();
                $data['id']=$userDb->create_guid();
                $data['name']      = $_REQUEST['user_name'];
                $data['school_id']      = $_REQUEST['school_id'];
                $data['passwd']    = md5($_REQUEST['user_pwd']);

                $result = $userDb->addData($data);
                $userpowDb=D('UserPow');
                $userId = $userDb->getLastInsID();
                $datas=array();
                $datas['pow_id']=$_REQUEST['pow_id'];
                $datas['user_id']=	$data['id'];
                $userpow = $userpowDb->addUserPow($datas);

                $url  = __MODULE__.'/User/index';
                if($result)
                {
                    $this->success('添加成功！',$url);
                    exit;
                }
                else
                {
                    $this->error('添加失败！',$url);
                    exit;
                }
            }
        }
        //查询权限名称
        $powDb=D('Pow');
        $pow = $powDb->getPowLists();
        $this->pow = $pow;
        //查询学校名称
        $schoolDb=D('School');
        $school = $schoolDb->getSchoolList();
        $this->school = $school;

        $this->one = $_REQUEST;
        $this->display();
    }

    //编辑用户
    public function edit()
    {
        if(!empty($_REQUEST['user_id']))
        {
            $userDb = D('User');
            $userpowDb=D('UserPow');

            if(!empty($_REQUEST['act']) && ($_REQUEST['act'] == 'editSubmit'))
            {
                $ss = $userDb->getUserCountWhere1($_REQUEST['user_name'],$_REQUEST['user_id']);

                if(!empty($ss))
                {
                    echo "用户名已经存在,请重新编辑用户名";
                }
                else
                {
                    $data['id']         = $_REQUEST['user_id'];
                    $data['name']       = $_REQUEST['user_name'];
                    $data['school_id']      = $_REQUEST['school_id'];

                    if(!empty($_REQUEST['user_pwd']))
                    {
                        $data['passwd']    = md5($_REQUEST['user_pwd']);

                    }
                    $result = $userDb->editUser($data);
                    $datas=array();

                    $datas['pow_id']=$_REQUEST['pow_id'];
                    $datas['user_id']=$_REQUEST['user_id'];
                    $where = "user_id='".$datas['user_id']."'";
                    $count = $userpowDb->getUserPowCountByWhere($where);
                    if($count>0)
                    {
                        $result0 = $userpowDb->editUserPow($datas,$where);
                    }
                    else
                    {
                        $result0 = $userpowDb->addUserPow($datas,$where);
                    }
                    if($result || $result0)
                    {
                        $this->success('修改成功！',__MODULE__.'/user/index');
                        exit;
                    }
                    else
                    {
                        $this->error('修改失败！',__MODULE__.'/user/index');
                        exit;
                    }
                }
            }
            $actionId=$userpowDb->getUserPowIdByUserId($_REQUEST['user_id']);
            //查询权限名称
            $powDb=D('Pow');
            $pow = $powDb->getPowLists();
            $this->pow = $pow;

            //查询学校名称
            $schoolDb = D('School');
            $schools = $schoolDb->getSchoolList();

            $id = $_REQUEST['user_id'];
            $user = $userDb->getUserById($id);

            $this->schools = $schools;
            $this->user = $user;
            $this->actionId=$actionId;
            $this->schoolId=$user['school_id'];
            $this->display();
        }
    }

    //修改当前用户密码
    public function editlogin()
    {
        if(!empty($_REQUEST['submit']))
        {
            $userId = SessionManage::getUserId();
            $userDb=D('User');
            $users=$userDb->getUserById($userId);
            $user_pw=md5($_REQUEST['user_pw']);

            if($users['passwd']==$user_pw)
            {
                if(!empty($_REQUEST['user_pwd']))
                {
                    if($_REQUEST['user_pwd']==$_REQUEST['confirm_pwd'])
                    {
                        $data=array();
                        $data['id']=$userId;
                        $data['passwd']=md5($_REQUEST['user_pwd']);
                        $result=$userDb->editUser($data);
                        // 				print_r($data);exit;
                        if($result)
                        {
                            $this->success('修改成功！',__MODULE__/User/index);
                            exit;
                        }
                        else
                        {
                            $this->error('修改失败！',__MODULE__/User/index);
                            exit;
                        }
                    }
                    else
                    {
                        echo  "两次输入的密码不一致";

                    }
                }
                else
                {
                    echo "新密码输入有误！";
                }
            }

            else
            {
                echo "原密码输入有误！";
            }
        }
        $this->display();
    }

    //删除用户
    public function delete()
    {
        if(!empty($_REQUEST['user_id']))
        {
            $userDb   = D("User");
            $result = $userDb->delAd($_REQUEST['user_id']);
        }
        if(!empty($result))
        {
            $this->success('删除成功',__MODULE__.'/User/index');
            exit;
        }
        else
        {
            //添加失败
            $this->error('删除失败！',__MODULE__.'/User/index');
            exit;
        }
    }

}