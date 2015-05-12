$(document).ready(function(){
    bind_toggle_agree();
    bind_employ();
});
function bind_toggle_agree()
{
    $(".toggle_agree").bind("click",function(){
        var ajaxurl = $(this).attr("href");
        var query = new Object();
        query.ajax = 1;
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
            $.showSuccess(ajaxobj.info,function(){
                if(ajaxobj.jump!="")
            {
                location.reload();
            }
            });	
        }
            else
        {
            if(ajaxobj.jump!="")
        {
            location.reload();
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
                            location.reload();
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
}

function bind_employ(){
	$(".employ").bind("click",function(){
		var ajaxurl = $(this).attr("href");
		$.showConfirm("确定录用该求职者？",function(){
			var query = new Object();
			query.ajax = 1;
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
							$.showSuccess(ajaxobj.info,function(){
								if(ajaxobj.jump!="")
								{
									location.reload();
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
			
		});
		return false;
	});
}
