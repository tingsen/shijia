<?php

//分类类型
function cate_type_str($id) {
	switch (intval($id))
	{
	case 1:
		$cate = 'Post';
		break;  
	case 2:
		$cate = '--';
		break;
	default:
		$cate = '未定义';
	}

	return $cate;
}

//奖项定义
function prize_options($year = '2014') {
	$prizes = array(
		'2014'	=>	array(
			array('id'=>5, 'name'=>'十佳创新型企业'),
			array('id'=>4, 'name'=>'十佳设计公司'),
			array('id'=>3, 'name'=>'十佳杰出设计师'),
			array('id'=>2, 'name'=>'十佳推广杰出人物'),
			array('id'=>1, 'name'=>'十佳教育工作者'),
		),
		'2013'	=>	array(
			array('id'=>5, 'name'=>'十佳创新型企业'),
			array('id'=>4, 'name'=>'十佳设计公司'),
			array('id'=>3, 'name'=>'十佳杰出设计师'),
			array('id'=>2, 'name'=>'十佳推广杰出人物'),
			array('id'=>1, 'name'=>'十佳教育工作者'),
		),
		'2012'	=>	array(
			array('id'=>5, 'name'=>'十佳创新型企业'),
			array('id'=>4, 'name'=>'十佳设计公司'),
			array('id'=>3, 'name'=>'十佳杰出设计师'),
			array('id'=>2, 'name'=>'十佳推广杰出人物'),
			array('id'=>1, 'name'=>'十佳教育工作者'),
		),
		'2011'	=>	array(
			array('id'=>5, 'name'=>'十佳创新型企业'),
			array('id'=>4, 'name'=>'十佳最具创新力企业设计中心'),
			array('id'=>3, 'name'=>'十佳设计服务机构'),
			array('id'=>2, 'name'=>'十佳推广杰出人物'),
			array('id'=>1, 'name'=>'十佳教育工作者'),
		)
	);
	return $prizes[$year];
}

//奖项取值
function prize_name($id, $year='2014') {
	if($year=='2011'){
		switch (intval($id))
		{
		case 1:
			$cate = '十佳教育工作者';
			break;  
		case 2:
			$cate = '十佳推广杰出人物';
			break;
		case 3:
			$cate = '十佳设计服务机构';
			break;
		case 4:
			$cate = '十佳最具创新力企业设计中心';
			break;
		case 5:
			$cate = '十佳创新型企业';
			break;
		default:
			$cate = '未定义';
		}
	}else{
		switch (intval($id))
		{
		case 1:
			$cate = '十佳教育工作者';
			break;  
		case 2:
			$cate = '十佳推广杰出人物';
			break;
		case 3:
			$cate = '十佳杰出设计师';
			break;
		case 4:
			$cate = '十佳设计公司';
			break;
		case 5:
			$cate = '十佳创新型企业';
			break;
		default:
			$cate = '未定义';
		}
	}
	return $cate;
}

//奖项后边单位(家/位)
function prize_last_unit($id) {
		switch (intval($id))
		{
		case 1:
			$cate = '位';
			break;  
		case 2:
			$cate = '位';
			break;
		case 3:
			$cate = '位';
			break;
		case 4:
			$cate = '家';
			break;
		case 5:
			$cate = '家';
			break;
		default:
			$cate = '未定义';
		}
	return $cate;
}

//获取性别信息
function sex_name($id) {
	switch (intval($id))
	{
	case 0:
		$sex = '保密';
		break;
	case 1:
		$sex = '男';
		break;
	case 2:
		$sex = '女';
		break;
	default:
		$sex = '未定义';
	}
	return $sex;
}

//学历
function scope_options() {
	$scope = array(
		array('id'=>1, 'name'=>'高中'),
		array('id'=>2, 'name'=>'中专'),
		array('id'=>3, 'name'=>'大专'),
		array('id'=>4, 'name'=>'本科'),
		array('id'=>5, 'name'=>'硕士'),
		array('id'=>6, 'name'=>'博士'),
	);
	return $scope;
}

//学历取值
function scope_name($id) {
	switch (intval($id))
	{
	case 1:
		$cate = '高中';
		break;  
	case 2:
		$cate = '中专';
		break;
	case 3:
		$cate = '大专';
		break;
	case 4:
		$cate = '本科';
		break;
	case 5:
		$cate = '硕士';
		break;
	case 6:
		$cate = '博士';
		break;
	default:
		$cate = '不限';
	}
	return $cate;
}

//企业性质
function nature_options() {
	$scope = array(
		array('id'=>1, 'name'=>'外资'),
		array('id'=>2, 'name'=>'合资'),
		array('id'=>3, 'name'=>'国企'),
		array('id'=>4, 'name'=>'民营公司'),
		array('id'=>5, 'name'=>'政府机关'),
		array('id'=>6, 'name'=>'事业单位'),
	);
	return $scope;
}

//性质取值
function nature_name($id) {
	switch (intval($id))
	{
	case 1:
		$cate = '外资';
		break;  
	case 2:
		$cate = '合资';
		break;
	case 3:
		$cate = '国企';
		break;
	case 4:
		$cate = '民营公司';
		break;
	case 5:
		$cate = '政府机关';
		break;
	case 6:
		$cate = '事业单位';
		break;
	default:
		$cate = '不限';
	}
	return $cate;
}

//角色说明
function role_type($role_id) {
	switch (intval($role_id))
	{
	case 1:
		$cate = '管理员';
		break;  
	case 2:
		$cate = '编辑';
		break;
	case 3:
		$cate = '评委';
		break;
	case 9:
		$cate = '用户';
		break;
	default:
		$cate = '未定义';
	}
	return $cate;
}

//寄语
function leader_wish($mark='all') {
	$wish = array(
		'zd'	=>	array('mark'=>'zd', 'name'=>'朱焘', 'position'=>'中国工业设计协会会长', 'swf'=>'http://static.video.qq.com/TPout.swf?vid=f0126fpgw4a&auto=1', 'avatar'=>'jiyu/zd.jpg', 'remark'=>'中国工业设计协会会长。曾任：国家经委、计委、经贸委办公厅主任，国家计委企业管理局局长，国家经贸委副秘书长兼企业局局长、办公厅主任，中国轻工总会副会长，国家轻工业局副局长，国务院国资委监事会主席等职务。'),	
		'lyx'	=>	array('mark'=>'lyx', 'name'=>'路甬祥', 'position'=>'十一届全国人大常委会副委员长<br />中国工业设计协会顾问 ', 'swf'=>'http://static.video.qq.com/TPout.swf?vid=i0126j5e7qo&auto=1', 'avatar'=>'jiyu/lyx.jpg', 'remark'=>'中国科学院院士，中国工程院院士。 曾任中共中央委员，十一届全国人大常委会副委员长、党组成员，中国科学院院长，浙江大学校长。'),
		'bzf'	=>	array('mark'=>'bzf', 'name'=>'步正发', 'position'=>'中国轻工业联合会会长', 'swf'=>'http://static.video.qq.com/TPout.swf?vid=o0126631hpy&auto=1', 'avatar'=>'jiyu/bzf.jpg', 'remark'=>'中国轻工业联合会会长，劳动和社会保障部副部长、党组成员。历任劳动和社会保障部副部长、党组成员，人事部副部长、党组成员，中央大型企业工委委员，第十一届全国政协提案委员会副主任、第十一届全国政协委员，兵器工业部干部司副司长等职务。'),	
		'pyh'	=>	array('mark'=>'pyh', 'name'=>'潘云鹤', 'position'=>'中国工程院常务副院长<br />中国工业设计协会名誉会长', 'swf'=>'http://static.video.qq.com/TPout.swf?vid=j0126snwg8a&auto=1', 'avatar'=>'jiyu/pyh.jpg', 'remark'=>'中国工程院院士，国际欧亚科学院院士。现兼任国务院学位委员会委员、中国科学技术协会顾问、中国图象图形学学会名誉理事长等职。曾任第十二届全国政协常委、外事委员会主任。'),	
	);
	if($mark=='all'){
		return $wish;
	}else{
		return$wish[$mark];
	}
}
