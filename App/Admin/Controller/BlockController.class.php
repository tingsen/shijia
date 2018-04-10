<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class BlockController extends BaseController {

	//列表页
    public function index() {

		$count = D('Block')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$blocks = D('Block')->relation(true)->order('id desc')->limit($limit)->select();
		$this->assign('blocks',$blocks);
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
			'kind'	=> I('post.kind',1, 'int'),
			'user_id'	=> current_user_id(),
		);

		$block = D('Block');
		if ($block->create($data)) {
			$result = $block->add();
			if ($result) {
				//更新编辑器图片表的关联iD值
				if(!empty($_POST['asset_ids'])) {
					$asset_arr = explode(',', $_POST['asset_ids']);
					//关联表asset
					$asset = D('Asset');
					foreach($asset_arr as $k=>$v) {
						$asset->where(array('id'=>intval($v)))->field('relateable_id')->save(array('relateable_id'=>$result));
					}
				}
				$this->success('创建成功!', 'index');
			}else {
				$this->error('创建失败!');
			}
		}else {
			exit($block->getError());
		}
		
	
	}

	//编辑
	public function edit() {
		$block = D('Block')->find(I('get.id', '', intval));
		if($block) {
			$this->assign('block',$block);
		}else{
			$block = NULL;
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
				'kind'	=> I('post.kind',1, 'int'),
			);
			$block = D('Block');
			if($block->create($data)) {
				if($block->save()) {
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				exit($block->getError());
			}

		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$block = D('Block');
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($block->relation(false)->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

}
