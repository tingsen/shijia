<?php

//文件操作函数
//附件绝对路径Public/upload/
function absolute_upload_path ($path) {
	return $_SERVER[DOCUMENT_ROOT] . __ROOT__ . '/Uploads/' . $path;
}

