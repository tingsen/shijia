<?php
/**
 * array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
 */
namespace Common\Model;
use Think\Model;
Class EmailModel extends Model{
	protected $tableName = 'emails';
	
	//自动完成
    protected $_auto = array (
		array('email','strtolower',3,'function'),
    );
}
?>
