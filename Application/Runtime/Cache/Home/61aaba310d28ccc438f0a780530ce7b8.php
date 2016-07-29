<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>添加课程</title>

<link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />

<link rel="stylesheet" type="text/css" href="/demo/Public/Css/tab.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/addAdvertisement.css" />

<link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/diashow.css" />
<script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/demo/Public/Js/diashow/diashow.js"></script>
<script type="text/javascript">

	var module = "/demo/index.php?s=/Home";
	$(document).ready(function()
	{
		//alert(1);
		var message = '<?php echo ($message); ?>';
		if(message!='')
		{
			showMessage('<?php echo ($message); ?>','<?php echo ($url); ?>','<?php echo ($time); ?>');
		}
	});
</script> 


<script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/editor/kindeditor.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/editor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/category.css" />
    <script type="text/javascript">
        /*** 富文本编辑器 Start **/
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name="content"]', {
                width: "600px",
                height: "200px",
            });
        });
        /*** 富文本编辑器 End **/
    </script>
</head>
<body>
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 添加课程</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">添加课程</a>
	    </span><?php endif; ?>
</h1>

<div class="form_div">
<form enctype="multipart/form-data"  method="post" action="" name="form1">
<input type="hidden" value="addUser" name="act" />
<table>

    <tr>
        <td class="label">课程名称：</td>
        <td class="value">
        <input type="text" name="project_name" value="<?php echo ($one["project_name"]); ?>"/>
        </td>
    </tr>
    <tr>
        <td class="label">课程价格：</td>
        <td class="value">
            <input type="text" name="price" value="<?php echo ($one["price"]); ?>"/>
        </td>
    </tr>
    <tr>
        <td class="label">上线时间：</td>
        <td class="value">
            <input type="text" name="uptime" value="<?php echo ($one["uptime"]); ?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
        </td>
    </tr>
    <tr>
        <td class="label">课程内容:</td>
        <td class="value">
            <textarea  type="text"  name="content"><?php echo ($one["content"]); ?></textarea>
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align:left;">
            <input class="button" type="submit" name="submit" value="添加">
            <input class="button" type="reset" value="重置"/>
        </td>
    </tr>
</table>
</form>
</div>

</body>
</html>