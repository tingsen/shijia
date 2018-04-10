<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class AssetController extends BaseController {

	//列表页
    public function index() {
		$count = D('Asset')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$assets = D('Asset')->relation(true)->order('id desc')->limit($limit)->select();
		$this->assign('assets',$assets);
		$this->assign('page', $page->show());
		$this->display();
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$asset = D('Asset');
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			$asset_obj = $asset->find(intval($v));
			$url = $asset_obj['file_path'] . $asset_obj['file_name'];
			if ($asset->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
				//同时删除附件
				unlink(absolute_upload_path($url));
			}	
		}
		$this->ajaxReturn($result); 
	}

}
