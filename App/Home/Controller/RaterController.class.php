<?php
// 专家评选
namespace Home\Controller;
//use Think\Controller;
class RaterController extends BaseController {

	function _initialize(){
		parent::_initialize();
		$this->assign('css_header_rater', true);
    }

	public function index() {
		check_rater();
		//$materials = D('Material')->where('prize_id=5')->order('id asc')->limit(1,10)->select();
		//p($materials);
		$this->display();
	}

	// 寄语 
	public function wish() {
		$mark = I('get.mark');
		$wish = leader_wish($mark);
		if(!isset($wish)) $this->error('内容不存在!');
		$this->assign('wish', $wish);
		$this->display();
	}

	//选择奖项
	public function chose_prize() {
		check_rater();
		$this->display();
	}

	//申请者列表
	public function materials() {
		check_rater();
		$prize_id = I('get.prize_id', '', 'int');
		if(empty($prize_id)) $this->error('奖项不存在!');
		$user = current_user();
		$rater = D('Rater')->where(array('user_id'=>$user['id']))->find();
		if(empty($rater)) $this->error('没有权限!');
		$prize_state = fetch_material_state($rater['material_ids'], $prize_id);
		$materials = fetch_material_ids($rater['material_ids'], $prize_id);
		$map['prize_id'] = array($prize_id);
		$map['year'] = system_value('current_year');
		$map['state'] = 10;
		//求总数
		$total_count = D('Material')->where($map)->count();
		$result = array('total_count'=>$total_count, 'prize_id'=>$prize_id, 'material_ids'=>$materials, 'prize_state'=>$prize_state);
		$this->assign('rater', $rater);
		$this->assign('result', $result);
		$this->display();
	}
	
	//ajax获取申请信息
	public function ajax_fetch_materials() {
		check_rater();
		if (!IS_AJAX) halt('页面不存在!');
		$prize_id = I('post.prize_id', '', 'int');
		$material_ids = I('post.material_ids');
		$page = I('post.page', 1, 'int');
		$per = I('post.per', 10, 'int');
		$type = I('post.type', 1, 'int');
		$map['prize_id'] = array($prize_id);
		//左侧不动
		//$map['id'] = array('not in', $material_ids);
		$map['year'] = system_value('current_year');
		$map['state'] = 10;
		$p = ($page-1) * $per;
		$materials = D('Material')->where($map)->relation('avatar')->order('m_id asc,id asc')->limit($p, $per)->select();
		$this->assign('data', $materials);
		$this->assign('prize_id', $prize_id);
		$this->assign('material_ids', $material_ids);
		$this->assign('current_page', $page);
		$this->assign('left_type', $type);
		layout(false);
		$this->display();
	}

	//ajax获取已选申请信息
	public function ajax_fetch_checked_materials() {
		check_rater();
		if (!IS_AJAX) halt('页面不存在!');
		$prize_id = I('post.prize_id', '', 'int');
		$material_ids = I('post.material_ids');
		$data['rater_state'] = I('post.rater_state');
		$data['rater_prizes'] = explode(',', I('post.rater_prizes'));
		$data['prize_id'] = $prize_id;
		$data['prize_state'] = I('post.prize_state', 0, 'int');
		$map['prize_id'] = array($prize_id);
		$map['id'] = array('in', $material_ids);
		$map['year'] = system_value('current_year');
		$map['state'] = 10;
		$materials = D('Material')->where($map)->relation('avatar')->order('m_id asc,id asc')->select();
		$this->assign('materials', $materials);
		$this->assign('data', $data);
		layout(false);
		$this->display();
	}

	//ajax获取单个申请详情
	public function ajax_fetch_detailed() {
		check_rater();
		if (!IS_AJAX) halt('页面不存在!');
		$material = D('Material')->relation('avatar')->find(I('post.id', '', 'int'));
		$data['prize_id'] = I('post.prize_id');
		$data['rater_state'] = I('post.rater_state');
		$data['prize_state'] = I('post.prize_state', 0, 'int');
		$data['rater_prizes'] = explode(',', I('post.rater_prizes'));
		$this->assign('material', $material);
		$this->assign('data', $data);
		layout(false);
		$this->display();
	}

	//ajax记录评委评审记录
	public function ajax_set_rater_record() {
		check_rater();
		if (!IS_AJAX) halt('页面不存在!');
		$m_ids = I('post.m_ids');
		$r_id = I('post.r_id', '', 'int');
		$p_id = I('post.p_id', '', 'int');
		$type = I('post.type');
		$r = D('Rater')->field('material_ids')->find($r_id);
		if(!empty($r)) {
			$material_info = json_decode($r['material_ids'], true);
			$material_info[$p_id] = array('m_ids'=>$m_ids, 'state'=>0);
			$rater = D('Rater')->field('material_ids')->save(array('id'=>$r_id, 'material_ids'=>json_encode($material_info)));
			if($rater){
				$result['state'] = 1;
			}else{
				$result['state'] = 0;
			}
		}else{
			$result['state'] = 0;
		}

		$this->ajaxReturn($result);
	}

	//ajax评委评审提交
	public function ajax_review() {
		check_rater();
		if (!IS_AJAX) halt('页面不存在!');
		$m_ids = I('post.m_ids');
		$r_id = I('post.r_id', '', 'int');
		$p_id = I('post.prize_id');
		$r = D('Rater')->find($r_id);
		if(!empty($r)) {
			$material_info = json_decode($r['material_ids'], true);
			$material_info[$p_id]['state'] = 1;
			$rater = D('Rater')->field('material_ids')->save(array('id'=>$r_id, 'material_ids'=>json_encode($material_info)));
			if($rater) {
					//更新评委表状态,,以及关联表的更新
					$arr = explode(',', $m_ids);
					$material = D('Material');
					$rater_material = M('rater_material');
					$sql = 'INSERT INTO `' . C('DB_PREFIX') . 'rater_material` (rid, mid, pid) VALUES';
					foreach($arr as $k=>$v) {
						//更新关联表rater_material
						$sql_v = '('. $r_id . ',' . $v . ',' . $p_id . ')';
						$map['rid'] = $r_id;
						$map['mid'] = $v;
						$r = $rater_material->query('SELECT * FROM `'. C('DB_PREFIX') . 'rater_material` where rid='. $r_id . ' AND mid='. $v);
						//如果关联表不存在数据,则更新
						if(empty($r)) {
							$rater_material->query($sql.$sql_v);
							//申请表chosen_count加１
							$material->where('id='.$v)->setInc('chosen_count', 1);
						}
					}
					$result['state'] = 1;
					$result['info'] = '更新成功!';
				}else{
					$result['state'] = 0;
					$result['info'] = '更新失败!';
				}
		}else{
			$result['state'] = 0;
			$result['info'] = '更新失败!';
		}

		$this->ajaxReturn($result);
	}
}
