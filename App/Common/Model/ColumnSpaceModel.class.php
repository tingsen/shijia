<?php
namespace Common\Model;
//use Think\Model;
class ColumnSpaceModel extends BaseModel {
	protected $tableName = 'column_spaces';

	//关系
    protected $_link = array(
		'Column' => array(
			'mapping_type'  => self::HAS_MANY,
			'class_name'    => 'Column',
			'foreign_key'   => 'column_space_id',
			'mapping_name'  => 'columns',
			'mapping_order' => 'sort desc',
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
		array('name','require','名称不能为空！'),
		array('user_id','require','没有用户ID！'),
		array('mark','require','标识不能为空！'),
		array('mark','','标识已经存在！',0,'unique'),
	);

}
