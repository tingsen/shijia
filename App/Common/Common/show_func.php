<?php

function p ($array) {
	dump($array, 1, '<pre>', 0);
}

//分页数量
function per_p() {
	return 20;
}

//网页标题
function page_title($title, $type=1) {
	$base_title = '中国工业设计十佳大奖';
	if(isset($title) && !empty($title)) {
		return $title . '|' . $base_title;
	}else{
		return $base_title;
	}
}

//判断css是否选中---current
function css_current($active) {
	if($active) return 'current';
	return '';
}

//获取controller名称
function controller() {
	$path = __CONTROLLER__;
	return end(explode('/', $path));
}

//获取action名称
function action() {
	$path = __ACTION__;
	return end(explode('/', $path));
}

//分页样式
function page_style() {
	return "<li>%UP_PAGE%</li><li>%FIRST%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a>%HEADER% %NOW_PAGE%/%TOTAL_PAGE% 页</a></li>";
}

//截取字符串...
function msubstr($str, $start = 0, $length, $charset ="utf-8", $suffix = true) {
	if($charset=="utf-8"){
		$len = strlen($str)/3;
	}
	if (function_exists ( "mb_substr" ))
	if($suffix && $len>$length)
		return mb_substr ( $str, $start, $length, $charset )."...";
	else
		return mb_substr ( $str, $start, $length, $charset );
	elseif (function_exists ( 'iconv_substr' )) {
		if($suffix && $len>$length)
		return iconv_substr ( $str, $start, $length, $charset )."...";
	else
		return iconv_substr ( $str, $start, $length, $charset );
	}
	$re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all ( $re [$charset], $str, $match );
	$slice = join ( "", array_slice ( $match [0], $start, $length ) );
	if ($suffix) return $slice . "...";
	return $slice;
}

//图片显示路径
function img_path($path) {
	return __ROOT__ . '/Uploads/' . $path;
}

//加载栏目
function load_column($mark, $limit=8) {
	$space = D('ColumnSpace')->where(array('mark'=>$mark, 'state'=>1))->field('id')->find();
	if($space) {
		$columns = D('Column')->where(array('column_space_id'=>$space['id'], 'state'=>1))->relation('asset')->order('sort desc,id desc')->select();
		if(!empty($columns)) {
			return $columns;
		}	
	}
	return array();
}

//城市列表
function city_options($pid=0001) {
	$sql = "select * from city where `pid`=$pid";
	$city = M('city')->query($sql);
	return $city;
}

//通过城市ID加载城市名称
function show_city($id) {
	$sql = "select * from city where `id`=$id";
	$city = M('city')->query($sql);
	return $city[0]['name'] | '';
}

//加载区块儿内容
function load_block($mark, $code = false) {
	$block = D('Block')->where(array('mark'=>$mark, 'state'=>1))->find();
	if($block) {
		$match = '/\[code\](.*)\[\/code\]/s';
		if($code) {
			preg_match($match, html_entity_decode($block['content']), $result);
			return $result[1]; 
		}else{
			return html_entity_decode($block['content']);
		}
	}else{
		return '';
	}
}

//通过post 类型显示不同路径
function post_url($id, $kind=1) {
	if($kind==1) {
		$url = U('home/post/show', array('id'=>$id));
	}else if($kind==2) {
		$url = U('home/post/show', array('id'=>$id));
	}
	return $url;
}

//显示警示框
function alert_box() {
	return "<script>\$(function(){\$('#alert_box').show();})</script>";
}

//转换为utf-8
function convertUTF8($str)
{
   if(empty($str)) return '';
   return  iconv('gb2312', 'utf-8', $str);
}
