<?php

//分类集合options
//$kind为分类类型,　$evt是查询父类还是子类,　$pid是传入父类id
function cate_options ($kind, $evt, $pid=0) {
	switch ($evt)
	{
	case 'all':
		$cates = D('Category')->where('state=1 AND kind='.intval($kind))->order('id desc')->select();
		break;  
	case 'parent':
		$cates = D('Category')->where('state=1 AND pid=0 AND kind='.intval($kind))->order('id desc')->select();
		break;
	case 'children':
		$cates = D('Category')->where('state=1 AND pid='.intval($pid).' AND kind='.intval($kind))->order('id desc')->select();
		break;
	default:
		$cates = D('Category')->where('state=1 AND kind='.intval($kind))->order('id desc')->select();
	}

	return $cates;
}

//栏目位集合options
//$kind为分类类型
function space_options ($kind=1) {
	switch ($evt)
	{
	case 'all':
		$spaces = D('ColumnSpace')->where('state=1 AND kind='.intval($kind))->order('id desc')->select();
		break;  

	default:
		$spaces = D('ColumnSpace')->where('state=1 AND kind='.intval($kind))->order('id desc')->select();
	}

	return $spaces;
}

function system_sign($mark){
	$system = system_bool($mark);
	
	if($system){
		return true;
	}else{
		redirect(U('home/index/index'), 3, '报名还没开始');
	}
}

//系统参数(布尔)
function system_bool($mark) {
	$system = D('System')->where(array('mark'=>$mark))->find();
	if($system) {
		if($system['state']==0) {
			return false;
		}else if($system['state']==1){
			return true;
		}
	}else{
		return false;
	}
}

//系统参数(值)
function system_value($mark) {
	$system = D('System')->where(array('mark'=>$mark))->find();
	if($system) {
		return $system['value'];
	}else{
		return '';
	}
}

//解析json，获取评委表申请ID
function fetch_material_ids($json_materials, $p_id) {
	$m_arr = json_decode($json_materials, true);
	if(empty($m_arr)) return '';
	if(empty($m_arr[$p_id])) return '';
	return $m_arr[$p_id]['m_ids'];
}

//解析json，获取评委表申请状态
function fetch_material_state($json_materials, $p_id) {
	$m_arr = json_decode($json_materials, true);
	if(empty($m_arr)) return 0;
	if(empty($m_arr[$p_id])) return 0;
	return $m_arr[$p_id]['state'];
}

