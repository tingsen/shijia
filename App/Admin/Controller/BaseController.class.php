<?php
/**
 * +-----------------------
 * 公用类，继承Controller
 * +----------------------
 */
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
    /**
     * 告诉浏览器，程序的编码为utf8,防止出现乱码
     */
	function _initialize(){
		//必须编辑权限
		check_edit();
	}
}
?>
