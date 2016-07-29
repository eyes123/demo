<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta name="Description" content="待预约-待预约-待预约" />
    <meta name="Keywords" content="待预约-待预约-待预约" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>待预约</title>
    <script>
        if (navigator.userAgent.toLowerCase().match(/ipad/i) == "ipad")
        {
            document.write('<meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1">');
        }
        else if (/Android/.test(navigator.userAgent))
        {
            document.write('<meta name="viewport" content="width=640,maximum-scale=0.5,minimum-scale=0.5">');
        }
        else
        {
            document.write('<meta name="viewport" content="target-densitydpi=device-dpi,width=640,user-scalable=no">');
        }
    </script>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/style.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/common.css" />
    <script type="text/javascript" src="/demo/Public/Js/bespoke/jquery-1.8.2.min.js"></script>
</head>
<body>
<div class="head_con">
    <ul class="nav">
        <a href="/demo/index.php?s=/Mobile/Bespoke/etc_appointment" class="yy"><li >待预约 </li></a>
        <a href="/demo/index.php?s=/Mobile/Bespoke/ok_appointment" ><li >已预约 </li></a>
        <a href="/demo/index.php?s=/Mobile/Bespoke/complete" ><li >已完成 </li></a>
    </ul>
</div>
<div class="etc_main">
    <div class="etc_con">
        <div class="etc_top">

            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><p class="kec"><?php echo ($row["project_name"]); ?></p>
            <a  href="/demo/index.php?s=/Mobile/Bespoke/index&project_id=<?php echo ($row["project_id"]); ?>" class="yuy"><p>预约</p></a><?php endforeach; endif; ?>

        </div>
    </div>
</div>
</body>
</html>