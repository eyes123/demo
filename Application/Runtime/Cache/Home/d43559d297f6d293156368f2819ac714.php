<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>书画系统后台管理</title>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/yz.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/diashow.css" />
    <script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/diashow/diashow.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        var module = "/demo/index.php?s=/Home";

    </script>
</head>
<body>
<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 课程列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>
<!-- 搜索模块 -->
<!--<div>-->
    <!--<form method="post" action="/demo/index.php?s=/Home/Coupon/daochuindex" name="form_daochu">-->
        <!--<input type='hidden' name="start_time" value="<?php echo ($startWhere); ?>">-->
        <!--<input type='hidden' name="end_time" value="<?php echo ($endWhere); ?>">-->
        <!--<input type='hidden' name="phone" value="<?php echo ($phoneWhere); ?>">-->
        <!--<input type="button" name="btn_output" value="导出" class="submit" onclick="document.form_daochu.submit();"/>-->
    <!--</form>-->
<!--</div>-->
<!-- 列表样式 -->
<form action="" method="get">
    <div class="data-list" >

        <table cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>序号</th>
                <th>课程id</th>
                <th>名称</th>
                <th>内容</th>
                <th>上线时间</th>
                <th>原始成单</th>
                <th>新增用户数</th>
                <th>总订单数</th>
            </tr>
            <?php if(empty($lists)): ?><tr>
                    <td class="no-records" colspan="7" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
                </tr>
                <?php else: ?>
                <?php if(is_array($lists)): foreach($lists as $k=>$list): ?><div id="theme-popover-mask_<?php echo ($list["id"]); ?>" class="theme-popover-mask"></div>
                    <tr class="tr<?php echo ($k%2); ?>">
                        <td><?php echo ($pageCount*($currentPage-1)+$k+1); ?></td>
                        <td><?php echo ($list["id"]); ?></td>
                        <td><?php echo ($list["project_name"]); ?></td>
                        <td><?php echo ($list["content"]); ?></td>
                        <td ><?php echo ($list["uptime"]); ?></td>
                        <td><a href="/demo/index.php?s=/Home/Project/yqds&project_id=<?php echo ($list["id"]); ?>"><?php echo ($list["w_number"]); ?></a></td>
                        <td><?php echo ($list["app_number"]); ?></td>
                        <td><?php echo ($list["order_number"]); ?></td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="7"><?php echo ($page); ?></td>
                </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
</body>
</htm