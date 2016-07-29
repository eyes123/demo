<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>书画系统后台管理</title>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/yz.css" />
    <script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/diashow.css" />
    <script type="text/javascript" src="/demo/Public/Js/diashow/diashow.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        var module = "/demo/index.php?s=/Home";
        $(document).ready(function() {

            $('.theme-poptit .close').click(function(){
                $('.theme-popover-mask').fadeOut(100);
                $('.theme-popover').slideUp(200);
            })

        })
        function show_box(id)
        {

            $('#theme-popover-mask_'+id).fadeIn(100);
            $('#theme-popover_'+id).slideDown(200);
        }
        function yz(id)
        {
            var qm = $("#quanma_"+id).val();
            var mi = $("#mima_"+id).val();

            if(id)
            {
                $.post("/demo/index.php?s=/Home/Coupon/yzCoupon",{id:id,qm:qm,mi:mi},

                    function(data)
                    {
                      var obj = JSON.parse(data);

                        if(obj[0]==0)
                        {
                             $('#yz_'+id).html(obj[1]+"验证");

                            $('#theme-popover-mask_'+id).fadeOut(100);
                            $('#theme-popover_'+id).slideUp(200);
                        }
                      else
                        {
                          showMessage(obj[0]);
                        }
                    }
                );
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
    <span class="nav_list1">- 券码列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>
<!-- 搜索模块 -->
<div class="search_div">
    <form action="">
        <img width="26" height="22" border="0" alt="search" src="/demo/Public/images/icon_search.gif" />
        手机号：
        <input type="text" name="phone" value="<?php echo ($phoneWhere); ?>" />
        日期：
        <input type="text" size="15" name="start_time" value="<?php echo ($startWhere); ?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" /><bold>~</bold>
        <input type="text" size="15" name="end_time" value="<?php echo ($endWhere); ?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
        <input style="margin-left:35px;" class="button" type="submit" name="submit" id="yz" value="搜索" />
    </form>
</div>
<div>
    <form method="post" action="/demo/index.php?s=/Home/Coupon/daochuindex" name="form_daochu">
        <input type='hidden' name="start_time" value="<?php echo ($startWhere); ?>">
        <input type='hidden' name="end_time" value="<?php echo ($endWhere); ?>">
        <input type='hidden' name="phone" value="<?php echo ($phoneWhere); ?>">
        <input type="button" name="btn_output" value="导出" class="submit" onclick="document.form_daochu.submit();"/>
    </form>
</div>
<!-- 列表样式 -->
<form action="" method="get">
    <div class="data-list" >
      <?php if(is_array($coupon)): foreach($coupon as $k=>$list): ?><div class="theme-popover" id="theme-popover_<?php echo ($list["id"]); ?>">
        <div class="theme-poptit">
          <a href="javascript:;" title="关闭" class="close">×</a>
        </div>
        <div class="theme-popbod dform">
          <ol>
            <li><strong>券码：</strong><input class="ipt" id="quanma_<?php echo ($list["id"]); ?>" type="text" name="quanma" value="" size="20" /></li>
            <li><strong>密码：</strong><input class="ipt" id="mima_<?php echo ($list["id"]); ?>" type="password" name="password"  value="" size="20" /></li>
            <li><input class="btn btn-primary" type="button" name="submit" onclick="yz('<?php echo ($list["id"]); ?>')" value="验证" /></li>
          </ol>
        </div>
      </div><?php endforeach; endif; ?>
        <table cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>券码类型</th>
                <th>券码面值</th>
                <th>用户名</th>
                <th>手机号</th>
                <th>领取时间</th>
                <th>验证时间</th>
                <th>券码来源</th>
                <th>验证状态</th>
            </tr>
            <?php if(empty($coupon)): ?><tr>
                    <td class="no-records" colspan="8" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
                </tr>
                <?php else: ?>
                <?php if(is_array($coupon)): foreach($coupon as $k=>$list): ?><div id="theme-popover-mask_<?php echo ($list["id"]); ?>" class="theme-popover-mask"></div>
                    <tr class="tr<?php echo ($k%2); ?>">
                        <td><?php if($list['coupon_type'] == '1'): ?>课程码<?php else: ?>红包码<?php endif; ?></td>
                        <td><?php echo ($list["coupon_price"]); ?></td>
                        <td><?php echo ($list["nickname"]); ?></td>
                        <td ><?php echo ($list["phone"]); ?></td>
                        <td><?php echo ($list["receive_time"]); ?></td>
                        <td><?php if($list['veri_time'] == null): ?>未消费<?php else: echo ($list["veri_time"]); endif; ?></td>
                        <td><?php echo ($list["project_name"]); ?></td>
                          <td id="yz_<?php echo ($list["id"]); ?>">
                            <?php if($list['veri_id'] == 0): ?><span class="yanzheng" onclick="show_box('<?php echo ($list["id"]); ?>')">验证</span>
                              <?php else: ?>
                              <?php echo ($list['name']); ?>验证<?php endif; ?>
                          </td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="8"><?php echo ($page); ?></td>
                </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
</body>
</htm