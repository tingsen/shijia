<?php
// 历届十佳
namespace Home\Controller;
//use Think\Controller;
class HistoryController extends BaseController {

	function _initialize(){
		parent::_initialize();
		//check_rater();
		$this->assign('css_header_history', true);
    }

	public function index() {
		$prize_id = I('get.prize_id', '5', 'int');
		$year = I('get.year', '2013', 'int');
		$this->redirect('list_apply', array('prize_id'=>$prize_id, 'year'=>$year));
	}

	//详情
	public function show() {
		$id = I('get.id', '', 'int');
		$material = D('Material')->relation('avatar')->find($id);
		if($material) {
			if($material['state']==0) $this->error('该内容已禁用!');
		}else{
			$this->error('内容不存在!');
		}

		$this->assign('material', $material);
		$this->assign('page_title', $material['name']);
		$this->assign('prize_id', $material['prize_id']);
		$this->assign('year', $material['year']);
		$this->display();
	}

	//带参数列表
	public function list_apply() {
		$prize_id = I('get.prize_id', '', 'int');
		$year = I('get.year', '', 'int');
		$map = array('year'=>$year, 'prize_id'=>$prize_id, 'state'=>11);
		$materials = D('Material')->where($map)->relation(array('avatar'))->order('sort desc, id desc')->limit(0,10)->select();
		$this->assign('materials', $materials);
		$this->assign('prize_id', $prize_id);
		$this->assign('year', $year);
		$this->display('index');
	}

}
