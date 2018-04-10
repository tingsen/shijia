<?php
/**
 * validate
 * array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
 * 
 * auto
 * array(完成字段1,完成规则,[完成条件,附加规则]),
 * 注意设为3的时候 在controllec调用create后没有该字段时，更新为空
 */
namespace Common\Model;
//use Think\Model;
Class UserModel extends BaseModel{
	protected $tableName = 'users';

	//关系
    protected $_link = array(
		//Post表
		/* 暂时不用,而且影响效率,先注掉
        'Post'=>array(
			'mapping_type'  => self::HAS_MANY,
			'class_name'    => 'Post',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'posts',
		),
        'Column'=>array(
			'mapping_type'  => self::HAS_MANY,
			'class_name'    => 'Column',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'columns',
        ),
        'ColumnSpace'=>array(
			'mapping_type'  => self::HAS_MANY,
			'class_name'    => 'ColumnSpace',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'column_spaces',
		),
		 */
		//关联申请表
        'Material'=>array(
			'mapping_type'  => self::HAS_MANY,
			'class_name'    => 'Material',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'materials',
		),
		//关联评委表
        'Rater'=>array(
			'mapping_type'  => self::HAS_ONE,
			'class_name'    => 'Rater',
			'foreign_key'   => 'user_id',
			'mapping_name'  => 'rater',
		),
    );

	protected $_validate=array(
		array('email','require','请输入邮箱地址'),
		array('email','','帐号名称已经存在！',0,'unique'), // 在新增的时候验证name字段是否唯一
		array('email','email','邮箱格式不正确',0,'regex'), // 邮箱格式验证
		array('nickname','2,15','你的昵称字符必须在2~15之间',0,'length'), //昵称字符
		array('password','require','密码必须'),
		array('password','6,15','密码长度不符合规则，请重新填写',0,'length'),
		array('repassword','password','确认密码不正确',0,'confirm')
	);
	
	//自动完成
    protected $_auto = array (
		array('password','md5',3,'function'),
		array('password','',2,'ignore'),
		array('role_id','9'),
		array('created_on','time',1,'function'), // 对created_on字段在新建的时候写入当前时间戳
        array('updated_on','time',3,'function') // 对updated_on字段在新建和更新的时候写入当前时间戳
    );
}
?>
