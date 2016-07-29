/**
 * Created by Administrator on 2016/5/9.
 */
//添加弹出框
function show_box(times,weeks,code)
{

    $('#theme-popover').slideDown(200);
    //添加排课信息
    $("#J_btn_save").attr('onclick',  "add('"+ times +"','" + weeks + "','" + code + "')");

}
//删除弹出框
function delete_box(times,weeks,code,class_id)
{
    $('#theme-popover_delete').slideDown(200);
    //删除排课信息
    $("#J_btn_delete").attr('onclick',"deletes('"+ class_id +"','" + code + "')");
}

//添加排课信息
function add(timeslot, weeks, code)
{
    var protectId = $("#J_protect_id").val();
    var schoolId = $("#J_school_id").val();
    var number = $("#number").val();
    if(protectId)
    {
        $.post("__MODULE__/Bespoke/addClass",{timeslot:timeslot,weeks:weeks,project_id:protectId,school_id:schoolId,number:number}, function(data)
        {
            var obj = JSON.parse(data);
            if(obj[0]=="0")
            {
                $('#theme-popover-mask').fadeOut(100);
                $('#theme-popover').slideUp(200);
                var $td = $("#J_name_" + code);
                $td.children(".project_name").html(obj[1]);
                var count_number = 0+"/"+number;
                $td.children(".counts").html(count_number);
            }
            else
            {
                showMessage(data);
            }
        });
    }
}

//删除排课信息
function deletes(id,code)
{

    if(id)
    {
        $.post("__MODULE__/Bespoke/deleteClass",{id:id}, function(data)
        {

            if(data=="删除成功！")
            {
                $('#theme-popover_delete').slideUp(200);
                var $td = $("#J_class_" + code);
                $td.children(".project_name").html('');
                $td.children(".class_counts").html('');
            }
            else
            {
                showMessage(data);
            }
        });
    }
}