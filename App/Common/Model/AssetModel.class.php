<?php
namespace Common\Model;
//use Think\Model;
class AssetModel extends BaseModel {
	protected $tableName = 'assets';

	//关系
    protected $_link = array(
		'Post' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'Post',
			'foreign_key'   => 'relateable_id',
			'mapping_name'  => 'post',
			//'mapping_order' => 'create_time desc',
			//'relation_table' => 'sj_posts'
		),
		'Column' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'Column',
			'foreign_key'   => 'relateable_id',
			'mapping_name'  => 'column',
			//'mapping_order' => 'create_time desc',
			//'relation_table' => 'sj_posts'
		),
		'CoverPost' => array(
			'mapping_type'  => self::HAS_ONE,
			'class_name'    => 'Post',
			'foreign_key'   => 'cover_id',
			'mapping_name'  => 'cover',
			//'mapping_order' => 'create_time desc',
			//'relation_table' => 'sj_posts'
		),
		'CoverColumn' => array(
			'mapping_type'  => self::HAS_ONE,
			'class_name'    => 'Column',
			'foreign_key'   => 'cover_id',
			'mapping_name'  => 'column',
			//'mapping_order' => 'create_time desc',
			//'relation_table' => 'sj_posts'
		),
		'Logo' => array(
			'mapping_type'  => self::HAS_ONE,
			'class_name'    => 'Material',
			'foreign_key'   => 'cover_id',
			'mapping_name'  => 'logo',
			//'mapping_order' => 'create_time desc',
			//'relation_table' => 'sj_posts'
		),
		'Block' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'Block',
			'foreign_key'   => 'relateable_id',
			'mapping_name'  => 'blocks',
			//'mapping_order' => 'create_time desc',
			//'relation_table' => 'sj_posts'
		),
		'Rater' => array(
			'mapping_type'  => self::HAS_ONE,
			'class_name'    => 'Rater',
			'foreign_key'   => 'avatar_id',
			'mapping_name'  => 'avatar',
		),
    );

	//验证
	protected $_validate = array(
		array('name','require','标题不能为空！'),
		array('file_path','require','没有路径！'),
		array('file_name','require','没有文件名！'),
		array('format_type','require','没有类型名！'),
	);

}
