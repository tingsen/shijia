<?php

/* 基本设置 */
$base = array(
	'URL_HTML_SUFFIX' => '',	//伪静态url后缀名　默认为html
	'URL_MODEL'	=>	2,	//生成url类型,设为２来兼容nginx
	'DEFAULT_FILTER' =>	'htmlspecialchars',	//过滤特殊字符
	'URL_CASE_INSENSITIVE' =>	true,	//路径不区分大小写
	'LAYOUT_ON'	=>	true,
	'VAR_PAGE'	=>	'page',  //分页参数名称
	'LOAD_EXT_CONFIG'=>'email',
	'LOG_PATH'	=> './Logs/',
	'TMPL_ACTION_ERROR'     =>  'Base:notice', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Base:notice', // 默认成功跳转对应的模板文件
);

/* 数据库设置 */
$db_conf = array(
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', //'bdm-001.hichina.com', // 服务器地址
    'DB_NAME'               =>  'shijia', //'bdm0010324_db',          // 数据库名
    'DB_USER'               =>  'root', //'bdm0010324',      // 用户名
    'DB_PWD'                =>  '', //'bjbskjq1w2',          // 密码
	'DB_PORT'				=>	3306, // 端口
    'DB_PREFIX'             =>  'sj_',    // 数据库表前缀
	'DB_SUFFIX'				=>	's'		//表后缀
);
/* email验证设置 */
$email = array(
    'MAIL_ADDRESS'=>'sjzg_shijia@163.com', // 邮箱地址
    'MAIL_SMTP'=>'smtp.163.com', // 邮箱SMTP服务器
    'MAIL_LOGINNAME'=>'sjzg_shijia@163.com', // 邮箱登录帐号
    'MAIL_PASSWORD'=>'2014SHIJIA#des', // 邮箱密码
    'MAIL_CHARSET'=>'UTF-8',//编码
    'MAIL_AUTH'=>true,//邮箱认证
    'MAIL_HTML'=>true,//true HTML格式 false TXT格式
);
/* 公共函数库加载 */
$func = array(
	'LOAD_EXT_FILE' =>	'show_func,model_func,file_func,const_func,session_func'
);

/* 模板常量设置 */
$tmp_var = array(
	'TMPL_PARSE_STRING' => array(
		'__UPLOAD__' =>	__ROOT__ . '/Uploads/',
		'__PUBLIC__'	=> __ROOT__ . '/Public',
	)
);


/* 自定义配置 */
$custom = array(
	'DOMAIN'	=>	'http://127.0.0.1', //'http://blu006007.chinaw3.com',
	'DES_SESSION_KEY_TOKEN' => '2014sjzg@des#DESshijia' //session加密常量自定义
);



return array_merge($db_conf, $func, $tmp_var, $base, $email, $custom);
