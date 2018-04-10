<?php
//是否登录
function is_login() {
	$user = current_user();
	if($user == NULL){
		return false;
	}else{
		return true;
	}
}

//管理员权限
function is_admin() {
	$user = current_user();
	if($user != NULL && $user['role_id'] == 1) return true;
	return false;
}

//权限中转admin
function check_admin() {
	$user = current_user();
	if($user == NULL) {
		redirect(U('home/login/index'), 2, '请先登录');
	}elseif($user['role_id'] != 1) {
		redirect(U('home/index/index'), 2, '没有权限操作');
	}
}

//编辑权限
function is_edit() {
	$user = current_user();
	if($user != NULL && in_array($user['role_id'], array(1, 2))) return true;
	return false;
}

//权限中转edit
function check_edit() {
	$user = current_user();
	if($user == NULL ){
		redirect(U('home/login/index'), 2, '请先登录');
	}elseif(!in_array($user['role_id'], array(1, 2))) {
		redirect(U('home/index/index'), 2, '没有权限操作');
	}
}

//评委权限
function is_rater() {
		$user = current_user();
	if($user != NULL && in_array($user['role_id'], array(1, 3))) return true;
	return false;
}

//权限中转rater
function check_rater() {
	$user = current_user();
	if($user == NULL ){
		redirect(U('home/login/index'), 2, '请先登录');
	}elseif(!in_array($user['role_id'], array(1, 3))) {
		redirect(U('home/index/index'), 2, '没有权限操作');
	}
}

//普通用户权限
function is_user() {
	$user = current_user();
	if($user != NULL && in_array($user['role_id'], array(1, 2, 3, 9))) return true;
	return false;
}

//权限中转user
function check_user() {
	$user = current_user();
	if($user == NULL ){
		//echo alert_box();die;
		//echo "<script>\$(function(){\$('#alert_box').show();})</script>";
		redirect(U('home/login/index'), 2, '请先登录');
	}elseif(!in_array($user['role_id'], array(1, 2, 3, 9))) {
		redirect(U('home/index/index'), 2, '没有权限操作');
	}
}

//当前用户
function current_user() {
	$user = NULL;
	if(isset($_SESSION['uid']) && isset($_SESSION['token'])){
		$db = D('User');
		$user = $db->where(array('id'=>$_SESSION['uid']))->find();
		if($user) {
			$shell = md5($user['id'].$user['password'].C('DES_SESSION_KEY_TOKEN'));
			if($_SESSION['token'] != $shell){
				session_unset();
				$user = NULL;
			}
		return $user;
		}
	}
}

//当前用户ID
function current_user_id() {
	return $_SESSION['uid'];
}

function sign_out(){
	session_unset();
	session_destroy(); //销毁所有session
	redirect(U('home/index/index'), 2, '退出成功...');
}
