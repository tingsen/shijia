
//全局变量
var sj = {};

//初始化
sj.initial = function() {

    /* 此类为hash链接 */
    $('a.ajax-hash').on('click',function(){
        var hash = this.hash && this.hash.substr(1);
        if (hash != ""){
            eval(hash + '.call(this);');
        }
        return false;
    });

    /* 此类为确认后执行的ajax操作 */
    $('a.confirm-request').on('click',function(){
        if(confirm('确认执行这个操作吗?')){
            $.get($(this).attr('href'));
        }
        return false;
    });

}


/**
 * 全选，反选，取消，具体操作(传递ids数组)
 * */
sj.admin_select = function() {
    //全选
    $("#select_all").bind('click',function(){
        $("input:checkbox[name]").each(function(){
            $(this).attr("checked", true);
        });
    });
	
    //反选
    $("#select_un").bind('click',function(){
        $("input:checkbox[name]").each(function(){
            $(this).attr("checked",!this.checked);
        });
    });
	
    //取消
    $("#select_cancel").bind('click',function(){
        $("input:checkbox[name]").each(function(){
            $(this).attr("checked", false);
        });
    });

};


//
//后台多选记录ID
sj.ckbox_record = function(mark){
    var arrChk = new Array()
    $(mark).each(function(){
        if($(this).is(':checked')){
            arrChk+=this.value + ',';
        }
    });
	return arrChk;

};

//后台删除
sj.ajax_delete = function(url,ids,mark,type){
	$.get(url, {ids: ids, type: type}, function(result){
		if (result.state == 1){
			for(var i=0; i<result.ids.length; i++) {
				$('#'+ mark +'_box_'+ result.ids[i]).remove();
			}
		}else{
			alert('删除失败!');
		}
	});
};

/**
 * 允许多附件上传
 */
sj.record_asset_ids = function(id, class_name){
    var ids = $(class_name).val();
    if (ids.length == 0){
        ids = id;
    }else{
        if (ids.indexOf(id) == -1){
            ids += ','+id;
        }
    }
    $(class_name).val(ids);
};

//移除附件id
sj.remove_asset_ids = function(id, class_name){
    var ids = $(class_name).val();
    var ids_arr = ids.split(',');
    var is_index_key = sj.in_array(ids_arr,id);
    ids_arr.splice(is_index_key,1);
    ids = ids_arr.join(',');
    $(class_name).val(ids);
};

//查看字符串是否在数组中存在
sj.in_array = function(arr, val) {
    var i;
    for (i = 0; i < arr.length; i++) {
        if (val === arr[i]) {
            return i;
        }
    }
    return -1;
}; // 返回-1表示没找到，返回其他值表示找到的索引

//求字符串截取后长度
sj.str_length = function(str) {
	if(str==''){
		return 0;
	}else{
		return str.split(',').length;
	}
}
