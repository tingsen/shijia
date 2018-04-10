<?php
//用户中心
//需要验证是否为用户自己
namespace Home\Controller;
class UserController extends BaseController {
	
	function _initialize(){
		parent::_initialize();
    }

	//编辑用户
	public function edit(){
		check_user();
		$this->display();
	}
	
	public function update(){
		check_user();
		$db = D('User');
		$data = array(
			'id' => I('session.uid'),
			'nickname' => I('post.nickname','','htmlspecialchars'),
			'password' => I('post.password'),
			'repassword' => I('post.repassword')
		);
		if(!$db->create($data)){
			$this->error($db->getError());
		}else{
			$db->save();
			session('name',I('post.nickname','','htmlspecialchars'));
			$this->success('修改成功!', U('home/index/index'));
		}
	}
	
	//申请奖项列表
	public function lists(){
		check_user();
		$map['user_id'] = $_SESSION['uid'];
		$count = D('Material')->where($map)->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$materials = D('Material')->where($map)->field('remark', true)->relation(true)->order('id desc')->limit($limit)->select();
		$this->assign('materials',$materials);
		$this->assign('page', $page->show());
		$this->display();
	}
	
	public function delete(){
		check_user();
		$map['id'] = I('get.id');
		$map['user_id'] = $_SESSION['uid'];
		if(D('Material')->where($map)->delete()){
			$this->success('删除成功!', U('lists'));
		}else{
			$this->error('没有这个记录', U('lists'));
		}
	}

}
