<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class SystemController extends BaseController {

	function _initialize(){
		parent::_initialize();
		check_admin();
    }

	//列表页
    public function index() {

		$count = D('System')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$systems = D('System')->order('id desc')->limit($limit)->select();
		$this->assign('systems',$systems);
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
			'mark' => I('post.mark'),
			'state'	=>	I('post.state'),
			'kind'	=>	I('post.kind'),
			'value'	=>	I('post.value'),
			'user_id' => current_user_id(),
		);

		$system = D('System');
		if ($system->create($data)) {
			$result = $system->add();
			if ($result) {
				$this->success('创建成功!', 'index');
			}else {
				$this->error('创建失败!');
			}
		}else {
			exit($system->getError());
		}
	}

	//编辑
	public function edit() {
		$system = D('System')->find(I('get.id', '', intval));
		if($system) {
			$this->assign('system',$system);
		}else{
			$this->error('内容不存在!');
		}

		$this->display();
	}

	//更新
	public function update() {
		if(IS_POST) {
			$data = array(
				'id'	=> I('post.id', '', 'int'),
				'name' => I('post.name', '', 'htmlspecialchars'),
				'mark' => I('post.mark'),
				'state'	=>	I('post.state'),
				'kind'	=>	I('post.kind'),
				'value'	=>	I('post.value'),
				'user_id' => current_user_id(),
			);
			$system = D('System');
			if($system->create($data)) {
				if($system->save()) {
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				exit($system->getError());
			}

		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$system = D('System');
		$system->deleted = $val;
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($system->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

}
