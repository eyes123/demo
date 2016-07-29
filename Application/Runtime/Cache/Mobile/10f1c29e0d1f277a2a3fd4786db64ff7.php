<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta name="Description" content="已完成-已完成-已完成" />
    <meta name="Keywords" content="已完成-已完成-已完成" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>已完成</title>
    <script>
        if (navigator.userAgent.toLowerCase().match(/ipad/i) == "ipad") {
            document.write('<meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1">');
        } else if (/Android/.test(navigator.userAgent)) {
            document.write('<meta name="viewport" content="width=640,maximum-scale=0.5,minimum-scale=0.5">');
        } else {
            document.write('<meta name="viewport" content="target-densitydpi=device-dpi,width=640,user-scalable=no">');
        }
    </script>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/style.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/common.css" />
    <script type="text/javascript" src="/demo/Public/Js/bespoke/jquery-1.8.2.min.js"></script>
</head>
<body class="com_body">
<div class="head_con">
    <ul class="nav">
        <a href="/demo/index.php?s=/Mobile/Bespoke/etc_appointment" ><li >待预约 </li></a>
        <a href="/demo/index.php?s=/Mobile/Bespoke/ok_appointment" ><li >已预约 </li></a>
        <a href="/demo/index.php?s=/Mobile/Bespoke/complete" class="yy" ><li >已完成 </li></a>
    </ul>
</div>
<div class="com_main">
    <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><div class="con">
            <div class="con_top">
                <p class="time"><?php echo ($row["times"]); ?>&nbsp;&nbsp;&nbsp; <?php echo ($row["timeslot"]); ?></p>
                <a class="campus"><p><?php echo ($row["school_name"]); ?></p></a>
            </div>
            <div class="con_bot">
                <p class="rank_cur"><?php echo ($row["project_name"]); ?></p>
                <a class="complete1"><p >已完成</p></a>
            </div>
        </div><?php endforeach; endif; ?>

</div>
</body>
</html>