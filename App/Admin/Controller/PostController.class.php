<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class PostController extends BaseController {

	//列表页
    public function index() {
		$count = D('Post')->where('deleted=0')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$posts = D('Post')->where('deleted=0')->relation(true)->order('id desc')->limit($limit)->select();
		$this->assign('posts',$posts);
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
			'title' => I('post.title', '', 'htmlspecialchars'),
			'category_id'	=>	I('post.category_id'),
			'description' => I('post.description', '', 'htmlspecialchars'),
			'content' => I('post.content'),
			'state'	=>	I('post.state'),
			'kind'	=>	I('post.kind'),
			'stick'	=>	I('post.stick'),
			'sort'	=>	I('post.sort'),
			'publish'	=>	I('post.publish'),
			'cover_id'	=> I('post.cover_id', '', ''),
			'user_id' => current_user_id()
		);

		$post = D('Post');
		if ($post->create($data)) {
			$result = $post->add();
			if ($result) {
				//关联表asset
				$asset = D('Asset');
				if(isset($data['cover_id'])) {
					$asset->where(array('id'=>intval($data['cover_id'])))->field('relateable_id')->save(array('relateable_id'=>$result));
				}
				//更新编辑器图片表的关联iD值
				if(!empty($_POST['asset_ids'])) {
					$asset_arr = explode(',', $_POST['asset_ids']);
					foreach($asset_arr as $k=>$v) {
						$asset->where(array('id'=>intval($v)))->field('relateable_id')->save(array('relateable_id'=>$result));
					}
				}
				$this->success('创建成功!', 'index');
			}else {
				$this->error('创建失败!');
			}
		}else {
			exit($post->getError());
		}
	}

	//编辑
	public function edit() {
		$post = D('Post')->relation(true)->find(I('get.id', '', intval));
		if($post) {
			$this->assign('post',$post);
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
				'title' => I('post.title', '', 'htmlspecialchars'),
				'category_id'	=>	I('post.category_id'),
				'description' => I('post.description', '', 'htmlspecialchars'),
				'content' => I('post.content'),
				'state'	=>	I('post.state'),
				'kind'	=>	I('post.kind'),
				'stick'	=>	I('post.stick'),
				'sort'	=>	I('post.sort'),
				'publish'	=>	I('post.publish'),
				'cover_id'	=> I('post.cover_id'),
			);
			$post = D('Post');
			$old_cover_id = I('post.old_cover_id');
			if($post->create($data)) {
				if($post->save()) {
					//删除旧的asset
					if(isset($old_cover_id) && $old_cover_id != $data['cover_id']) {
						D('Asset')->delete(intval($old_cover_id));
					}
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				exit($post->getError());
			}

		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax放入/恢复回收站
	public function mark_r_drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$post = D('Post');
		if(I('get.type')=='drop'){
			$val = 1;
		}elseif(I('get.type')=='recover'){
			$val = 0;
		}else{
			$val = 0;
		}
		//$post->deleted = $val;
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($post->where(array('id'=>intval($v)))->field('deleted')->save(array('deleted'=>$val))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

	//ajax恢复删除的内容(已调用上面方法)
	public function ajax_recover() {

	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$post = D('Post');
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($post->relation(false)->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

	//回收站列表
	public function recycle() {
		$count = D('Post')->where('deleted=1')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$posts = D('Post')->where('deleted=1')->relation(true)->order('id desc')->limit($limit)->select();
		$this->assign('posts',$posts);
		$this->assign('page', $page->show());
		$this->display();
	}

}
