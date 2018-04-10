<?php
namespace Common\Model;
use Think\Model\RelationModel;
class BaseModel extends RelationModel {

	//自动完成
    protected $_auto = array ( 
        array('created_on','time',1,'function'), // 对created_on字段在新建的时候写入当前时间戳
        array('updated_on','time',3,'function') // 对updated_on字段在新建和更新的时候写入当前时间戳
    );

}
