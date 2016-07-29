<?php
require_once dirname(dirname(__FILE__)) . '/Common/Ext/CsvExcel.php';

class BespokeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        //检测登录
        SessionManage::checkLogin();
    }

    //排课列表
    public function index()
    {
        //查询课程
        $projectDb = D('Project');
        $projects = $projectDb->getProjectName();
        //判断是否是学校账户登录
        $user = SessionManage::getLoginUser();
        $schoo_id = $user['school_id'];

        $where = array();
        //获取当前周的开始和结束日期
        if (!empty($_REQUEST['start_day'])) {
            $timestamp = $_REQUEST['start_day'];
        } else {
            $timestamp = date("Y-m-d");
        }
        $first = 1;
        $w = date('w', strtotime($timestamp));

        //本周开始
        $week_day = date('Y-m-d', strtotime("$timestamp-" . ($w ? $w - $first : 6) . 'days'));
        //上一周开始
        $up_day = date('Y-m-d', strtotime("$week_day-7 days"));
        //下一周开始
        $next_day = date('Y-m-d', strtotime("$week_day+7 days"));
        $week_start = date('Y-m-d', strtotime("$timestamp-" . ($w ? $w - $first : 6) . 'days'));
        $week_end = date('Y-m-d', strtotime("$week_start+6 days"));
        $where[] = "yes_class.times<='" . $week_end . "' and yes_class.times>='" . $week_start . "'";

        //计算周期
        $week1 = date('m-d', strtotime($week_start));
        $week2 = date('m-d', strtotime("$week_start+1 days"));
        $week3 = date('m-d', strtotime("$week_start+2 days"));
        $week4 = date('m-d', strtotime("$week_start+3 days"));
        $week5 = date('m-d', strtotime("$week_start+4 days"));
        $week6 = date('m-d', strtotime("$week_start+5 days"));
        $week7 = date('m-d', strtotime("$week_start+6 days"));

        //每一个表格代表的日期和时间段的时间戳
        $week11 =strtotime($week_start);
        $week21 = strtotime("$week_start+1 days");
        $week31 = strtotime("$week_start+2 days");
        $week41 = strtotime("$week_start+3 days");
        $week51 = strtotime("$week_start+4 days");
        $week61 = strtotime("$week_start+5 days");
        $week71 = strtotime("$week_start+6 days");
        $weeks = array($week1, $week2, $week3, $week4, $week5, $week6, $week7);
        $weeks2 = array($week11, $week21, $week31, $week41, $week51, $week61, $week71);
//        print_r($weeks2);
        if (empty($schoo_id)) {
            //查询学校信息（下拉列表）
            $schooldb = D('School');
            $schools = $schooldb->getSchoolList();
            $this->schools = $schools;
            //选择校区
            if (!empty($_REQUEST)) {
                if (!empty($_REQUEST['school_id'])) {
                    $where['yes_school.id'] = $_REQUEST['school_id'];
                    $this->scWhere = $_REQUEST['school_id'];
                }
            } else {
                //默认下拉框的第一个校区
                $where['yes_school.id'] = '1';
                $this->scWhere = 1;
            }
        } else {
            //如果用户表，存在学校id，则值显示这个学校的信息
            $where['yes_school.id'] = $schoo_id;
        }
        if (!empty($_REQUEST['where'])) {
            $where = json_decode(urldecode($_REQUEST['where']), true);
        }
        //查询排课信息
        $classdb = D('Class');
        $lists = $classdb->getClassList($where);

        $times = array('9:00-10:30', '10:30-12:00', '13:00-14:30', '13:30-15:00', '15:00-16:30', '16:30-18:00','18:30-20:00');
        $data = array();
        foreach ($times as $key0 => $time) {
            foreach ($weeks as $key1 => $week) {
                    $class = null;
                    foreach ($lists as $key2 => $value) {
                        $wk = date('m-d', strtotime($value['times']));
                        if ($value['timeslot'] == $time && $week == $wk) {
                            $class = $value;
                        }
                    }
                    $data[$key0][$key1] = $class;
            }
        }
        $this->nowtimeInt = strtotime(date('Y-m-d'));
        if(empty($_REQUEST['school_id']))
        {
            $sc = 1;
        }
        else
        {
            $sc = $_REQUEST['school_id'];
        }
        $this->where1 = '&school_id=' .$sc ;
        $this->up_day = $up_day;
        $this->next_day = $next_day;
        $this->start_day = $timestamp;
        $this->where = urlencode(json_encode($where));
        $this->projects = $projects;
        $this->lists = $data;
        $this->weeks = $weeks;

        $this->weeks2 = $weeks2;
        $this->times = $times;
        $this->school_id = $schoo_id;
        $this->display();
    }

    //导出排课表
    public function daochuBespoke()
    {
        //判断是否是学校账户登录
        $user = SessionManage::getLoginUser();
        $schoo_id = $user['school_id'];
        $where = array();
        //获取当前周的开始和结束日期
        if (!empty($_REQUEST['start_day'])) {
            $timestamp = $_REQUEST['start_day'];
        } else {
            $timestamp = date("Y-m-d");
        }
        $first = 1;
        $w = date('w', strtotime($timestamp));
        $week_start = date('Y-m-d', strtotime("$timestamp-" . ($w ? $w - $first : 6) . 'days'));
        $week_end = date('Y-m-d', strtotime("$week_start+6 days"));
        $where[] = "yes_class.times<='" . $week_end . "' and yes_class.times>='" . $week_start . "'";
        //计算周期
        $week1 = date('m-d', strtotime($week_start));
        $week2 = date('m-d', strtotime("$week_start+1 days"));
        $week3 = date('m-d', strtotime("$week_start+2 days"));
        $week4 = date('m-d', strtotime("$week_start+3 days"));
        $week5 = date('m-d', strtotime("$week_start+4 days"));
        $week6 = date('m-d', strtotime("$week_start+5 days"));
        $week7 = date('m-d', strtotime("$week_start+6 days"));

        $weeks = array($week1, $week2, $week3, $week4, $week5, $week6, $week7);
        if (empty($schoo_id)) {
            //选择校区
            if (!empty($_REQUEST)) {
                if (!empty($_REQUEST['school_id'])) {
                    $where['yes_school.id'] = $_REQUEST['school_id'];
                } else {
                    //默认下拉框的第一个校区
                    $where['yes_school.id'] = '1';

                }
            }
        } else {
            //如果用户表，存在学校id，则值显示这个学校的信息
            $where['yes_school.id'] = $schoo_id;
        }
        if (!empty($_REQUEST['where'])) {
            $where = json_decode(urldecode($_REQUEST['where']), true);
        }

        //查询排课信息
        $classdb = D('Class');
        $lists = $classdb->getClassList($where);
        $times = array('9:00-10:30', '10:30-12:00', '13:00-14:30', '13:30-15:00', '15:00-16:30', '16:30-18:00', '18:30-20:00');
        $datas = array();
        foreach ($times as $key0 => $time) {
            foreach ($weeks as $key1 => $week) {
                $class = null;
                foreach ($lists as $key2 => $value) {
                    $wk = date('m-d', strtotime($value['times']));
                    if ($value['timeslot'] == $time && $week == $wk) {
                        $class = $value;
                    }
                }
                $datas[$key0][$key1] = $class;
            }
        }
        $projects = array();
        $titles = array("时间", "周一" . $week1, "周二" . $week2, "周三" . $week3, "周四" . $week4, "周五" . $week5, "周六" . $week6, "周日" . $week7);
        $projects[0] = $titles;

        $two = array();
        foreach ($datas as $key => $data) {
            $two[0] = $times[$key];
            $i = 1;
            foreach ($data as $project) {
                if (!empty($project)) {
                    $two[$i] = $project["project_name"] . " " . $project["counts"] . "/" . $project["number"];
                } else {
                    $two[$i] = '';
                }
                $i++;
            }
            $projects[] = $two;
        }
        Ext_CsvExcel::outputCsvHeader($projects, "排课表" . date("Y-m-d H:i:s", time()));
    }

    //添加排课
    public function addClass()
    {
        if (empty($_REQUEST['timeslot'])) {
            $message = "时间段为空！";
        } elseif (empty($_REQUEST['weeks'])) {
            $message = "日期为空！";
        } elseif (empty($_REQUEST['project_id'])) {
            $message = "课程为空！";
        } elseif (empty($_REQUEST['school_id'])) {
            $message = "学校为空！";
        } elseif (empty($_REQUEST['number'])) {
            $message = "上限人数为空！";
        }
        $name = '';
        if ($message == '') {

            $projectDb = D('Project');
            $row = $projectDb->getProjectId($_REQUEST['project_id']);

            $classDb = D('Class');
            $data = array();
            $data['school_id'] = $_REQUEST['school_id'];
            $data['project_id'] = $_REQUEST['project_id'];
            $data['timeslot'] = $_REQUEST['timeslot'];
            $data['times'] = "2016-" . $_REQUEST['weeks'];
            $str = explode('-',$_REQUEST['timeslot']);
            $data['start_timeslot'] = $data['times']." ".$str[0];
            $data['end_timeslot'] = $data['times']." ".$str[1];

            $data['number'] = $_REQUEST['number'];
            $data['create_time'] = date("Y-m-d");
            $result = $classDb->addClass($data);
            if ($result) {
                $message = "添加成功！";
                $name = $row['project_name'];
                $classDb = D('Class');
                $where = "school_id='" . $data['school_id'] . "' and project_id='" . $data['project_id'] . "' and timeslot='" . $data['timeslot'] . "' and times='" . $data['times'] . "'";
                $id = $classDb->getClassId($where);
            } else {
                $message = "1";
            }
        }
        echo json_encode(array($message, $name, $id));
    }

    //删除排课
    public function deleteClass()
    {
        $classDb = D('Class');
        $result = $classDb->deleteClass($_REQUEST['id']);
        if ($result) {
            $message = "删除成功！";
        } else {
            $message = "删除失败！";
        }
        echo $message;
    }

    //根据排课id  查询学员
    public function getUsersClassId()
    {
        if ($_REQUEST['id']) {
            $bespokeDb = D('Bespoke');
            $data = $bespokeDb->getBespokeList($_REQUEST['id']);
            echo json_encode($data);
        }
    }

    //给某个排课，添加学员
    public function addBespoke()
    {
        if (empty($_REQUEST['phone']))
        {
            $message = '手机号不存在！';
        }
        elseif (empty($_REQUEST['project_id']))
        {
            $message = '课程不存在！';
        }
        if ($message == '')
        {
            //判断添加的学员是否存在用户表
            $appDb = D('App');
            $app = $appDb->getAppPhone($_REQUEST['phone']);
            if (!empty($app))
            {
                $bespokeDb = D('Bespoke');
                $orderDb = D('Order');
                //判断学员是否购买过该课程
                $whereor = "app_id='" . $app['id'] . "' and order_status=1 and project_id='" . $_REQUEST['project_id'] . "'";
                $count = $orderDb->getOrderCount($whereor);
                if ($count >= 1)
                {
                    //判断添加的学员是否已经完成排课
                    $where = "app_id='" . $app['id'] . "' and project_id='" . $_REQUEST['project_id'] . "'";
                    $counts = $bespokeDb->getBespokeAppCount($where);

                    if ($counts < 1)
                    {
                        $order_id = $orderDb->getOrderIdWhere($whereor);
                        $data = array();
                        $data['app_id'] = $app['id'];
                        $data['class_id'] = $_REQUEST['class_id'];
                        $data['project_id'] = $_REQUEST['project_id'];
                        $data['order_id'] = $order_id;
                        $data['create_time'] = date("Y-m-d H:i:s");
                        $result = $bespokeDb->addBespokeApp($data);
                        if ($result)
                        {
                            $nickname = $app['nickname'];
                            $app_id = $app['id'];
                            $message = '添加成功！';
                        }
                        else
                        {
                            $message = '添加失败！';
                        }
                    }
                    else
                    {
                        $message = '学员已经完成排课！';
                    }
                }
                else
                {
                    $message = '您添加的学员还没有购买课程！';
                }
            }
            else
            {
                $message = '您添加的学员不存在！';
            }
        }
        echo json_encode(array($message, $nickname, $app_id));
    }

    //删除学员排课
    public function deleteBespokeApp()
    {
        $bespokeDb = D('Bespoke');
        $where = "class_id='" . $_POST['class_id'] . "' and app_id='" . $_POST['app_id'] . "'";
        $result = $bespokeDb->deleteBespokeApp($where);
        if ($result)
        {
            $message = "删除成功！";
        }
        else
        {
            $message = "删除失败！";
        }
        echo $message;
    }



}