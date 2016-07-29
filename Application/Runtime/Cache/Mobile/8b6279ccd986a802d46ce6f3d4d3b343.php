<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="Description" content="预约-预约-预约" />
    <meta name="Keywords" content="预约-预约-预约" />
    <title>预约</title>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/style.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespoke/common.css" />
    <script type="text/javascript" src="/demo/Public/Js/bespoke/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/bespoke/main.js?2015052303"></script>
    <script type="text/javascript" src="/demo/Public/Js/layer.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/storage.js?2015051902"></script>

  <link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/white.css?20160519" />

  <script type="text/javascript" src="/demo/Public/Js/diashow/diashow2.js?20160518"></script>
    <script type="text/javascript">

        if (navigator.userAgent.toLowerCase().match(/ipad/i) == "ipad") {
            document.write('<meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1">');
        } else if (/Android/.test(navigator.userAgent)) {
            document.write('<meta name="viewport" content="width=640,maximum-scale=0.5,minimum-scale=0.5">');
        } else {
            document.write('<meta name="viewport" content="target-densitydpi=device-dpi,width=640,user-scalable=no">');
        }
        $(document).ready(function (){

            var school = getStorageValue('schoolID');
            var time = getStorageValue('timeID');
            var cs=1;
            if(school!=null && time!=null)
            {
                fuz(school,cs);
            }
            if(school!=null)
            {
                fuz(school);
            }

            if(time!=null)
            {
                fuz2(time);
            }

            if(school==null)
            {
                var for_time1 = $('.for_time1').html();
                if(for_time1)
                {
                    $('.xsdz').show();
                }
                else
                {
                    $('.xsdz').hide();
                }
            }

        });

        //返回json数组
        function getArrayByJson(json) {
            var obj = new Function("return " + json)();
            return obj;
        }

        //点击时间框,进行判断
        function shijian()
        {
            var school_id = $('.schoolId').val();
            var project_id = '<?php echo ($project_id); ?>';
            var str='';
            $.post("/demo/index.php?s=/Mobile/Bespoke/getBespoke",{school_id:school_id,project_id:project_id},function(jsonstr)
            {
                var data = getArrayByJson(jsonstr);
                var classes = data[0];

                if(classes)
                {
                    //成功后,赋值给时间列表,并显示
                    for (var i = 0; i < classes.length; i++)
                    {
                        str += '<div class="shijian_timeslot" onclick="fuz2('+i+')"><input type="hidden" class="class_id'+i+'" value="'+classes[i]['class_id']+'"/>' +
                        '<p class="rens"><span class="shijian">'+classes[i]['week']+'&nbsp;&nbsp;</span>' +
                        '<span class="xinqi xinqi'+i+'">'+classes[i]['times']+'</span></p>' +
                        '<p class="rens"><span class="shijian"><span class="timeslot'+i+'">'+classes[i]['timeslot']+'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人数 <span class="counts'+i+'">'+classes[i]['counts']+'</span>/<span class="number'+i+'">'+classes[i]['number']
                        +'</span></span></p></div>';

                    }
                    $('.dddd').html(str);
                    $(".tan2").show();
                }
                else{
                  showMessage(data[1],'','1000');
                }
            });
        }

        //点击马上预约
        function yuyue()
        {
            var for_time1 = $('.for_time1').html();
            var for_time2 = $('.for_time2').html();
            var bespoke_id = $('.bespokeId').val();
            var class_id = $('.classId').val();
            var project_id = $('.projectId').val();
            var counts = $('.countS').val();
            var number = $('.numbeR').val();
            $.post("/demo/index.php?s=/Mobile/Bespoke/zb_yuyue",{for_time1:for_time1,for_time2:for_time2,bespoke_id:bespoke_id,class_id:class_id,project_id:project_id,counts:counts,number:number},function(jsonstr)
            {
                var data = getArrayByJson(jsonstr);

                if(data[0]=='0')
                {
                    showMessage('预约成功！',data[1],1000);
                }
                else
                {
                    showMessage(data[0],'',1000);
                }
            });
        }

        //点击修改预约
        function up_yuyue()
        {

            var for_time1 = $('.for_time1').html();
            var for_time2 = $('.for_time2').html();

            var bespoke_id = $('.bespokeId').val();
            var class_id = $('.classId').val();
            var counts = $('.countS').val();
            var number = $('.numbeR').val();

            $.post("/demo/index.php?s=/Mobile/Bespoke/up_yuyue",{for_time1:for_time1,for_time2:for_time2,class_id:class_id,bespoke_id:bespoke_id,counts:counts,number:number},function(jsonstr)
            {
                var data = getArrayByJson(jsonstr);
                if(data[0]=='0')
                {
                    showMessage('预约成功！',data[1],1000);
                }
                else
                {
                    showMessage(data[0],'',1000);
                }
            });
        }
        //点击校区位置,进入地图页面
        function lgt()
        {
            var lg = $('.LG').val();
            var lt = $('.LT').val();
            window.location.href = "/demo/index.php?s=/Mobile/Bespoke/map&lg="+lg+"&lt="+lt;
        }
    </script>
</head>
<body>
<div class="tan"></div>
<div class="tan1" style="display: none">
    <div class="xiaoqu">
        <?php if(is_array($schools)): foreach($schools as $k=>$sc): ?><p class="xuanz<?php echo ($k); ?>" onclick="fuz(<?php echo ($k); ?>)"><?php echo ($sc["school_name"]); ?></p>
            <input type="hidden" class="area<?php echo ($k); ?>" value="<?php echo ($sc["area"]); ?>"/>
            <input type="hidden" class="school_id<?php echo ($k); ?>" value="<?php echo ($sc["id"]); ?>"/>
            <input  class="lg<?php echo ($k); ?>"  type="hidden" value="<?php echo ($sc["lg"]); ?>"/>
            <input  class="lt<?php echo ($k); ?>"  type="hidden" value="<?php echo ($sc["lt"]); ?>"/><?php endforeach; endif; ?>
    </div>
    <p class="qx" onclick="qx(1)" >取消</p>
</div>
<div class="tan2" style="display: none;">
    <div class="dddd">
    </div>
    <p class="qx" onclick="qx(2)">取消</p>
</div>
    <div class="head">
        <a href="/demo/index.php?s=/Mobile/Bespoke/etc_appointment" class="back">
            <span >返回</span>
        </a>
    </div>
  <input type="hidden" class="schoolId" value="<?php echo ($bespoke["school_id"]); ?>"/>
    <div class="main">
        <div class="for">
            <h1 class="curriculum">课程名称：<span><?php echo ($projectname); ?></span></h1>

                <h1 class="place">上课地点：
                    <p class="for_time for_time1" onclick="xuan(1)" type="text" value=""><?php echo ($bespoke["school_name"]); ?></p>
                </h1>
            <p class="address">地址：
                <span class="xsdz" style="display: none">
                <span class="area" style="color: #bbbbbb"><?php echo ($bespoke["area"]); ?></span>&nbsp;&nbsp;&nbsp;
                    <a onclick="lgt()"><span>查看校区位置</span></a>
                    <input  class="LG"  type="hidden" value="<?php echo ($bespoke["lg"]); ?>"/>
                    <input  class="LT"  type="hidden" value="<?php echo ($bespoke["lt"]); ?>"/>
            </span>
            </p>
            <h1 class="place">上课时间：
                <p class="for_place for_time2" onclick="xuan(2),shijian();" type="text" value=""><?php echo ($bespoke["times"]); ?>　<?php echo ($bespoke["timeslot"]); ?></p>
                <input class ="classId" name="class_id" type="hidden" value="<?php echo ($bespoke["class_id"]); ?>"/>
                <input  class="projectId" name="project_id" type="hidden" value="<?php echo ($project_id); ?>"/>
                <input class ="countS"  type="hidden" value="<?php echo ($bespoke["counts"]); ?>"/>
                <input  class="numbeR"  type="hidden" value="<?php echo ($bespoke["number"]); ?>"/>
                <input  class="bespokeId"  type="hidden" value="<?php echo ($bespokeId); ?>"/>
            </h1>
            <p class="explain">您可预约最近一周的课程，课程开始前一天的18:00点后无法预约及取消预约。</p>
            <h1 class="contacts">联系人：<span><?php echo ($app["nickname"]); ?></span></h1>
            <h1 class="ph_number">手机号：<span><?php echo ($app["phone"]); ?></span></h1>
        </div>
    </div>
<?php if($bespokeId != ''): ?><a  href="/demo/index.php?s=/Mobile/Bespoke/ok_appointment" >
        <div class="but but1" >不修改了</div>
    </a>
    <div class="but but2">
        <input  class="yuyue" style="outline: 0;-webkit-appearance: none;" type="button"  name="submit" onclick="up_yuyue()" value="马上预约"/>
    </div>
    <?php else: ?>
    <div class="but but2"><input  class="yuyue" style="outline: 0;-webkit-appearance: none;" type="button"  name="submit" onclick="yuyue()" value="马上预约"/></div><?php endif; ?>
</body>
</html>