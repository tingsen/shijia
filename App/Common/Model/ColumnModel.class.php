<?php
namespace Common\Model;
//use Think\Model;
class ColumnModel extends BaseModel {
	protected $tableName = 'columns';

	//关系
    protected $_link = array(
		'ColumnSpace' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'ColumnSpace',
			'foreign_key'   => 'column_space_id',
			'mapping_name'  => 'column_space',
			//'mapping_order' => 'create_time desc',
		),
		'Cover'	=>	array(
			'mapping_type'	=>	self::BELONGS_TO,
			'class_name'	=>	'Asset',
			'foreign_key'   => 'cover_id',
			'mapping_name'  => 'asset',
		),
		'Asset'	=>	array(
			'mapping_type'	=>	self::HAS_MANY,
			'class_name'	=>	'Asset',
			'foreign_key'   => 'relateable_id',
			'mapping_name'  => 'assets',
			'condition' => 'relateable_type="Column"',
		),
		'User' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'User',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'user',
			//'mapping_order' => 'create_time desc',
		),
    );

	//验证
	protected $_validate = array(
		array('title','require','标题不能为空！'),
		array('column_space_id','number','栏目位id必须是数字！'),
		array('column_space_id','require','栏目位不能为空！'),
		array('user_id','require','没有用户ID！'),
		array('sort','number','排序必须是数字！'),
	);

}
