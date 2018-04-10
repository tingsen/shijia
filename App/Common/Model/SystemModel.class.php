<?php
namespace Common\Model;
//use Think\Model;
class SystemModel extends BaseModel {
	protected $tableName = 'systems';

	//关系
    protected $_link = array(
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
		array('mark','require','标识不能为空！'),
		array('mark','','标识已经存在！',0,'unique'),
		array('name','require','名称不能为空！'),
		array('name','','名称已经存在！',0,'unique'),
	);

}
