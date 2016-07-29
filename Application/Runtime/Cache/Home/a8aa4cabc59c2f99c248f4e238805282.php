<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>9橙网系统后台管理中心 -- 功能列表</title>

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

<link rel="stylesheet" type="text/css" href="/demo/Public/Js/system/css/style.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Js/artDialog/skins/default.css" />
<script type="text/javascript" src="/demo/Public/Js/artDialog/artDialog.js"></script>
<script type="text/javascript" src="/demo/Public/Js/system/js/tree.js"></script>
</head>
<body>
<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 功能列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>

<div id="tree">
  <form enctype="application/x-www-form-urlencoded" method="post" name="form1">
    <input type="hidden" value="" name="hf_id" id="hf_id">
    <?php echo ($str); ?>
    <br/>
    <div class="addroot">
      <input type="button" value="添加" name="addroot" id="addroot"/>
    </div>
  </form>
</div>
</body>
</html>