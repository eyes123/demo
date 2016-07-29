<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>左侧菜单</title>
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/index.css" />
<script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>
</head>
<body>

<script type="text/javascript">
function navList()
{	
	var nav = $("#nav");
	nav.find(".item").click(function()
	{
		var subItem = $(this).siblings(".subitem");
		
		if($(this).parent().hasClass("selected"))
		{
			subItem.slideDown(600);
			$(this).parent().removeClass("selected");
		}
		else
		{
			subItem.slideUp(600);
			$(this).parent().addClass("selected");
		}
	});
	
	var nav = $("#nav");
	nav.find("p").click(function()
	{
	    nav.find("p").removeClass("bold");
	    $(this).addClass("bold");
	});
}

</script>
<div>
	<ul id="nav">
        <!--<li>-->
        <!--<a class="item" target="main" >用户管理</a>-->
        <!--<div class="subitem" >-->
            <!--<p><a href="/demo/Home/App/index"  target="main" >用户列表</a></p>-->
        <!--</div>-->
    <!--</li>-->
        <!--<li>-->
            <!--<a class="item" target="main" >订单管理</a>-->
            <!--<div class="subitem" >-->
                <!--<p><a href="/demo/Home/Order/index"  target="main" >订单列表</a></p>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li>-->
            <!--<a class="item" target="main" >券码管理</a>-->
            <!--<div class="subitem" >-->
                <!--<p><a href="/demo/Home/Coupon/index"  target="main" >券码列表</a></p>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li>-
            <!--<a class="item" target="main" >券码管理</a>-->
            <!--<div class="subitem" >-->
                <!--<p><a href="/demo/Home/Action/index"  target="main" >券码列表</a></p>-->
            <!--</div>-->
        <!--</li>-->
        <?php if(is_array($menuList)): foreach($menuList as $key=>$one): ?><li>
                <a class="item" target="main" ><?php echo ($one["name"]); ?></a>
                <div class="subitem" >
                    <?php if(is_array($one["child_node"])): foreach($one["child_node"] as $key=>$function): ?><p><a href="/demo/<?php echo ($function["path"]); ?>"  target="main" ><?php echo ($function["name"]); ?></a></p><?php endforeach; endif; ?>
                </div>
            </li><?php endforeach; endif; ?>
	</ul>
</div>

<script>navList();</script>
</body>
</html>