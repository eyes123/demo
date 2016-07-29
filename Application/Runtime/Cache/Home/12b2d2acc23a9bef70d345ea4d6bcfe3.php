<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>书画系统后台管理</title>
  <link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
  <link rel="stylesheet" type="text/css" href="/demo/Public/Css/bespokeyz.css" />
  <script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/diashow.css" />
  <script type="text/javascript" src="/demo/Public/Js/diashow/diashow.js"></script>
  <script type="text/javascript" src="/demo/Public/Js/DatePicker/WdatePicker.js"></script>
  <script type="text/javascript">
    var module = "/demo/index.php?s=/Home";
    Array.prototype.remove = function (index) {
      if(isNaN(index)||index>this.length){return false;}
      for(var i=0,n=0;i<this.length;i++) {
        if(this[i]!=this[index])
        {
          this[n++]=this[i]
        }
      }
      this.length-=1;
    }
    //返回json数组
    function getArrayByJson(json) {
      var obj = new Function("return " + json)();
      return obj;
    }
    var xyData = [];
    $(document).ready(function () {

      $('.theme-poptit .close').click(function () {
        $('.theme-popover').slideUp(200);
      });
      $('#close').click(function () {
        $('.theme-popover').slideUp(200);
      });

      $('#close_edit').click(function () {
        $('.theme-popover_edit_bespoke').slideUp(200);
      });

      //添加学员，点击取消按钮，关闭添加学员窗口
      $('#J_btn_adduser_qx').click(function () {
        $('#theme-popover_addxy').slideUp(200);
      });

      $('#J_btn_deleteuser_qx').click(function () {
        $('#theme-popover_deletexy').slideUp(200);
      });
    });
    //弹出框
    //times 时间段，weeks 年月日,code 行列，class_id 排课id,counts 上课人数,number 上限人数
    function show_box(times, weeks, code, class_id, counts, project_id, number) {

      var $td = $("#J_name_" + code);
      var projectName = $td.children(".project_name").html();
      $(".projectName").html(projectName);
      if (counts > 0) {
          if (class_id) {

            $.get("/demo/index.php?s=/Home/Bespoke/getUsersClassId", {id: class_id}, function (jsonstr) {
              var data = getArrayByJson(jsonstr);
              xyData = data;
//                    console.log(data);
              show_xy(data);
            });
          }
          $('#theme-popover_edit').slideDown(200);

          var weeks0 = "2016-" + weeks;
          $(".times").html(times);
          $(".nyr").html(weeks0);
        }
      else {
        if (class_id) {
          $('#theme-popover_delete').slideDown(200);
          var weeks0 = "2016-" + weeks;
          $(".times").html(times);
          $(".nyr").html(weeks0);
        }
        else {
          $('#theme-popover').slideDown(200);
        }
      }

      //添加排课信息
      $("#J_btn_save").attr('onclick', "add('" + times + "','" + weeks + "','" + code + "')");

      //删除排课信息
      $("#J_btn_delete").attr('onclick', "deletes('" + times + "','" + weeks + "','" + class_id + "','" + code + "')");
      bindFunction(times, weeks, class_id, project_id, counts, number, code);
    }

    function bindFunction (times, weeks, class_id, project_id, counts, number, code) {
      if (class_id) {
        var $td = $("#J_name_" + code);
        //学员人数
        $td.children(".class_counts").html(counts);
        $td.children(".counts").html(counts);
        //上限人数
        var count_number = "/" + number;
        $td.children(".number").html(count_number);
        $td.children(".num_counts").html(count_number);
        if (counts == 0) {0
          $("#J_name_" + code).attr("class", 'gray');
        } else if (counts == number) {
          $("#J_name_" + code).attr("class", 'red');
        } else {
          $("#J_name_" + code).attr("class", 'green');
        }
        $("#J_name_" + code).attr('onclick', "show_box('" + times + "','" + weeks + "','"  + code + "','" + class_id + "'," + counts + ",'" + project_id + "'," + number + ")");

        var canshu = "'" + times + "','" + weeks + "','" + class_id + "','" + project_id + "'," + counts + "," + number + ",'" + code + "'";
        var show_addxy = "show_addxy(" + canshu + ")";
        var show_deletexy = "show_deletexy(" + canshu + ")";
        //在编辑页面点击，添加学员按钮，弹出添加学员窗体
        $("#J_btn_adduser_xy").attr('onclick', show_addxy);

        //在编辑页面点击，删除学员按钮，弹出删除学员窗体
        $("#J_btn_delete_xy").attr('onclick', show_deletexy);

        //在删除页面点击，添加学员按钮，弹出添加学员窗体
        $("#J_btn_adduser").attr('onclick', show_addxy);
      }
    }

    //展示学员
    function show_xy(data) {
      var str = '';
      if (data.length > 0) {
        $("#theme-popover_delete").hide();
        $("#theme-popover_edit").show();
        for (var i = 0; i < data.length; i++) {
          str += '<label><input name="Fruit" type="radio" checked="" value="' + data[i]['app_id'] + '" />' + data[i]['nickname'] + '&nbsp;&nbsp;&nbsp;&nbsp;' + data[i]['phone'] + '</label><br/>';
        }
      } else {
        $("#theme-popover_delete").show();
        $("#theme-popover_edit").hide();
      }
      $(".single").html(str);
    }

    //添加排课信息
    function add(timeslot, weeks, code) {
      var protectId = $("#J_protect_id").val();
      var schoolId = $("#J_school_id").val();
      var number = $("#number").val();
      if (protectId) {
        $.post("/demo/index.php?s=/Home/Bespoke/addClass", {
          timeslot: timeslot,
          weeks: weeks,
          project_id: protectId,
          school_id: schoolId,
          number: number
        }, function (data) {
          var obj = getArrayByJson(data);

          if (obj[0] == "添加成功！") {
            $('#theme-popover-mask').fadeOut(100);
            $('#theme-popover').slideUp(200);
            var $td = $("#J_name_" + code);

            $td.children(".project_name").html(obj[1]);

            bindFunction(timeslot, weeks, obj[2], protectId, 0, number, code);
          }
          else {
            showMessage(obj[0]);
          }
        });
      }
    }

    //删除排课信息
    function deletes(timeslot, weeks, id, code) {
      if (id) {
        $.post("/demo/index.php?s=/Home/Bespoke/deleteClass", {id: id}, function (data) {
          if (data == "删除成功！") {
            $('#theme-popover_delete').slideUp(200);
            var $td = $("#J_name_" + code);
              //删除排课之后全部赋值为空，td的背景颜色变为白色
                $td.children(".project_name").html('');
                $td.children(".counts").html('');
                $td.children(".num_counts").html('');
                $td.children(".class_counts").html('');
                $td.children(".number").html('');

            $("#J_name_" + code).attr("class", '');

              //删除完之后，重新赋值show_box
            $("#J_name_" + code).attr('onclick', "show_box('" + timeslot + "','" + weeks + "','" + code + "')");
          }
          else {
            showMessage(data);
          }
        });
      }
    }
    //弹出添加学员窗体
    function show_addxy(timeslot, weeks, class_id, project_id, counts, number, code) {

      if (class_id) {
        $('#theme-popover_addxy').slideDown(200);
        var canshu = "'" + timeslot + "','" + weeks + "','" + class_id + "','" + project_id + "'," + counts + "," + number + ",'" + code + "'";
        $("#J_btn_adduser_qd").attr('onclick', "addxy(" + canshu + ")");
        $("#J_btn_deleteuser_qd").attr('onclick', "deletexy(" + canshu + ")");
      }
    }
    //弹出删除学员窗体
    function show_deletexy(timeslot, weeks, class_id, project_id, counts, number, code) {
      if (class_id) {
        $('#theme-popover_deletexy').slideDown(200);
        var canshu = "'" + timeslot + "','" + weeks + "','" + class_id + "','" + project_id + "'," + counts + "," + number + ",'" + code + "'";
        $("#J_btn_adduser_qd").attr('onclick', "addxy(" + canshu + ")");
        $("#J_btn_deleteuser_qd").attr('onclick', "deletexy(" + canshu + ")");
      }
    }
    //添加学员到数据库
    function addxy(timeslot, weeks, class_id, project_id, counts, number, code) {
      var phone = $('#phone').val();

      if (class_id) {
        $.post("/demo/index.php?s=/Home/Bespoke/addBespoke", {
          class_id: class_id,
          phone: phone,
          project_id: project_id
        }, function (data) {
          var obj = getArrayByJson(data);
          if (obj[0] == "添加成功！") {
            //显示学员姓名和手机号
            var user = {nickname: obj[1], app_id: obj[2], phone: phone};
            xyData.push(user);
            show_xy(xyData);
            counts += 1;
            $('#theme-popover_addxy').slideUp(200);
            //添加完之后，重新赋值show_box
            bindFunction(timeslot, weeks, class_id, project_id, counts, number, code);
          }
          else {
            showMessage(obj[0]);
          }
        });
      }
    }
    //将选中的学员从数据库中删除
    function deletexy(timeslot, weeks, class_id, project_id, counts, number, code) {
      if (class_id) {
        //获取学员id
        var app_id = $('.single input[name="Fruit"]:checked ').val();
        $.post("/demo/index.php?s=/Home/Bespoke/deleteBespokeApp", {class_id: class_id, app_id: app_id}, function (data) {
          if (data == "删除成功！") {
            counts -= 1;
            $('#theme-popover_deletexy').slideUp(200);
            //重新
            var index;
            for (index = xyData.length;index--;) {
              if (xyData[index].app_id == app_id) {
                break;
              }
            }
            xyData.remove(index);
            show_xy(xyData);
            //删除完之后，重新赋值show_box
            bindFunction(timeslot, weeks, class_id, project_id, counts, number, code);
          }
          else {
            showMessage(data);
          }
        });
      }
    }
    function s_week(start_day) {
      location.href = "/demo/index.php?s=/Home/Bespoke/index&start_day=" + start_day + "<?php echo ($where1); ?>";
    }

  </script>
</head>
<body>
<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 预约列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>
<!-- 搜索模块 -->
<?php if($school_id == '0'): ?><div class="search_div">
  <form action="/demo/index.php?s=/Home/Bespoke/index" method="get">
    <img width="26" height="22" border="0" alt="search" src="/demo/Public/images/icon_search.gif"/>
    <input type="hidden" value="/Home/Bespoke/index" name="s"/>
    <select name="school_id" id="J_school_id">
      <option value="0">&nbsp;&nbsp;选择校区&nbsp;&nbsp;</option>
      <?php if(is_array($schools)): foreach($schools as $key=>$sc): ?><option value="<?php echo ($sc["id"]); ?>" <?php echo ($sc['id']==$scWhere?'selected="selected"':''); ?>>&nbsp;&nbsp;<?php echo ($sc["school_name"]); ?></option><?php endforeach; endif; ?>
    </select>
    <?php if($start_day != ''): ?><input type="hidden" name="start_day" value="<?php echo ($start_day); ?>"/><?php endif; ?>
    <input style="margin-left:35px;" class="button" type="submit" name="submit" value="搜索"/>
  </form>
</div><?php endif; ?>
<div>
  <form method="post" action="/demo/index.php?s=/Home/Bespoke/daochuBespoke&start_day=<?php echo ($start_day); echo ($where1); ?>" name="form_daochu">
    <input type="button" name="btn_output" value="导出" class="submit" onclick="document.form_daochu.submit();"/>
  </form>
</div>
<!-- 列表样式 -->
<form action="" method="get">
  <div class="data-list">

    <!--添加课程-->
    <div class="theme-popover" id="theme-popover">
      <div class="theme-popbod dform">
        <ol>
          新增课程
          <li>
            <strong>课程名称：</strong>
            <select name="project_id" id="J_protect_id">
              <option value="0">&nbsp;&nbsp;选择课程&nbsp;&nbsp;</option>
              <?php if(is_array($projects)): foreach($projects as $key=>$pr): ?><option value="<?php echo ($pr["id"]); ?>" <?php echo ($pr['id']==$prWhere?'selected="selected"':''); ?>>&nbsp;&nbsp;<?php echo ($pr["project_name"]); ?></option><?php endforeach; endif; ?>

            </select>
          </li>
          <li>
            <strong>人数上限：</strong>
            <input class="ipt" id="number" type="text" name="number" value="" size="20"/>
          </li>
            <input class="btn btn-primary" id="J_btn_save" type="button" name="submit" value="确定"/>

            <input class="btn btn-primary" type="button" name="submit" id="close" value="取消"/>
        </ol>
      </div>
    </div>

    <!--删除课程-->
    <div class="theme-popover" id="theme-popover_delete">
      <div class="theme-poptit">
        <div class="name"><span class="projectName"></span></div>
        <div class="name"><span class="nyr">2016-05-04</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
          class="times">12:00-13:00</span></div>
        <a href="javascript:;" title="关闭" class="close">×</a>
      </div>

      <div class="theme-popbod dform">
        <ol>

          <li>
            暂无学员报名，点击左下角删除<br>
            即可从课程表中删除此课程。
          </li>
          <li>
            <input class="btn btn-primary" id="J_btn_delete" type="button" name="submit" value="删除课程"/>
            <input class="btn btn-primary" id="J_btn_adduser" type="button" name="submit" value="添加学员"/>
          </li>
        </ol>
      </div>
    </div>

    <!--编辑课程-->
    <div class="theme-popover_edit_bespoke" id="theme-popover_edit">

      <div class="theme-poptit">
        <div class="name"><span class="projectName"></span></div>
        <div class="name"><span class="nyr">2016-05-04</span>&nbsp;&nbsp;<span class="times">12:00-13:00</span></div>
          <a href="javascript:;" title="关闭" class="close" id="close_edit">×</a>
      </div>

      <div class="theme-popbod dform">
        <ol>
          <li class="single">

          </li>
        </ol>
          <div class="edit_bespoke">
              <span class="edit_bespoke_span">
                    <input class="btn btn-primary" id="J_btn_delete_xy" type="button" name="submit" value="删除学员"/>
            </span>
               <span class="edit_bespoke_span2">

                    <input class="btn btn-primary" id="J_btn_adduser_xy" type="button" name="submit" value="添加学员"/>
               </span>
          </div>
      </div>
    </div>

    <!--添加学员-->
    <div class="theme-popover" id="theme-popover_addxy">

      <div class="theme-popbod dform">
        <ol>
          手机号：<input type="text" value="" name="phone" id="phone"/>
          <li>
            <input class="btn btn-primary" id="J_btn_adduser_qd" type="button" name="submit" value="确定"/>

            <input class="btn btn-primary" id="J_btn_adduser_qx" type="button" name="submit" value="取消"/>
          </li>
        </ol>
      </div>
    </div>

    <!--删除学员-->
    <div class="theme-popover" id="theme-popover_deletexy">

      <div class="theme-popbod dform">
        <ol>
          确定要将该学员删除？
          <li>
            <input class="btn btn-primary" id="J_btn_deleteuser_qd" type="button" name="submit" value="确定"/>
            <input class="btn btn-primary" id="J_btn_deleteuser_qx" type="button" name="submit" value="取消"/>
          </li>
        </ol>
      </div>
    </div>

    <table cellspacing="1" cellpadding="3" class="table_bespoke">
      <tbody>
      <tr>
        <th><a onclick="s_week('<?php echo ($up_day); ?>')"><上一周</a></th>
        <th>周一<?php echo ($weeks[0]); ?></th>
        <th>周二<?php echo ($weeks[1]); ?></th>
        <th>周三<?php echo ($weeks[2]); ?></th>
        <th>周四<?php echo ($weeks[3]); ?></th>
        <th>周五<?php echo ($weeks[4]); ?></th>
        <th>周六<?php echo ($weeks[5]); ?></th>
        <th>周日<?php echo ($weeks[6]); ?></th>
        <th><a onclick="s_week('<?php echo ($next_day); ?>')">下一周></a></th>
      </tr>
      <?php if(is_array($lists)): foreach($lists as $k=>$list): ?><tr class="tr0">
          <td><?php echo ($times[$k]); ?></td>
          <?php if(is_array($list)): foreach($list as $g=>$li): if((($k == 0 || $k == 2) && $g < 5) || ($k == 3 && $g > 4)): ?><td>不可选</td>
                  <?php else: ?>
            <td class="<?php if($li != ''): if($li["counts"] == '0'): ?>gray<?php else: ?>
                <?php if($li["counts"] < $li["number"] ): ?>green<?php else: ?>red<?php endif; endif; endif; ?>" id="J_name_<?php echo ($k); echo ($g); ?>" times="<?php echo ($times[$k]); ?>" weeks="<?php echo ($weeks[$g]); ?>"
            <?php if($weeks2[$g] > $nowtimeInt): ?>onclick="show_box('<?php echo ($times[$k]); ?>','<?php echo ($weeks[$g]); ?>','<?php echo ($k); echo ($g); ?>','<?php echo ($li["class_id"]); ?>',
              <?php if($li["counts"] == ''): ?>0<?php else: echo ($li["counts"]); endif; ?>,
              '<?php echo ($li["project_id"]); ?>',
              <?php if($li["number"] == ''): ?>0<?php else: echo ($li["number"]); endif; ?>
              )<?php endif; ?>">
            <span class="project_name"><?php echo ($li["project_name"]); ?></span>
            <br>
            <?php if($li != ''): ?><span class="class_counts"><?php echo ($li["counts"]); ?></span>
                <span class="number">/<?php echo ($li["number"]); ?></span>
              <?php else: ?>
              <span class="counts"></span>
                <span class="num_counts"></span><?php endif; ?>
         </td><?php endif; endforeach; endif; ?>
          <td><?php echo ($times[$k]); ?></td>
        </tr><?php endforeach; endif; ?>
      </tbody>

    </table>
  </div>
</form>
</body>
</html>