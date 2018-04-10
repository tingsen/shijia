<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class ColumnController extends BaseController {

	//列表页
    public function index() {

		$count = D('Column')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$columns = D('Column')->relation(true)->order('id desc')->limit($limit)->select();
		$this->assign('columns',$columns);
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
			'address'	=>	I('post.address', '', 'htmlspecialchars'),
			'content' => I('post.content'),
			'state'	=>	I('post.state', 1, 'int'),
			'kind'	=>	I('post.kind', 1, 'int'),
			'remarks'	=>	I('post.remarks'),
			'column_space_id'	=> I('post.column_space_id'),
			'sort' => I('post.sort', 0, 'int'),
			'cover_id'	=> I('post.cover_id', '', 'int'),
			'user_id' => current_user_id()
		);

		$column = D('Column');
		if ($column->create($data)) {
			$result = $column->add();
			if ($result) {
				//关联表asset
				$asset = D('Asset');
				if(I('post.cover_id')) {
					$asset->where(array('id'=>intval(I('post.cover_id'))))->field('relateable_id')->save(array('relateable_id'=>$result));
				}

				$this->success('创建成功!', 'index');
			}else {
				$this->error('创建失败!');
			}
		}else {
			exit($column->getError());
		}
		
	
	}

	//编辑
	public function edit() {
		$column = D('Column')->relation(true)->find(I('get.id', '', intval));
		if($column) {
			$this->assign('column',$column);
		}else{
			$column = NULL;
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
				'address'	=>	I('post.address', '', 'htmlspecialchars'),
				'content' => I('post.content'),
				'state'	=>	I('post.state', 1, 'int'),
				'kind'	=>	I('post.kind', 1, 'int'),
				'remarks'	=>	I('post.remarks'),
				'column_space_id'	=> I('post.column_space_id'),
				'sort' => I('post.sort', 0, 'int'),
				'cover_id'	=> I('post.cover_id', '', 'int'),
			);
			$column = D('Column');
			$old_cover_id = I('post.old_cover_id');
			if($column->create($data)) {
				if($column->save()) {
					//删除旧的asset
					if(!empty($old_cover_id) && $old_cover_id != I('post.cover_id')) {
						D('Asset')->delete(intval($old_cover_id));
					}
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				exit($column->getError());
			}

		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$column = D('Column');
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($column->relation(false)->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

	//ajax获取栏目位宽高
	public function ajax_show_size() {
		if (!IS_AJAX) halt('页面不存在!');
		$sid = I('get.sid', '', 'int');
		$space = D('ColumnSpace')->find($sid);
		if($space) {
			$data = '图片比例: '. $space['width'] .'x'. $space['height'];
		}else{
			$data = '栏目位不存在';
		}
		$this->ajaxReturn($data);
	}

}
