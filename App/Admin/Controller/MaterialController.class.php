<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
//use Think\Controller;
class MaterialController extends BaseController {

	function _initialize(){
		parent::_initialize();
		check_admin();
    }

	//列表页--全部
    public function index() {
		$this->redirect('list_p');
		$this->display();
	}

	//列表
	public function list_p() {
		$year = I('get.year', '', 'int');
		$prize_id = I('get.prize_id', '', 'int');
		$state = I('get.state', '', 'int');
		$voted = I('get.voted', '', 'int');
		$province = I('get.province', '', 'int');
		$order = I('get.order', '');
		$map = array();
		if(!empty($year)) $map['year'] = $year;
		if(!empty($prize_id)) $map['prize_id'] = $prize_id;
		if(!empty($state) || $state===0) $map['state'] = $state;
		if(!empty($province)) $map['province'] = $province;
		if($voted===0){
			$map['chosen_count'] = array('elt', 0);
		}elseif($voted===1){
			$map['chosen_count'] = array('gt', 0);
		}

		switch ($order)
		{
			case '':
			  $order_type = 'id desc';
			  break;  
			case 'vote':
			  $order_type = 'chosen_count desc';
			  break;
			case 'number':
			  $order_type = 'm_id asc';
			  break;
			default:
		}
		$material_rater = M('rater_material');
		$rater_m = D('Rater');
		$count = D('Material')->where($map)->count();
		$page = new \Think\Page($count, per_p());
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$materials = D('Material')->field('remark', true)->where($map)->relation(true)->order($order_type)->limit($limit)->select();
		$this->assign('materials',$materials);
		$this->assign('year',$year);
		$this->assign('prize_id',$prize_id);
		$this->assign('state',$state);
		$this->assign('province', $province);
		$this->assign('voted', $voted);
		$this->assign('order', $order);
		$this->assign('material_rater', $material_rater);
		$this->assign('rater_m', $rater_m);
		$this->assign('page', $page->show());
		$this->display('index');
	}

	//详情页
	public function show() {
		$id = I('get.id', '', 'int');
		$material = D('Material')->relation(true)->find($id);
		if($material) {

		}else{
			$this->error('内容不存在!');
		}
		$this->assign('material', $material);
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
			'm_id' => I('post.m_id'),
			'name' => I('post.name', '', 'htmlspecialchars'),
			'year'	=>	I('post.year', '', 'int'),
			'prize_id'	=>	I('post.prize_id', '', 'int'),
			'remark' => I('post.remark'),
			'web_url' => I('post.web_url'),
			'state'	=>	I('post.state'),
			'unit'	=>	I('post.unit'),
			'sort'	=>	I('post.sort'),
			'cover_id'	=> I('post.cover_id'),
			'user_id'	=>	I('post.user_id', '', 'int'),
			'position'	=>	I('post.position'),
		);

		$material = D('Material');
		if ($material->create($data)) {
			$result = $material->add();
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
			exit($material->getError());
		}
	}
	
	//编辑
	public function edit() {
		$material = D('Material')->relation(true)->find(I('get.id', '', intval));
		if($material) {
			$this->assign('material',$material);
		}else{
			$this->error('内容不存在!');
		}

		$this->display();
	}
	
	//更新
	public function update() {
		if(I('post.id')) {
			$data = array(
				'id'	=> I('post.id', '', 'int'),
				'm_id' => I('post.m_id'),
				'name' => I('post.name', '', 'htmlspecialchars'),
				'year'	=>	I('post.year', '', 'int'),
				'prize_id'	=>	I('post.prize_id', '', 'int'),
				'remark' => I('post.remark'),
				'web_url' => I('post.web_url'),
				'state'	=>	I('post.state'),
				'sort'	=>	I('post.sort'),
				'unit'	=>	I('post.unit'),
				'cover_id'	=> I('post.cover_id'),
				'user_id'	=>	I('post.user_id', '', 'int'),
				'position'	=>	I('post.position'),
			);
			$old_cover_id = I('post.old_cover_id');
			$material = D('Material');
			if($material->create($data)) {
				if($material->save()) {
					//删除旧的asset
					if(isset($old_cover_id) && $old_cover_id != $data['cover_id']) {
						D('Asset')->delete(intval($old_cover_id));
					}
					$this->success('更新成功!', U('index'));
				}else{
					$this->error('更新失败!');
				}
			}else{
				$this->error($user->getError());
			}
		}else{
			$this->error('内容不存在!');
		}
	}

	//ajax修改状态
	public function ajax_set_state() {
		if (!IS_AJAX) halt('页面不存在!');
		$material = D('Material');
		if(I('get.type')=='reject'){
			$val = 1;
		}elseif(I('get.type')=='pass'){
			$val = 0;
		}else{
			$val = 0;
		}
		//$post->deleted = $val;
		$ids_arr = explode(',', I('get.ids'));
		$result['state'] = 0;
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($material->where(array('id'=>intval($v)))->field('state')->save(array('state'=>$val))) {
				$result['state'] = 1;
				array_push($result['ids'] ,$v);
			}	
		}
		$this->ajaxReturn($result); 
	}

	//ajax删除
	public function drop() {
		if (!IS_AJAX) halt('页面不存在!');
		$material = D('Material');
		$ids_arr = explode(',', I('get.ids'));
		$result['ids'] = array();
		foreach ($ids_arr as $k=>$v) {
			if ($material->relation(false)->delete(intval($v))) {
				$result['state'] = 1;
				array_push($result['ids'], $v);
			}	
		}
		$this->ajaxReturn($result); 
	}

	//导出
	public function export() {

		$year = I('get.year', '', 'int');
		$prize_id = I('get.prize_id', '', 'int');
		$state = I('get.state', '', 'int');
		$order = I('get.order', '');
		$province = I('get.province', '', 'int');
		$voted = I('get.voted', '', 'int');

		$map = array();

		if(!empty($year)) $map['year'] = $year;
		if(!empty($prize_id)) $map['prize_id'] = $prize_id;
		if(!empty($state) || $state===0) $map['state'] = $state;
		if(!empty($province)) $map['province'] = $province;
		if($voted===0){
			$map['chosen_count'] = array('elt', 0);
		}elseif($voted===1){
			$map['chosen_count'] = array('gt', 0);
		}

		switch ($order)
		{
			case '':
			  $order_type = 'id desc';
			  break;  
			case 'vote':
			  $order_type = 'chosen_count desc';
			  break;
			case 'number':
			  $order_type = 'm_id asc';
			  break;
			default:
		}

		$materials = D('Material')->field(array('remark'), true)->where($map)->relation(false)->order($order_type)->select();
		$this->push($materials, $prize_id, 'ShijiaData');
		exit;
	}

	//导出excel
	public function push($data, $prize, $name='ShijiaData') {

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
									 ->setSubject("shijia")
									 ->setDescription("")
									 ->setKeywords("")
									 ->setCategory($prize);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '编号');

		switch ($prize) 
		{
		    case 1:
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '姓别');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '最高学历');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '出生日期');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '工作年限');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '现职单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '职称');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '行政职务');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '研究专业');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '手机');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '联系人姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '联系人电话');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '联系人邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '推荐单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '投票数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '评委');

		    break;
		    case 2:
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '姓别');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '最高学历');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '出生日期');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '工作年限');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '现职单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '职务');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '手机');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '联系人姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '联系人电话');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '联系人邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '推荐单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '投票数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '评委');
		    break;

		    case 3:
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '姓别');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '最高学历');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '出生日期');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '工作年限');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '现职单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '职务');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '手机');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '联系人姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '联系人电话');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '联系人邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '推荐单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '投票数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '评委');
		    break;

		    case 4:
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '企业名称');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '业务范围');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '所有制性质');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '网址');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '法定代表人');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '成立时间');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '设计总监');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '职工总数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '设计师人数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '资产总额（万元）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '年营业额（万元）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '工业设计服务收入（万元）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '工业设计服务项目（个）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '联系人姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '联系人电话');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '联系人邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '推荐单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '投票数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '评委');
		    break;

		    case 5:
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '企业名称');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '业务范围');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '所有制性质');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '网址');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '法定代表人');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '成立时间');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '设计部门负责人');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '职工总数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '工业设计人数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '资产总额（万元）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '年销售收入（万元）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '研发投入（万元）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '工业设计投入（万元）');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '联系人姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '联系人电话');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '联系人邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '推荐单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '投票数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '评委');
		    break;

		    default:
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '单位/个人(名称)');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '年份(届)');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '所属奖项');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '联系人姓名');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '联系人电话');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '联系人邮箱');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '推荐单位');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '投票数');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '评委');

		}

		// Miscellaneous glyphs, UTF-8
		// 行数
		$n = 2;
		$mrs_obj = M('rater_material');
		$rater_obj = D('Rater');
		switch ($prize) 
		{
		    case 1:

			foreach($data as $k=>$v)
			{
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $v['id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $v['m_id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $v['name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, sex_name($v['sex']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, scope_name($v['design_count']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $v['founded']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $v['nature']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $v['unit']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $v['position']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $v['administration_post']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $v['major']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$n, $v['tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$n, $v['email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$n, $v['contact_name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$n, $v['contact_tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, $v['contact_email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, $v['introduction']);
				if($v['chosen_count']>0){
					$mrs = $mrs_obj->where(array('mid'=>$v['id']))->select();
					$raters = array();
					foreach($mrs as $r){
						$rater = $rater_obj->find($r['rid']);
						array_push($raters, $rater['name']);
					}
					$raters_str = join('|', $raters);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$n, $v['chosen_count']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$n, $raters_str);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$n, 0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$n, '');
				}
			    $n++;
			}
		    break;

		    case 2:
			foreach($data as $k=>$v)
			{
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $v['id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $v['m_id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $v['name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, sex_name($v['sex']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, scope_name($v['design_count']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $v['founded']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $v['nature']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $v['unit']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $v['position']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $v['tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $v['email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$n, $v['contact_name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$n, $v['contact_tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$n, $v['contact_email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$n, $v['introduction']);
				if($v['chosen_count']>0){
					$mrs = $mrs_obj->where(array('mid'=>$v['id']))->select();
					$raters = array();
					foreach($mrs as $r){
						$rater = $rater_obj->find($r['rid']);
						array_push($raters, $rater['name']);
					}
					$raters_str = join('|', $raters);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, $v['chosen_count']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, $raters_str);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, 0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, '');
				}
			    $n++;
			}
		    break;

		    case 3:
			foreach($data as $k=>$v)
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $v['id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $v['m_id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $v['name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, sex_name($v['sex']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, scope_name($v['design_count']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $v['founded']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $v['nature']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $v['unit']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $v['position']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $v['tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $v['email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$n, $v['contact_name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$n, $v['contact_tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$n, $v['contact_email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$n, $v['introduction']);
				if($v['chosen_count']>0){
					$mrs = $mrs_obj->where(array('mid'=>$v['id']))->select();
					$raters = array();
					foreach($mrs as $r){
						$rater = $rater_obj->find($r['rid']);
						array_push($raters, $rater['name']);
					}
					$raters_str = join('|', $raters);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, $v['chosen_count']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, $raters_str);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, 0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, '');
				}
			    $n++;
			}
		    break;

		    case 4:
			foreach($data as $k=>$v)
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $v['id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $v['m_id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $v['name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, $v['scope']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, nature_name($v['nature']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $v['web_url']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $v['legal_preson']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $v['founded']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $v['head_preson']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $v['staff_count']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $v['design_count']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$n, $v['total_assets']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$n, $v['annual_revenue']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$n, $v['rd_put']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$n, $v['id_put']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, $v['contact_name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, $v['contact_tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$n, $v['contact_email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$n, $v['introduction']);
				if($v['chosen_count']>0){
					$mrs = $mrs_obj->where(array('mid'=>$v['id']))->select();
					$raters = array();
					foreach($mrs as $r){
						$rater = $rater_obj->find($r['rid']);
						array_push($raters, $rater['name']);
					}
					$raters_str = join('|', $raters);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$n, $v['chosen_count']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$n, $raters_str);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$n, 0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$n, '');
				}
			    $n++;
			}
		    break;

		    case 5:
			foreach($data as $k=>$v)
			{
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $v['id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $v['m_id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $v['name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, $v['scope']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, nature_name($v['nature']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $v['web_url']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $v['legal_preson']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $v['founded']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $v['head_preson']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $v['staff_count']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $v['design_count']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$n, $v['total_assets']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$n, $v['annual_revenue']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$n, $v['rd_put']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$n, $v['id_put']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, $v['contact_name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, $v['contact_tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$n, $v['contact_email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$n, $v['introduction']);
				if($v['chosen_count']>0){
					$mrs = $mrs_obj->where(array('mid'=>$v['id']))->select();
					$raters = array();
					foreach($mrs as $r){
						$rater = $rater_obj->find($r['rid']);
						array_push($raters, $rater['name']);
					}
					$raters_str = join('|', $raters);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$n, $v['chosen_count']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$n, $raters_str);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$n, 0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$n, '');
				}
			    $n++;
			}
		    break;

		    default:
			foreach($data as $k=>$v)
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$n, $v['id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $v['m_id']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $v['name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, $v['year']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, prize_name($v['prize_id']));
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $v['contact_name']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $v['contact_tel']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $v['contact_email']);
			    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $v['introduction']);
				if($v['chosen_count']>0){
					$mrs = $mrs_obj->where(array('mid'=>$v['id']))->select();
					$raters = array();
					foreach($mrs as $r){
						$rater = $rater_obj->find($r['rid']);
						array_push($raters, $rater['name']);
					}
					$raters_str = join('|', $raters);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $v['chosen_count']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $raters_str);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, 0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, '');
				}
			    $n++;
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
