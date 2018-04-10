<?php
namespace Common\Model;
//use Think\Model;
class MaterialModel extends BaseModel {
	protected $tableName = 'materials';

	//关系
    protected $_link = array(
		'User'	=>	array(
			'mapping_type'	=>	self::BELONGS_TO,
			'class_name'	=>	'User',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'user',
		),
		'Rater' => array(
			'mapping_type'      =>  self::MANY_TO_MANY,
			'class_name'        =>  'Rater',
			'mapping_name'      =>  'raters',
			'foreign_key'       =>  'mid',
			'relation_foreign_key'  =>  'rid',
			'relation_table'    =>  'sj_rater_material' //此处应显式定义中间表名称，且不能使用C函数读取表前缀
		),
		'Avatar'	=>	array(
			'mapping_type'	=>	self::BELONGS_TO,
			'class_name'	=>	'Asset',
			'foreign_key'   => 'cover_id',
			'mapping_name'  => 'avatar',
		),
    );

	//验证
	protected $_validate = array(
		array('name','require','名称不能为空！'),
		array('user_id','require','没有用户ID！'),
		array('prize_id','number','奖项ID必须是整数！'),
		array('prize_id','require','请选择一个奖项！'),
		array('prize_id',array(1,2,3,4,5),'没有这个奖项!',2,'in'), // 当值不为空的时候判断是否在一个范围内
	);
	
	//自动完成
    protected $_auto = array (
        array('created_on','time',1,'function'), // 对created_on字段在新建的时候写入当前时间戳
        array('updated_on','time',3,'function') // 对updated_on字段在新建和更新的时候写入当前时间戳
    );

}
