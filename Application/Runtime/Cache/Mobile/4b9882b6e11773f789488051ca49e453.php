<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="Description" content="已预约-已预约-已预约" />
    <meta name="Keywords" content="已预约-已预约-已预约" />
    <title>已预约</title>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/style.css?20160524" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/common.css" />
    <script type="text/javascript" src="/demo/Public/Js/bespoke/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/storage.js?2015051902"></script>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/white.css?20160518" />
    <script type="text/javascript" src="/demo/Public/Js/diashow/diashow2.js?20160518"></script>
    <script>
        if (navigator.userAgent.toLowerCase().match(/ipad/i) == "ipad") {
            document.write('<meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1">');
        } else if (/Android/.test(navigator.userAgent)) {
            document.write('<meta name="viewport" content="width=640,maximum-scale=0.5,minimum-scale=0.5">');
        } else {
            document.write('<meta name="viewport" content="target-densitydpi=device-dpi,width=640,user-scalable=no">');
        }
        //返回json数组
        function getArrayByJson(json) {
            var obj = new Function("return " + json)();
            return obj;
        }

        function upyuyue(bespokeId,Times,projectId)
        {
            $.post("/demo/index.php?s=/Mobile/Bespoke/updateBespoke",{bespokeId:bespokeId,Times:Times,projectId:projectId},function(jsonstr)
            {
                //清空浏览器的值
                sessionStorage.removeItem('schoolID');
                sessionStorage.removeItem('timeID');

                var data = getArrayByJson(jsonstr);
                if(data[0]=='0')
                {
                    window.location.href = "/demo/index.php?s=/Mobile/Bespoke/index&bespokeId="+data[1]+"&project_id="+data[2];
                }
                else
                {
                    //alert(data[1]);
                    showMessage(data[0],'',1000);
                }
            });
        }
    </script>

</head>
<body>
<div class="head_con">
    <ul class="nav">
        <a href="/demo/index.php?s=/Mobile/Bespoke/etc_appointment"><li >待预约 </li></a>
        <a href="/demo/index.php?s=/Mobile/Bespoke/ok_appointment"  class="yy"><li >已预约 </li></a>
        <a href="/demo/index.php?s=/Mobile/Bespoke/complete" ><li >已完成 </li></a>
    </ul>
</div>
<div class="com_main">
    <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><div class="con">
        <div class="con_top">
            <p class="time"><?php echo ($row["times"]); ?>&nbsp;&nbsp;&nbsp; <?php echo ($row["timeslot"]); ?></p>
            <a class="campus"><p ><?php echo ($row["school_name"]); ?></p></a>
        </div>
        <div class="con_bot">
            <p class="rank_cur"><?php echo ($row["project_name"]); ?></p>
            <a class="complete2"><p onclick="upyuyue('<?php echo ($row["bespoke_id"]); ?>','<?php echo ($row["times"]); ?>','<?php echo ($row["project_id"]); ?>')">重新预约</p></a>
        </div>
    </div><?php endforeach; endif; ?>
</div>
</body>
</html>