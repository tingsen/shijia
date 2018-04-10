<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class ColumnSpaceController extends BaseController {

	function _initialize(){
		parent::_initialize();
		check_admin();
    }

	//列表页
    public function index() {

		$count = D('ColumnSpace')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$column_spaces = D('ColumnSpace')->relation(true)->order('id desc')->limit($limit)->select();
		$this->assign('column_spaces',$column_spaces);
		$this->assign('page', $page->show());
		$this->display();
	}

	//详情页
	public function show() {
		$this->display();
	}

	//添加页
	public function add() {
		$this->display();
	}

	//创建页
	public function create() {

		if (!IS_POST) _404('页面不存在!', U('index'));
		$data = array(
			'name' => I('post.name', '', 'htmlspecialchars'),
			'mark' => I('post.mark', '', 'htmlspecialchars'),
			'content' => I('post.content'),
			'remarks' => I('post.remarks'),
			'state'	=>	I('post.state'),
			'width'	=>	I('post.width'),
			'height'	=>	I('post.height'),
			'kind'	=> I('post.kind',1, 'int'),
			'user_id'	=> current_user_id()
		);

		$column_space = D('ColumnSpace');
		if ($column_space->create($data)) {
			$result = $column_space->add();
			if ($result) {
				$this->success('创建成功!', 'index');
			}else {
				$this->error('创建失败!');
			}
		}else {
			exit($column_space->getError());
		}
		
	
	}

	//编辑
	public function edit() {
		$column_space = D('ColumnSpace')->relation(true)->find(I('get.id', '', intval));
		if($column_space) {
			$this->assign('column_space',$column_space);
		}else{
			$column_space = NULL;
			$this->error('内容不存在!');
		}

		$this->display();
	}

	//更新
	public function update() {
		if(IS_POST) {
			$data = array(
				'id'	=> I('post.id'),
				'name' => I('post.name', '', 'htmlspecialchars'),
				'mark' => I('post.mark', '', 'htmlspecialchars'),
				'content' => I('post.content'),
				'remarks' => I('post.remarks'),
				'state'	=>	I('post.state'),
				'width'	=>	I('post.width'),
				'height'	=>	I('post.height'),
				'kind'	=> I('post.kind',1, 'int'),
			);
			$column_space = D('ColumnSpace');
			$old_cover_id = I('column_space.old_cover_id');
			if($column_space->create($data)) {
				if($column_space->save()) {
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				exit($column_space->getError());
			}

		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$column_space = D('ColumnSpace');
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($column_space->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

}
