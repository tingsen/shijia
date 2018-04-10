<?php

namespace Common\Model;
//use Think\Model;
Class RaterModel extends BaseModel{
	protected $tableName = 'raters';

	//关系
    protected $_link = array(
		//评委所属用户
        'User'=>array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'User',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'user',
		),
		'Asset'=>array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'Asset',
			'foreign_key'   => 'avatar_id',
			'mapping_name'  => 'asset',
		),
		'Material' => array(
			'mapping_type'      =>  self::MANY_TO_MANY,
			'class_name'        =>  'Material',
			'mapping_name'      =>  'materials',
			'foreign_key'       =>  'rid',
			'relation_foreign_key'  =>  'mid',
			'relation_table'    =>  'sj_rater_material' //此处应显式定义中间表名称，且不能使用C函数读取表前缀
		),
    );

	protected $_validate=array(
		array('name','require','请输入名称'),
		array('name','','名称已经存在！',0,'unique'), // 在新增的时候验证name字段是否唯一
		array('user_id','require','所属用户不存在'),
		array('user_id','','所属用户已经存在！',0,'unique'),
	);

}
?>
