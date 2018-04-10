<?php
//申请奖项
//需要验证是否为用户自己
namespace Home\Controller;
class MaterialController extends BaseController {
	
	function _initialize(){
		parent::_initialize();
		check_user();
		system_sign('sign');
		$this->assign('css_header_material', true);
    }

    public function sort() {
		$this->display();
	}
	
	public function info(){
		if(I('get.m_id')){
			$map['id'] = I('get.m_id');
			$map['user_id'] = $_SESSION['uid'];
			$db = D('Material');
			$material = $db->where($map)->relation(true)->find();
			if($material){
				if($material['state']>=3){
					redirect(U('home/material/sort'), 3, '不允许操作');	
				}
				$this->assign('material',$material);
				$this->assign('material_id',$material['id']);
				$this->assign('prize',$material['prize_id']);
				$this->display();
			}else{
				redirect(U('home/material/sort'), 3, '没有这个奖项');
			}
		}else{
			if(in_array(I('prize_id'), array(1,2,3,4,5))){
				$prize = I('prize_id');
				$this->assign('prize',$prize);
				$this->display();
			}else{
				redirect(U('home/material/sort'),3, '没有这个奖项');
			}
		}
	}

	
	//公共
	public function major(){
		$db =  D('Material');
		if(I('get.m_id')){
			//从内容简介上一页过来
			$map['id'] = I('get.m_id');
			$map['user_id'] = $_SESSION['uid'];
			$material = $db->where($map)->find();
			if($material){
				if($material['state']>=3){
					redirect(U('home/material/sort'), 3, '不允许操作');	
				}
				$this->assign('material',$material);
				$this->assign('material_id',$material['id']);
				$this->assign('prize',$material['prize_id']);
				$this->display();
			}else{
				redirect(U('home/material/sort'), 3, '错误');
			}
		}else{
			$data = array(
				'name' => I('post.name', ''),
				'prize_id' => I('post.prize_id', '', 'int'),
				'year' => system_value('current_year'),
				'province'	=> I('post.province'),
				'city'	=> I('post.city', 0),
				'founded' => I('post.founded', ''),
				'unit' => I('post.unit', ''),
				'scope' => I('post.scope'),
				'nature' => I('post.nature', ''),
				'sex' => I('post.sex', 1, 'int'),
				'web_url' => I('post.web_url', ''),
				'position' => I('post.position', ''),
				'tel' => I('post.tel', ''),
				'email' => I('post.email', ''),
				'administration_post' => I('post.administration_post', ''),
				'major' => I('post.major', ''),
				'total_assets' => I('post.total_assets', ''),
				'annual_revenue' => I('post.annual_revenue', ''),
				'rd_put' => I('post.rd_put', ''),
				'id_put' => I('post.id_put', ''),
				'legal_preson' => I('post.legal_preson', ''),
				'head_preson' => I('post.head_preson', ''),
				'staff_count' => I('post.staff_count', ''),
				'design_count' => I('post.design_count', ''),
				'cover_id'	=> I('post.cover_id', ''),
				'user_id' => $_SESSION['uid']
			);

			if(!$db->create($data)){
				$this->error($db->getError());
			}else{
				if(I('post.material_id')){
					//后退到info后有前进一步已经存在用户申请记录material
					$a['id'] = I('post.material_id');
					$a['user_id'] = $_SESSION['uid'];
					$db->where($a)->save();
					$old_cover_id = I('post.old_cover_id');
					//删除旧的asset
					if(isset($old_cover_id) && $old_cover_id != $data['cover_id']) {
						D('Asset')->delete(intval($old_cover_id));
					}
					$material = $db->where($a)->find();
					if($material){
						$this->assign('material_id',$material['id']);
						$this->assign('material',$material);
						$this->assign('prize',$material['prize_id']);
						$this->display();
					}else{
						redirect(U('home/material/sort'), 3, '错误');
					}
				}else{
					//正常申请第一步
					$material_id = $db->add();
					$asset = D('Asset');
					if(isset($data['cover_id'])) {
						$asset->where(array('id'=>intval($data['cover_id'])))->field('relateable_id')->save(array('relateable_id'=>$material_id));
					}
					$this->assign('material_id',$material_id);
					$this->assign('prize',I('prize_id'));
					$this->display();
				}
			}
		}
	}
	
	public function contact(){
		$db =  D('Material');
		$data = array(
			'description' => I('post.description'),
			'content' => I('post.content'),
			'fruit' => I('post.fruit')
		);
		$map['id'] = I('post.material_id');
		$map['user_id'] = $_SESSION['uid'];
		if(!$db->create($data)){
			$this->error('错误');
		}else{
			//从save已经不能上一步
			if($db->where($map)->save()){
				$material = $db->where($map)->find();
				$this->assign('material_id',I('post.material_id'));
				$this->assign('material',$material);
				$this->display();
			}else{
				redirect(U('home/material/sort'), 3, '非法操作');
			}
		}
	}
	
	public function save(){
		$data = array(
			'contact_name' => I('post.contact_name'),
			'contact_tel' => I('post.contact_tel'),
			'contact_email' => I('post.contact_email'),
			'introduction' => I('post.introduction'),
			'state' => 2
		);
		//验证用户是否为自己操作
		$map['id'] = I('post.material_id');
		$map['user_id'] = $_SESSION['uid'];
		$db =  D('Material');
		if(!$db->create($data)){
			$this->error('错误');
		}else{
			if($db->where($map)->save()){
				$this->assign('prize_id', I('post.prize_id', '', 'int'));
				$this->display();
			}else{
				redirect(U('home/material/sort'), 3, '非法操作');
			}
		}
	}

	//ajax联动城市列表
	public function ajax_change_city() {
		$pid = I('get.pid', '', 'int');
		$cid = I('get.cid', '', 'int');
		$this->assign('cities', city_options($pid));
		$this->assign('cid', $cid);
		layout(false);
		$this->display();
	}

}
