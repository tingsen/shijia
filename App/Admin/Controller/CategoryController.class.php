<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class CategoryController extends BaseController {

	function _initialize(){
		parent::_initialize();
		check_admin();
    }

	//列表页--全部
    public function index() {

		$count = D('Category')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$categories = D('Category')->order('id desc')->limit($limit)->select();
		$this->assign('categories',$categories);
		$this->assign('page', $page->show());
		$this->display();
	}

	//列表页--新闻
    public function news() {

		$count = D('Category')->where('kind=1')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$categories = D('Category')->where('kind=1')->order('id desc')->limit($limit)->select();
		$this->assign('categories',$categories);
		$this->assign('page', $page->show());
		$this->display('index');
	}

	//列表页--奖项
    public function prize() {

		$count = D('Category')->where('kind=2')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$categories = D('Category')->where('kind=2')->order('id desc')->limit($limit)->select();
		$this->assign('categories',$categories);
		$this->assign('page', $page->show());
		$this->display('index');
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
			'description' => I('post.description'),
			'state'	=>	I('post.state'),
			'kind'	=>	I('post.kind'),
			'stick'	=>	I('post.stick'),
			'sort'	=>	I('post.sort'),
			'pid'	=>	I('post.pid'),
			'user_id' => current_user_id(),
		);

		$category = D('Category');
		if ($category->create($data)) {
			$result = $category->add();
			if ($result) {
				$this->success('创建成功!', 'index');
			}else {
				$this->error('创建失败!');
			}
		}else {
			exit($category->getError());
		}
	}

	//编辑
	public function edit() {
		$category = D('Category')->find(I('get.id', '', intval));
		if($category) {
			$this->assign('category',$category);
		}else{
			$category = NULL;
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
				'description' => I('post.description'),
				'state'	=>	I('post.state'),
				'kind'	=>	I('post.kind'),
				'stick'	=>	I('post.stick'),
				'sort'	=>	I('post.sort'),
				'pid'	=>	I('post.pid')
			);
			$category = D('Category');
			if($category->create($data)) {
				if($category->save()) {
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				exit($category->getError());
			}

		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$category = D('Category');
		$category->deleted = $val;
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($category->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

}
