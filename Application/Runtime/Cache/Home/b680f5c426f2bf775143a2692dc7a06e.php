<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>9橙网系统后台管理中心 -- 权限列表</title>


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


<script type="text/javascript">
  
	//全选，全不选
	var allSelect = function () 
	{			
        $("input[name='checkname[]']").each(function()
		{
			
			if($(this).attr("checked") != "checked")
			{
                $(this).attr("checked", "checked");
			}
			else
			{
                $(this).removeAttr("checked");
			}
		});

	}

	//反选
	function otherSelect() {
	
		$(":checkbox").each(function () {
			if ($(this).attr("checked") == "checked") {
				$(this).removeAttr("checked");
			}
			else {
				$(this).attr("checked", "checked");
			}
		});
	}
	function delConfirm(url)
	{		
		msg = "确定要删除？"
		if(confirm(msg))
		{
			location.href=url;
		}
	}
	
</script>
</head>
<body>
<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 权限列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>

<!-- 列表样式     -->
<form action="/demo/index.php?s=/Home/action/pow_delete">
	<input name="delIds" type="hidden"/>
    <div class="data-list" >
        <table cellspacing="1" cellpadding="3">
        	<thead>
        		<tr>
        			<td><input type="checkbox" id="checkall" name="checkbox" onClick="allSelect()" value="全选" />编号</td>
        			<td>权限名称</td>
        			<th>操作</th>
				</tr>
			</thead>
            <tbody>
                <?php if(empty($pows["list"])): ?><tr>
                    <td class="no-records" colspan="4" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
                </tr> 
	            <?php else: ?>
                <?php if(is_array($pows["list"])): foreach($pows["list"] as $k=>$pow): ?><tr class="tr<?php echo ($k%2); ?>">
				      	<td><input type="checkbox" id="Checkbox<?php echo ($k); ?>" name="checkname[]" value="<?php echo ($pow["id"]); ?>" />
				      		<?php echo ($pageCount*($currentPage-1)+$k+1); ?></td>
				      	<td><a href="/demo/index.php?s=/Home/action/pow_opt/pow_id/<?php echo ($pow["id"]); ?>"><?php echo ($pow["pow_name"]); ?></a></td>
				      	<td>
					      <a onclick="delConfirm('/demo/index.php?s=/Home/action/pow_delete?pow_id=<?php echo ($pow["id"]); ?>')">
					      <img src="/demo/Public/images/icon_del.gif" />
					      </a>
					      <a href="/demo/index.php?s=/Home/action/pow_opt&pow_id=<?php echo ($pow["id"]); ?>" >
					      <img src="/demo/Public/images/icon_edit.gif" />
					      </a>
					  	</td>
				    </tr><?php endforeach; endif; ?>
                <tr><td></td><td colspan="3"><?php echo ($pows["page"]); ?></td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <div>
        <input class="button" type="submit" value="删除" onclick="return deleteData('checkname[]',this)"/>
    </div>
</form>
</body>
</html>