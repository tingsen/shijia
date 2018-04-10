<?php
namespace Common\Model;
//use Think\Model;
class PostModel extends BaseModel {
	protected $tableName = 'posts';

	//关系
    protected $_link = array(
		'Category' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'Category',
			'foreign_key'   => 'category_id',
			'mapping_name'  => 'category',
			//'mapping_order' => 'create_time desc',
		),
		'Asset'	=>	array(
			'mapping_type'	=>	self::HAS_MANY,
			'class_name'	=>	'Asset',
			'foreign_key'   => 'relateable_id',
			'mapping_name'  => 'assets',
			'condition'		=> 'relateable_type="Post"'
		),
		'Cover'	=>	array(
			'mapping_type'	=>	self::BELONGS_TO,
			'class_name'	=>	'Asset',
			'foreign_key'   => 'cover_id',
			'mapping_name'  => 'cover',
		),
		'User'	=>	array(
			'mapping_type'	=>	self::BELONGS_TO,
			'class_name'	=>	'User',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'user',
		)
    );

	//验证
	protected $_validate = array(
		array('title','require','标题不能为空！'),
		array('user_id','require','没有用户ID！'),
		array('category_id','require','请选择一个分类！'),
		array('category_id','number','分类ID为整数！')
	);

}
