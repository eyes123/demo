<?php
class ProjectController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        import('Think.Upload');
        SessionManage::checkLogin();
    }

    //课程列表
    public function index()
    {
        $prMD = D('Project');
        $count = $prMD->getProjectCount();
        $limit     = $this->sepePage($count,$_REQUEST);
        $lists = $prMD->getProjectList($limit);
        $this->lists = $lists;
        $this->display();
    }

    //添加课程
    public function add()
    {
        $prMD = D('Project');
        $rows = $prMD->getProjectName();
        if(!empty($_REQUEST))
        {
            $message = '';
            if(empty($_REQUEST['project_name']))
            {
                $message = '课程名称不能为空！';
            }
            elseif(empty($_REQUEST['price']))
            {
                $message = '课程价格不能为空！';
            }
            if($message=='')
            {
                $data = array();
                $data['project_name'] = $_REQUEST['project_name'];
                $data['price'] = $_REQUEST['price'];
                $data['content'] = $_REQUEST['content'];
                $data['uptime'] = $_REQUEST['uptime'];
                $data['create_time'] = date("Y-m-d H:i:s");
                $result = $prMD->addProject($data);
                myMessage2($message,__MODULE__.'/Project/index',__MODULE__.'/Project/add',$result);
            }
        }
        $this->rows = $rows;
        $this->pic_dir = C('web_root').C('pic_dir');
        $this->display();
    }

    //原始邀请单数
    public function yqds()
    {
        $orderDb = D('Order');
        $where = "yes_order.project_id='".$_REQUEST['project_id']."' and yes_order.invi_openid=0 and yes_order.order_status=1";
        $rows = $orderDb->getOrderByProjectId($where);

        $this->rows = $rows;
        $this->display();
    }

    //上传图片
    public function adds()
    {
        $this->pic_dir = C('web_root').C('pic_dir');
        $this->display();
    }

    //通过ajax上传图片
    public function uploadImgAjax()
    {
        $fileBtnName = 'file';
        if(isset($_GET['file']))
        {
            $fileBtnName = trim($_GET['file']);
            if(empty($fileBtnName))
            {
                $fileBtnName = 'file';
            }
        }
        $name = $this->uploadByName($fileBtnName);
        $url = C('web_root').C('pic_dir').$name;
        $module = __MODULE__;
        $public = __ROOT__.'/Public';
        $sessionArray = session('picArr');
        $id = 1;
        if(!empty($sessionArray))
        {
            $id = array_push($sessionArray, $name);
        }
        else
        {
            $sessionArray = array($name);
        }
        session('picArr',null);
        session('picArr',$sessionArray);
        $str = <<<EOD
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="$public/Js/Jquery.js"></script>
		<script type="text/javascript">

		$(document).ready(function()
		{
			alert('上传成功');
		    var obj = $('.displayphoto', parent.document);
			obj.append('<div id="uploadImg$id" style="position:relative" class="upload_img_item" ><img width="100px" height="100px" src="$url"  alt="产品图片$id" />
			<a class="delete_btn" target="uploadframe" style="position:absolute;top:0px;right:0px;display:none;" href="$module/Advertisement/deleteImg?id=$id" title="删除">
			<img src="$public/images/icon_del.gif" alt="删除"/>
			</a>
			</div>');

			obj.find('.upload_img_item').mouseover(function()
			{
				$(this).find('.delete_btn').css('display','block');
			});
			obj.find('.upload_img_item').mouseout(function()
			{
				$(this).find('.delete_btn').css('display','none');
			});
		});
		</script>
EOD;
        echo $str;
    }

    //通过ajax上传图片
    public function newUploadImgAjax()
    {
        $pre = '';
        if(isset($_REQUEST['pre']))
        {
            $pre = trim($_REQUEST['pre']);
        }
        $fileBtnName = $pre.'_file';
        $className = $pre."_displayphoto";

        $message = '';
        if(!isset($_FILES[$fileBtnName]))
        {
            $message = '上传图片的参数有误';
        }
        else
        {
            $data = $this->uploadByName2($fileBtnName);
            $message = $data["message"];
            $name = $data["path"];
            if($message=='')
            {
                $url = C('web_root').C('pic_dir').$name;
                $sessionArray = array();
                if(!empty($_POST[$pre]))
                {
                    $sessionArray = explode(';', $_POST[$pre]) ;
                }
                $id	= 1;
                if(!empty($sessionArray))
                {
                    $id = array_push($sessionArray, $name);
                }
                else
                {
                    $sessionArray = array($name);
                }
            }
        }
        $public = __ROOT__.'/Public';
        $module = __MODULE__;
        $divId	= $pre.'_Img'.$id;
        $one	= isset($_GET['one'])?trim($_GET['one']):"n";
        $value	= '';
        if(!empty($sessionArray))
        {
            $value = implode(';', $sessionArray);
        }
        if($message=='')
        {
            if(!empty($_GET["type"]))
            {
                if(!empty($name))
                {
                    echo $name;
                }
                exit;
            }
        }
        $str = <<<EOD
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="$public/Js/Jquery.js"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
			if('$message')
			{
				alert('$message');
			}
			else
			{
				alert('上传成功');
			    var obj = $('.$className', parent.document);
			  	if('$one'=='y')
			  	{
			  		obj.html('<div id="$divId" style="position:relative" class="upload_img_item" ><img width="100px" height="100px" src="$url"  alt="图片$id" /></div>');
			  	}
			  	else
			  	{
			  		obj.append('<div id="$divId" style="position:relative" class="upload_img_item" ><img width="100px" height="100px" src="$url"  alt="图片$id" /><a class="delete_btn" style="position:absolute;top:0px;right:0px;display:none;" onclick="newDeleteImg(\'$pre\',$id)" title="删除"><img src="$public/images/icon_del.gif" alt="删除"/></a></div>');
					obj.find('.upload_img_item').mouseover(function()
					{
						$(this).find('.delete_btn').css('display','block');
					});
					obj.find('.upload_img_item').mouseout(function()
					{
						$(this).find('.delete_btn').css('display','none');
					});
				}
			  	$("input[name='$pre']", parent.document).val('$value');
			  	$("#hf_$pre", parent.document).val('$value');
			}
		});
		</script>
EOD;
        echo $str;
    }

    //通过ajax删除图片
    public function newDeleteImg()
    {
        if(!empty($_REQUEST['id']))
        {
            $pre = '';
            if(isset($_GET['pre']))
            {
                $pre = trim($_GET['pre']);
            }
            $public = __ROOT__.'/Public/';
            $id = $_REQUEST['id'];

            $pics = explode(';', $_POST[$pre]) ;
            $sid = $id-1;
            $path = getPublicImgPath().$pics["$sid"];

            unset($pics[$sid]);

            $value = '';
            if(!empty($pics))
            {
                $value = implode(';', $pics);
            }

            $divId = $pre.'_Img'.$id;
            $className = $pre."_displayphoto";
            $str = <<<EOD

			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script type="text/javascript" src="$public/Js/Jquery.js"></script>
			<script type="text/javascript">

			$(document).ready(function()
			{
			    var obj = $('.$className', parent.document);
			    obj.children('#$divId').remove();
			    obj.find('.upload_img_item').mouseover(function()
				{
					$(this).find('.delete_btn').css('display','block');
				});

				obj.find('.upload_img_item').mouseout(function()
				{
					$(this).find('.delete_btn').css('display','none');
				});
			    $("input[name='$pre']", parent.document).val('$value');
			});
			</script>
EOD;
            echo $str;
        }
    }

    //通过ajax删除图片
    public function deleteImg()
    {
        if(!empty($_REQUEST['id']))
        {
            $public = __ROOT__.'/Public/';
            $id = $_REQUEST['id'];

            $pics = session('picArr');
            $sid = $id-1;
            $path = $public.'Upload/Img/'.$pics["$sid"];
            $rows = unlink($path);
            unset($pics["$sid"]);
            session('picArr',null);
            session('picArr',$pics);
            $str = <<<EOD

			<script type="text/javascript" src="$public/Js/Jquery.js"></script>
			<script type="text/javascript">

			$(document).ready(function()
			{
			    var obj = $('.displayphoto', parent.document);

			    obj.children('#uploadImg$id').remove();
			});
			</script>

EOD;
            echo $str;
        }
    }

    //通过ajax上传图片
    public function uploadImgAjax2()
    {
        $sessionPicArr = 'shoujiPicArr';
        $file = $_FILES['shoujiFile'];
        //print_r($file);exit;
        $name = $this->upload(array($file));

        //echo '$name:'.$name;exit;
        $url = C('web_root').C('pic_dir').$name;
// 		echo ' <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
// 				<script type="text/javascript">
// 			alert("'.$url.'");
// 		</script>';
        //$module = __MODULE__;
        $public = __ROOT__.'/Public';

        $sessionArray = session($sessionPicArr);

        $id = 1;
        if(!empty($sessionArray))
        {
            $id = array_push($sessionArray, $name);
        }
        else
        {
            $sessionArray = array($name);
        }
        //session($sessionPicArr,null);
        session($sessionPicArr,$sessionArray);

        $str = <<<EOD

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="$public/Js/Jquery.js"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
			alert('上传成功');
		    var obj = $('.shouji_displayphoto', parent.document);
			obj.html('<div style="position:relative" class="upload_img_item" >
			<img width="100px" height="100px" src="$url"  alt="手机图片" />
			</div>');

		});
		</script>

EOD;
        echo $str;
    }

    //通过ajax删除手机图片
    public function deleteShoujiImg()
    {
        $type = 'shoujiImg';
        $sessionPicArr = 'shoujiPicArr';

        $public = __ROOT__.'/Public/';

        $pics = session($sessionPicArr);

        foreach ($pics as $key=>$pic)
        {
            $path = $public.'Upload/Img/'.$pic;
            $rows = unlink($path);
            unset($pics[$key]);
        }
        session($sessionPicArr,null);
        //session($sessionPicArr,$pics);

        $str = <<<EOD

		<script type="text/javascript" src="$public/Js/Jquery.js"></script>
		<script type="text/javascript">

		$(document).ready(function()
		{
		    var obj = $('.shouji_displayphoto', parent.document);
		    obj.html('');
		});
		</script>

EOD;
        echo $str;
    }

    /**
     * 上传图片函数
     */
    private function uploadByName($name='file')
    {

        $files = array($_FILES[$name]);
        $fileName = '';
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './Public/Upload/Img/',
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );

        $upload = new Upload($config);// 实例化上传类

        $fileInfo = $upload->upload($files);

        if(!$fileInfo)
        {
            $this->error($upload->getError());
        }
        else
        {
            foreach ($fileInfo as $file)
            {
                $fileName .= $file['savepath'].$file['savename'];
                $fileName .= ';';
            }
        }
        return substr($fileName, 0,-1);
    }

    /**
     * 上传图片函数
     */
    private function uploadByName2($name='file')
    {
        $message = '';
        $path = '';

        $files = array($_FILES[$name]);
        $fileName = '';
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './Public/Upload/Img/',
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );

        $upload = new Upload($config);// 实例化上传类

        $fileInfo = $upload->upload($files);

        if(!$fileInfo)
        {
            $message = $upload->getError();
        }
        else
        {
            foreach ($fileInfo as $file)
            {
                $fileName .= $file['savepath'].$file['savename'];
                $fileName .= ';';
            }
            $path = substr($fileName, 0,-1);
        }
        $data = array('path'=>$path,'message'=>$message);
        return $data;
    }

    /**
     * 上传图片函数
     */
    private function upload($files=null)
    {
        if($files==null)
        {
            $files = array($_FILES['file']);
        }
        $fileName = '';
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './Public/Upload/Img/',
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new Upload($config);// 实例化上传类

        $fileInfo = $upload->upload($files);

        if(!$fileInfo)
        {
            $this->error($upload->getError());
        }
        else
        {
            foreach ($fileInfo as $file)
            {
                $fileName .= $file['savepath'].$file['savename'];
                $fileName .= ';';
            }
        }
        return substr($fileName, 0,-1);
    }
}