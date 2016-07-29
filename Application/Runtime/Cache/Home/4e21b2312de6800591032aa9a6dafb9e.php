<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>书画系统后台管理 -- 编辑权限</title>


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

<link rel="stylesheet" type="text/css" href="/demo/Public/Css/index.css" />
<script type="text/javascript">
	
	$(document).ready(function()
	{
		var function_menu = $(".function_menu0 input[name = 'function[]']");//菜单选择
		var function_menu1 = $(".function_menu1 input[type = 'checkbox']");//子菜单选择
		function_menu.click(function(){
			checkBox(this);
		});
		
		function_menu1.click(function(){
			var result = ($(this).attr('checked')=="checked")?true:false;
			if(result)
			{
				var parentPrev = $(this).parent(".function_menu1").prev();
				//alert(1);
				parentPrev.find("input[type = 'checkbox']").attr('checked',"checked");
				//alert(parent[0].innerHTML);
			}
		});
		
		$("#quanxuan").click(function(){
			var btns = $(".function_item input[type = 'checkbox']");//子菜单选择
			btns.each(function(){
				$(this).attr('checked',"checked");
			});
		});
		
		$("#fanxuan").click(function(){
			var btns = $(".function_item input[type = 'checkbox']");//子菜单选择
			var result = true;
			btns.each(function(){
				result = ($(this).attr('checked')=="checked")?true:false;
				if(!result)
				{
					$(this).attr('checked',"checked");
				}
				else
				{
					$(this).removeAttr('checked');
				}
			});
		});
	});
	
	function checkBox(e)
	{
		var result = ($(e).attr('checked')=="checked")?true:false;
		var nextBtns = $(e.parentNode).next().find("input[name = 'function[]']");
		$(nextBtns).each(function(){
			if(result)
			{
				$(this).attr('checked',"checked");
			}
			else
			{
				$(this).removeAttr('checked');
			}
		});
	}	
</script> 
</head>
<body>
<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 编辑权限</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="/demo/index.php?s=/Home/action/function_list">权限列表</a>
	    </span><?php endif; ?>
</h1>

<!-- 选项卡面板 -->
<div class="tab-div">
	<div id="tabbody_div">
    	<form action="" method="post">
	    	<div class="line">
			    <div class="input_left">权限名称：</div>
			    <div class="input_right">
			    	<input type="text" name="pow_name" value="<?php echo ($one["pow_name"]); ?>" maxlength="100"/>
			    </div>
			</div>
			<div class="line">
			    <div class="input_left">分配权限：</div>
			    <div class="input_right">
					<input type="button" id="quanxuan" value="全选"/> <input id="fanxuan" type="button" value="反选"/>
					<?php if(is_array($functions)): foreach($functions as $k=>$function): ?><div class="function_item">
				    	 	<div class="function_menu0">
				    	 		<input id="<?php echo ($function["id"]); ?>" name="function[]" type="checkbox" value="<?php echo ($function["id"]); ?>" <?php echo ($ids[$function["id"]]); ?>/><label for="<?php echo ($function["id"]); ?>"><?php echo ($function["name"]); ?></label>
				    	 	</div>
				    	 	<div class="function_menu1">
				    	 		<?php if(is_array($function["child_node"])): foreach($function["child_node"] as $k=>$function1): ?><input id="<?php echo ($function1["id"]); ?>" name="function[]" type="checkbox" value="<?php echo ($function1["id"]); ?>" <?php echo ($ids[$function1["id"]]); ?>/><label for="<?php echo ($function1["id"]); ?>"><?php echo ($function1["name"]); ?></label><?php endforeach; endif; ?>
				    		</div>
			    		</div><?php endforeach; endif; ?>
			    </div>
			</div>
			<div class="clear"></div>
			<div class="submit"> 
				<input value="保存" type="submit" name="btn_submit"/>
			</div>
			<br/>
		</form>
	</div>
</div>
</body>
</html>