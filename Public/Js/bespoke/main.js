/**
 * Created by Kami on 2016/5/10.
 */


function xuan(data){
    $(".tan").show();
    $(".tan"+data).show();

}

//点击取消按钮
function qx(data){
    $(".tan").hide();
    $(".tan"+data).hide();
}

//点击选择学校
function fuz(data,cs){
    var sss=$(".xuanz"+data).text();
    var area = $(".area"+data).val();
    var school_id = $(".school_id"+data).val();

    var lg = $(".lg"+data).val();
    var lt = $(".lt"+data).val();

    $(".LG").val(lg);
    $(".LT").val(lt);

    $(".schoolId").val(school_id);
    $(".for_time1").html(sss);
    if(cs!=1)
    {
        $(".for_time2").html('');
    }

    if(sss)
    {
        $('.xsdz').show();
    }
    $(".area").html(area);
    $(".tan").hide();
    $(".tan"+'1').hide();
    setStorageValue('schoolID', data);

    var top = $("#xinqi0").offset().bottom();
    var left = $("#xinqi0").offset().left();

}

//点击选择时间
function fuz2(data)
{
    var zzz =$(".xinqi"+data).text();
    var zz1 =$(".timeslot"+data).text();
    var classId =$(".class_id"+data).val();
    var counts =$(".counts"+data).html();
    var number =$(".number"+data).html();
    var times =$(".times"+data).html();

    $(".countS").val(counts);
    $(".numbeR").val(number);
    $(".classId").val(classId);
    var for_time2 = zzz+"　"+zz1;
    $(".for_time2").html(for_time2);
    $(".tan").hide();
    $(".tan"+2).hide();

    setStorageValue('timeID', data);

}

