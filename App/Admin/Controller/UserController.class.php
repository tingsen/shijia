<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class UserController extends BaseController {
	
	function _initialize(){
		parent::_initialize();
		check_admin();
    }
	
	public function index() {
		$db = D('User');
		$count = $db->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$users = $db->limit($limit)->select();
		$this->assign('users',$users);
		$this->assign('page', $page->show());
		$this->display();
	}

	//评委列表
	public function rater_list() {
		$db = D('User');
		$count = $db->where('role_id=3')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$users = $db->where('role_id=3')->select();
		$this->assign('users',$users);
		$this->display('index');
	}

	//编辑列表
	public function edit_list() {
		$db = D('User');
		$count = $db->where('role_id=2')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$users = $db->where('role_id=2')->select();
		$this->assign('users',$users);
		$this->display('index');
	}

	//管理员列表
	public function admin_list() {
		$db = D('User');
		$count = $db->where('role_id=1')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$users = $db->where('role_id=1')->select();
		$this->assign('users',$users);
		$this->display('index');
	}
	
	//编辑
	public function edit(){
		check_admin();
		$db = D('User');
		$user = $db->where(array('id' => I('get.id', '', intval)))->find();
		if($user){
			$this->assign('user',$user);
			$this->display();
		}else{
			$this->error('没有该用户!');
		}
	}
	
	//更新
	public function update() {
		check_admin();
		if (!IS_POST) _404('页面不存在!', U('index'));
		if($_POST['role_id']) {
			$user = D('User');
			if($user->where(array('id' => I('id')))->setField('role_id',I('role_id'))) {
				$this->success('更新成功!', U('index'));
			}else{
				$this->error($user->getError());
			}
		}else{
			$this->error('内容不存在!');
		}
	}
	
	public function activate(){
		$user = D('User');
		$db = $user->where(array('id' => I('get.id', '', intval)))->find();
		if($db){
			$user->where(array('id' => I('id', '', intval)))->setField('activation',2);
			redirect(U('user/index'), 1, '激活成功...');
		}else{
			$this->error('没有该用户!');
		}
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$rater = D('User');
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($rater->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}
}
?>
