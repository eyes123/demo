<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <title><?php echo C('siteTitle');?></title>
        <link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
    </head>
    
    <body>
    	<!-- 顶部页面导航 -->
		<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 欢迎</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>
    	
        你好,<?php echo ($name); ?>!
    </body>
</html>