$(document).ready(function(){
    bind_cate_select();
    bind_project_form();
    bind_faq_func();
    bind_get_cate();
});

function bind_get_cate(){
    if($(".cate_list .current").text()==""){
        $("#div_cate").html("【分类】");
    }else{
        $("#div_cate").html("【"+$(".cate_list .current").text()+"】");
    }
}
function bind_faq_event()
{
    $("input[name='question[]']").bind("click focus",function(){
        if($.trim($(this).val())=="请输入问题")
            $(this).val("");
    });
    $("input[name='question[]']").bind("blur",function(){
        if($.trim($(this).val())=="请输入问题"||$.trim($(this).val())=="")
            $(this).val("请输入问题");
    });

    $("textarea[name='answer[]']").bind("click focus",function(){
        if($.trim($(this).val())=="请输入答案")
            $(this).val("");
    });
    $("textarea[name='answer[]']").bind("blur",function(){
        if($.trim($(this).val())=="请输入答案"||$.trim($(this).val())=="")
            $(this).val("请输入答案");
    });
}

function bind_faq_func()
{
    bind_faq_event();
    $("#add_faq").bind("click",function(){
        var ajaxurl = APP_ROOT+"/index.php?ctl=ajax&act=add_deal_faq";
        $.ajax({ 
            url: ajaxurl,
            type: "POST",
            success: function(html){
                $("#faq_list").append(html);
                bind_faq_event();
            },
            error:function(ajaxobj)
            {
                if(ajaxobj.responseText!='')
                    alert(ajaxobj.responseText);
            }
        });
    });
}

function del_faq(o)
{
    if($(".faq_item").length>1)
        $(o).parent().parent().remove();
}

function bind_cate_select()
{
    $(".cate_list").find("span").bind("click",function(){
        $(".cate_list").find("span").removeClass("current");
        $(this).addClass("current");
        $("input[name='cate_id']").val($(this).attr("rel"));
        $("#div_cate").html("【"+$(this).text()+"】");
    });
}

function bind_project_form()
{
    if($("#project_form").find(".cate_list span.current").length>0)
        {
            $("#project_form").find("input[name='cate_id']").val($("#project_form").find(".cate_list span.current").attr("rel"));
        }	
        else
            {
                $("#project_form").find("input[name='cate_id']").val('');
            }

            $("input[name='name']").bind("keyup blur",function(){
                if($(this).val().length>25)
                    {
                        $(this).val($(this).val().substr(0,25));
                        return false;
                    }
                    else
                        $("#deal_title").html($(this).val());
            });

            $("select[name='province']").bind("change",function(){
                var val = "";
                if($(this).val()=="")
                    val = "省份";
                else
                    val = $(this).val();
                $("#province").html(val);
            });

            $("input[name='if_interview']").bind("change click",function(){
                if($(this).val()==1){
                    $(".interview_form").show();
                    $(".about_interview").show();
                }else{
                    $(".interview_form").hide();
                    $(".about_interview").hide();
                }
            });

            $("input[name='company']").bind("keyup blur",function(){
                if($(this).val().length>25)
                    {
                        $(this).val($(this).val().substr(0,25));
                        return false;
                    }
                    else
                        $("#p_company").html($(this).val());
            });

            $("input[name='interviewer']").bind("keyup blur",function(){
                if($(this).val().length>25)
                    {
                        $(this).val($(this).val().substr(0,25));
                        return false;
                    }
                    else
                        $("#p_interviewer").html($(this).val());
            });
            $("input[name='interview_contact']").bind("keyup blur",function(){
                if($(this).val().length>25){
                    $(this).val($(this).val().substr(0,25));
                    return false;
                }
                else
                    $("#p_interview_contact").html($(this).val());
            });
            $("input[name='interview_loc']").bind("keyup blur",function(){
                if($(this).val().length>25)
                    {
                        $(this).val($(this).val().substr(0,25));
                        return false;
                    }
                    else
                        $("#p_interview_loc").html($(this).val());
            });
            $("input[name='interview_time']").bind("keyup blur",function(){
                if($(this).val().length>25)
                    {
                        $(this).val($(this).val().substr(0,25));
                        return false;
                    }
                    else
                        $("#p_interview_time").html($(this).val());
            });

            $("input[name='limit_applicant']").bind("keyup blur",function(){
                if($.trim($(this).val())==''||isNaN($(this).val())||parseInt($(this).val())<=0)
                    {
                        $(this).val("");
                    }
                    else if($(this).val().length>3)
                        {
                            $(this).val($(this).val().substr(0,3));
                            $("#limit_applicant").html($(this).val().substr(0,2));
                        }
                        else
                            $("#limit_applicant").html($(this).val());
            });

            $("select[name='city']").bind("change",function(){
                var val = "";
                if($(this).val()=="")
                    val = "城市";
                else
                    val = $(this).val();
                $("#city").html(val);
            });

            $("input[name='limit_price']").bind("keyup blur",function(){
                if($.trim($(this).val())==''||isNaN($(this).val())||parseFloat($(this).val())<=0)
                    {
                        $(this).val("");
                    }
                    else if($(this).val().length>6)
                        {
                            $(this).val($(this).val().substr(0,6));
                            $("#price").html($(this).val().substr(0,6));
                        }
                        else
                            $("#price").html($(this).val());
            });

            $("select[name='pay_way']").bind("click",function(){
                $("#pay_way_span").html($(this).val());
            });

            $("input[name='sex']").bind("click",function(){
                var sex=Number($(this).val());
                switch(sex){
                    case 0:$("#p_sex").html("女");break;
                    case 1:$("#p_sex").html("男");break;
                    case 2:$("#p_sex").html("无要求");break;
                }
            });

            $("input[name='deal_days']").bind("keyup blur",function(){
                if($.trim($(this).val())==''||isNaN($(this).val())||parseInt($(this).val())<=0)
                    {
                        $(this).val("");
                    }
                    else if($(this).val().length>2)
                        {
                            $(this).val($(this).val().substr(0,2));
                            $("#deal_days").html($(this).val().substr(0,2));
                        }
                        else
                            $("#deal_days").html($(this).val());
            });

            $("#project_form").bind("submit",function(){

                if($(this).find("input[name='cate_id']").val()==''||$(this).find("input[name='cate_id']").val()==0)
                    {
                        $.showErr("请选择兼职类型");
                        return false;
                    }
                    if($.trim($(this).find("input[name='name']").val())=='')
                        {
                            $.showErr("请填写兼职标题");
                            return false;
                        }
                        if($(this).find("input[name='name']").val().length>25)
                            {
                                $.showErr("兼职标题不超过25个字");
                                return false;
                            }
                            if($.trim($(this).find("select[name='province']").val())=='')
                                {
                                    $.showErr("请选择省份");
                                    return false;
                                }
                                if($.trim($(this).find("select[name='city']").val())=='')
                                    {
                                        $.showErr("请选择城市");
                                        return false;
                                    }
                                    if($.trim($(this).find("input[name='limit_price']").val())=='')
                                        {
                                            $.showErr("请输入工资");
                                            return false;
                                        }
                                        if(isNaN($(this).find("input[name='limit_price']").val())||parseFloat($(this).find("input[name='limit_price']").val())<=0)
                                            {
                                                $.showErr("工资格式错误");
                                                return false;
                                            }
                                            if($.trim($(this).find("input[name='deal_days']").val())=='')
                                                {
                                                    $.showErr("请输入招聘天数");
                                                    return false;
                                                }
                                                if(isNaN($(this).find("input[name='deal_days']").val())||parseInt($(this).find("input[name='limit_price']").val())<=0)
                                                    {
                                                        $.showErr("请输入正确的招聘天数");
                                                        return false;
                                                    }

                                                    /*新增四个必填项*/
                                                    if($.trim($(this).find("input[name='workdays']").val())==''){
                                                        $.showErr("请输入工作周期");
                                                        return false;
                                                    }
                                                    if($.trim($(this).find("input[name='worktime']").val())==''){
                                                        $.showErr("请输入工作时间");
                                                        return false;
                                                    }
                                                    if($.trim($(this).find("input[name='contact']").val())==''){
                                                        $.showErr("请输入工作联系方式");
                                                        return false;
                                                    }
                                                    if($.trim($(this).find("input[name='location']").val())==''){
                                                        $.showErr("请输入工作详细地址");
                                                        return false;
                                                    }
                                                    if($(this).find("input[name='location']").val().length>50){
                                                        $.showErr("工作详细地址(县级开始，到路口和门牌),不超过50个字");
                                                        return false;
                                                    }

                                                    var ajaxurl = $(this).attr("action");
                                                    var query = $(this).serialize();
                                                    query+="&description="+ encodeURIComponent(KE.util.getData("descript"));
                                                    $.ajax({ 
                                                        url: ajaxurl,
                                                        dataType: "json",
                                                        data:query,
                                                        type: "POST",
                                                        success: function(ajaxobj){
                                                            if(ajaxobj.status==1)
                                                                {
                                                                    if(ajaxobj.info!="")
                                                                        {
                                                                            $("input[name='id']").val(ajaxobj.info);
                                                                            $.showSuccess("保存成功",function(){
                                                                                if(ajaxobj.jump!="")
                                                                                    {
                                                                                        location.href = ajaxobj.jump;
                                                                                    }
                                                                            });	
                                                                        }
                                                                        else
                                                                            {
                                                                                if(ajaxobj.jump!="")
                                                                                    {
                                                                                        location.href = ajaxobj.jump;
                                                                                    }
                                                                            }
                                                                }
                                                                else
                                                                    {
                                                                        if(ajaxobj.info!="")
                                                                            {
                                                                                $.showErr(ajaxobj.info,function(){
                                                                                    if(ajaxobj.jump!="")
                                                                                        {
                                                                                            location.href = ajaxobj.jump;
                                                                                        }
                                                                                });	
                                                                            }
                                                                            else
                                                                                {
                                                                                    if(ajaxobj.jump!="")
                                                                                        {
                                                                                            location.href = ajaxobj.jump;
                                                                                        }
                                                                                }							
                                                                    }
                                                        },
                                                        error:function(ajaxobj)
                                                        {
                                                            if(ajaxobj.responseText!='')
                                                                alert(ajaxobj.responseText);
                                                        }
                                                    });
                                                    return false;
            });



            $("#savenow").bind("click",function(){
                $("input[name='savenext']").val("0");
                $("#project_form").submit();
            });
            $("#savenext").bind("click",function(){
                $("input[name='savenext']").val("1");
                $("#project_form").submit();
            });
}
