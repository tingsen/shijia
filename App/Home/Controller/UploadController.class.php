<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
//use Think\Controller;
class UploadController extends BaseController {

	//保存封面
    public function save_cover(){
		//获得文件/格式
		//$file = $_FILES["jUploaderFile"]["tmp_name"];
		$file = I('jUploaderFile');
		$upload = new \Think\Upload();
		$max_size = I('get.size', 1024*1024*2, 'int');
		$upload->maxSize  = $max_size ;// 设置附件上传大小
		$upload->exts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		//$upload->rootPath = './Uploads/';
		$upload->savePath = I('get.type') .'/';
		$upload->subName = array('date', 'Y-m');
		$result = $upload->uploadOne($_FILES["jUploaderFile"]);
		#上传到数据库
		$info = array();
		if($result['state']) {
			$data = array(
				'name' => $result['result']['name'],
				'size' => $result['result']['size'],
				'format_type' => $result['result']['type'],
				'file_path' => $result['result']['savepath'],
				'file_name' => $result['result']['savename'],
				'relateable_id'	=> I('get.id'),
				'relateable_type'	=> I('get.type'),
				'sort'	=>	0
			);

			$asset = D('Asset');
			if ($asset->create($data)) {
				$re = $asset->add();
				if ($re) {
					$info = array('state'=>true, 'info'=>'创建成功!', 'asset_id'=>$re, 'result'=>$result['result']);
				}else {
					$info = array('state'=>false, 'info'=>'写入数据库错误!');
					unlink(absolute_upload_path($result['result']['savepath'] . $result['result']['savename']));
				}
			}else {
				$info = array('state'=>false, 'info'=>$asset->getError());
				unlink(absolute_upload_path($result['result']['savepath'] . $result['result']['savename']));
			}
		}else{
			$info = array('state'=>false, 'info'=>$result['info']);
		}

		$this->ajaxReturn(json_encode($info), 'eval');
	}

	//保存编辑器图片
	public function save_edit() {

		//获得文件/格式
		//$file = $_FILES["jUploaderFile"]["tmp_name"];
		$file = I('jUploaderFile');
		$upload = new \Think\Upload();
		$upload->maxSize  = 1024 * 1024;// 设置附件上传大小1M
		$upload->exts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath = './Uploads/';
		$upload->savePath = I('get.type') .'/';
		$upload->subName = array('date', 'Y-m');
		$result = $upload->uploadOne($_FILES["imgFile"]);
		#上传到数据库
		$info = array();
		if($result['state']) {
			$data = array(
				'name' => $result['result']['name'],
				'size' => $result['result']['size'],
				'format_type' => $result['result']['type'],
				'file_path' => $result['result']['savepath'],
				'file_name' => $result['result']['savename'],
				'relateable_id'	=> I('get.id'),
				'relateable_type'	=> I('get.type'),
				'sort'	=>	0
			);

			$asset = D('Asset');
			if ($asset->create($data)) {
				$re = $asset->add();
				if ($re) {
					$info = array('error'=>0, 'message'=>'创建成功!', 'asset_id'=>$re, 'url'=>img_path($result['result']['savepath'] . $result['result']['savename']));
				}else {
					$info = array('error'=>1, 'message'=>'写入数据库错误!');
					unlink(absolute_upload_path($result['result']['savepath'] . $result['result']['savename']));
				}
			}else {
				$info = array('error'=>1, 'message'=>$asset->getError());
				unlink(absolute_upload_path($result['result']['savepath'] . $result['result']['savename']));
			}
		}else{
			$info = array('error'=>1, 'message'=>$result['info']);
			unlink(absolute_upload_path($result['result']['savepath'] . $result['result']['savename']));
		}

		$this->ajaxReturn(json_encode($info), 'eval');
	}
	

}
