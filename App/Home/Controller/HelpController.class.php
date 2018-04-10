<?php
//help 
namespace Home\Controller;
class HelpController extends BaseController {

	function _initialize(){
		parent::_initialize();
		$this->assign('css_header_about', true);
    }

	function index() {
		$this->display();
	}

	//关于
	function about() {
		$this->assign('page_title', '关于十佳');
		$this->display();
	}

	//奖项设置
	function prize() {
		$this->assign('page_title', '奖项设置');
		$this->display();
	}

	//组织机构
	function institution() {
		$this->assign('page_title', '组织机构');
		$this->display();
	}

	//评审流程
	function workflow() {
		$this->assign('page_title', '评审流程');
		$this->display();
	}

	//参评办法
	function mode() {
		$this->assign('page_title', '参评办法');
		$this->display();
	}

	//推广提升
	function popularize() {
		$this->assign('page_title', '推广提升');
		$this->display();
	}
	//评委组成
	public function jury () {
		$this->assign('page_title', '评委组成');
		$this->assign('css_header_about', false);
		$this->assign('css_header_jury', true);

		$column_space = D('ColumnSpace')->where(array('mark'=>'help_jury_list'))->find();
		if($column_space) {
			$db = D('Columns');
			$count = $db->where(array('column_space_id'=>$column_space['id']))->count();
			$page = new \Think\Page($count, 12);
			$page->setConfig('theme',page_style());
			$limit = $page->firstRow . ',' . $page->listRows;
			$columns = D('Column')->where(array('column_space_id'=>$column_space['id']))->relation(true)->limit($limit)->select();
		}else{
			$this->error('栏目位不存在');
		}
		$this->assign('columns', $columns);
		$this->assign('page', $page->show());
		$this->display('jury');
	}
	//联系我们
	public function contact(){
		$this->assign('page_title', '联系我们');
		$this->assign('css_header_about', false);
		$this->assign('css_header_contact', true);
		$this->display();
	}
	//工作机会
	public function job(){
		$this->assign('page_title', '工作机会');
		$this->assign('css_header_about', false);
		$this->display();
	}
	//十佳年鉴
	public function year(){
		$this->assign('page_title', '十佳年鉴');
		$this->assign('css_header_about', false);
		$this->display();
	}
	//网站地图
	public function map(){
		$this->assign('page_title', '网站地图');
		$this->assign('css_header_about', false);
		$this->display();
	}
}
