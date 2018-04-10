<?php
namespace Common\Model;
//use Think\Model;
class BlockModel extends BaseModel {
	protected $tableName = 'blocks';

	//关系
    protected $_link = array(
		'Asset' => array(
			'mapping_type'	=>	self::HAS_MANY,
			'class_name'	=>	'Asset',
			'foreign_key'   => 'relateable_id',
			'mapping_name'  => 'assets',
			'condition'		=> 'relateable_type="Block"'
			//'mapping_order' => 'create_time desc',
		),
    );

	//验证
	protected $_validate = array(
		array('name','require','名称不能为空！'),
		array('name','','名称不能重复！',0,'unique'),
		array('user_id','require','没有用户ID！'),
		array('user_id','number','用户格式不正确！'),
		array('mark','require','标识不能为空！'),
		array('mark','','标识已经存在！',0,'unique'),
	);

}
