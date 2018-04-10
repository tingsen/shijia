<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {

    public function index(){
		$user_count = D('User')->count();
		$post_count = D('Post')->where(array('deleted'=>0, 'kind'=>1))->count();
		$promotion_count = D('Post')->where(array('deleted'=>0, 'kind'=>2))->count();
		$rater_count = D('Rater')->count();
		$material_count = D('Material')->count();
		$asset_count = D('Asset')->count();
		$data = array(
			'user_count'		=>	$user_count,
			'post_count'		=>	$post_count,
			'promotion_count'	=>	$promotion_count,
			'rater_count'		=>	$rater_count,
			'material_count'	=>	$material_count,
			'asset_count'		=>	$asset_count,
		);
		$this->assign('collect', $data);
		$this->display();
	}

}
