<?php
namespace Common\Model;
//use Think\Model;
class CategoryModel extends BaseModel {
	protected $tableName = 'categories';

	//关系
    protected $_link = array(
		'Post' => array(
			'mapping_type'  => self::HAS_MANY,
			'class_name'    => 'Post',
			'foreign_key'   => 'category_id',
			'mapping_name'  => 'posts',
			//'mapping_order' => 'create_time desc',
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
		array('name','','名称已经存在！',0,'unique')
	);

}
