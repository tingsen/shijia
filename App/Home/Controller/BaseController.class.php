<?php
/**
 * +-----------------------
 * 公用类，继承Controller
 * +----------------------
 */
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{
    /**
     * +----------------
     * 告诉浏览器，程序的编码为utf8,防止出现乱码
     * +----------------
     */
	function _initialize(){
		//已在入口定义
        //header('Content-Type:text/html;charset=utf-8');//告诉浏览器这个文件时一个html文件，编码是utf-8
    }
}
?>
