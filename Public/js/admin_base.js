
//后台

/**
 * 全选，反选，取消，具体操作(传递ids数组)
 * */
sj.admin_select = function(){
    //全选
    $("#select_all").bind('click',function(){
        $("input:checkbox[name]").each(function(){
            $(this).prop("checked", true);
        });
    });
	
    //反选
    $("#select_un").bind('click',function(){
        $("input:checkbox[name]").each(function(){
            $(this).prop("checked",!this.checked);
        });
    });
	
    //取消
    $("#select_cancel").bind('click',function(){
        $("input:checkbox[name]").each(function(){
            $(this).prop("checked", false);
        });
    });

};
