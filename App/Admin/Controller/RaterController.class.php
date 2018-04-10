<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class RaterController extends BaseController {

	function _initialize(){
		parent::_initialize();
		check_admin();
    }

	//列表页
    public function index() {
		$year = I('get.year', '', 'int');
		$state = I('get.state', '');
		$prize_id = I('get.prize_id', '', 'int');
		$state = I('get.state', '', 'int');
		$r_name = I('get.r_name', '');
		$order = I('get.order', '');
		$map = array();
		if(!empty($prize_id)) $map['prize_ids'] = array('LIKE', "%$prize_id%");
		if(!empty($year)) $map['year'] = $year;
		if(!empty($state)) $map['state'] = $state;
		if(!empty($r_name)) $map['name'] = $r_name;

		switch ($order)
		{
			case '':
			  $order_type = 'id desc';
			  break;  
			case 'create':
			  $order_type = 'id asc';
			  break;
			default:
		}

		$all_raters = D('Rater')->order('id desc')->select();

		$count = D('Rater')->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$raters = D('Rater')->where($map)->relation(array('user', 'asset'))->order($order_type)->limit($limit)->select();
		$rater_material = M('rater_material');
		$this->assign('raters',$raters);
		$this->assign('page', $page->show());
		$this->assign('prize_id',$prize_id);
		$this->assign('state',$state);
		$this->assign('year',$year);
		$this->assign('r_name', $r_name);
		$this->assign('order', $order);
		$this->assign('all_raters', $all_raters);
		$this->assign('rater_material', $rater_material);
		$this->display();
	}

	//添加页
	public function add() {
		$user_raters = D('User')->where('role_id=3 OR role_id=1 AND state=1')->select();
		$this->assign('user_raters', $user_raters);
		$this->display();
	}

	//创建页
	public function create() {

		if (!IS_Post) _404('页面不存在!', U('index'));
		$data = array(
			'name' => I('post.name', '', 'htmlspecialchars'),
			'user_id'	=>	I('post.user_id'),
			'url' => I('post.url'),
			'description' => I('post.description'),
			'year'	=>	I('post.year'),
			'state'	=>	I('post.state'),
			'kind'	=>	I('post.kind'),
			'sort'	=>	I('post.sort'),
			'avatar_id'	=> I('post.avatar_id', ''),
			'prize_ids'	=> implode(',', I('post.prize_ids', ''))
		);

		$rater = D('Rater');
		if ($rater->create($data)) {
			$result = $rater->add();
			if ($result) {
				//关联表asset
				$asset = D('Asset');
				if(isset($data['avatar_id'])) {
					$asset->where(array('id'=>intval($data['avatar_id'])))->field('relateable_id')->save(array('relateable_id'=>$result));
				}
				$this->success('创建成功!', 'index');
			}else {
				$this->error('创建失败!');
			}
		}else {
			exit($rater->getError());
		}
		
	
	}

	//编辑
	public function edit() {
		$rater = D('Rater')->relation(true)->find(I('get.id', '', intval));
		if($rater) {
			$this->assign('rater',$rater);
		}else{
			$this->error('内容不存在!');
		}
		$user_raters = D('User')->where('role_id=3 OR role_id=1 AND state=1')->select();
		$this->assign('user_raters', $user_raters);
		$this->display();
	}

	//更新
	public function update() {
		if(IS_POST) {
			$data = array(
				'id'	=> I('post.id', '', 'int'),
				'name' => I('post.name', '', 'htmlspecialchars'),
				'user_id'	=>	I('post.user_id'),
				'url' => I('post.url'),
				'description' => I('post.description'),
				'year'	=>	I('post.year'),
				'state'	=>	I('post.state'),
				'kind'	=>	I('post.kind'),
				'sort'	=>	I('post.sort'),
				'material_ids'	=>	html_entity_decode(I('post.material_ids', '', 'htmlspecialchars')),
				'avatar_id'	=> I('post.avatar_id', '', ''),
				'prize_ids'	=> implode(',', I('post.prize_ids', ''))
			);
			$rater = D('Rater');
			$old_avatar_id = I('post.old_avatar_id');
			if($rater->create($data)) {
				if($rater->save()) {
					//删除旧的asset
					if(isset($old_avatar_id) && $old_avatar_id != $data['avatar_id']) {
						D('Asset')->delete(intval($old_avatar_id));
					}
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				exit($rater->getError());
			}

		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$rater = D('Rater');
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


	//检测用户是否存在
	public function ajax_check_user() {
		$user = D('User')->find(I('get.user_id', '', 'int'));
		if($user){
			$result = '<span class="gray">存在此用户: '.$user['nickname']. '</span>';
		}else{
			$result = '<span class="red">用户不存在!</span>';
		}
		$this->ajaxReturn($result);
	}


	//导出
	public function export() {

		$type = I('get.id', '1', int);
		$id = I('get.id', '', 'int');
		$rater = D('Rater')->find($id);
		if(!empty($rater)){
			$this->push($rater, 'ShijiaRater');
		}
		exit;
	}

	//导出excel
	public function push($data, $name='ShijiaRater') {

		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		//date_default_timezone_set('Europe/London');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');


		/* 导入phpExcel核心类*/
		vendor('Excel.PHPExcel');
		//vendor('Excel.PHPExcel.Writer.Excel2007');
		//vendor('Excel.PHPExcel.IOFactory');

		// Create new PHPExcel object
		$objPHPExcel = new \PHPExcel();

		// Set document properties
		$user = current_user();
		$objPHPExcel->getProperties()->setCreator($user['nickname'])
									 ->setLastModifiedBy($user['nickname'])
									 ->setTitle("$name")
									 ->setSubject("rater")
									 ->setDescription("")
									 ->setKeywords("")
									 ->setCategory('rater');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '评委姓名');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '评选奖项');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '编号');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '企业名称/个人姓名＋就职单位＋职务');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '备注');

		$prize_arr = explode(',', $data['prize_ids']);
		$m = 2;
		$db = D('Material');
		foreach($prize_arr as $v)
		{

		    $m_ids = fetch_material_ids($data['material_ids'], $v);
		    $m_arr = explode(',', $m_ids);
		    foreach($m_arr as $vo)
		    {
			$material = $db->find(intval($vo));
			if(!empty($material))
			{
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$m, $data['id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$m, $data['name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$m, prize_name($v));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$m, $material['m_id']);
			    if(in_array($v, array(1,2,3)))
			    {
			    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$m, $material['name'].'/'.$material['unit'].'/'.$material['position']);
			    }else{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$m, $material['name']);	    
			    }
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$m, '');
			    $m++;	
			}
	
		    }

		}
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ShijiaData.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	}


}
