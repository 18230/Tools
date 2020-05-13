<?php

require __DIR__ . '/vendor/autoload.php';

// // 归类（非递归）
// $res = devkeep\Tools\Tools::tree([
// 	[
// 		'id' => 1,
// 		'pid' => 0,
// 		'title' => 'title'
// 	],
// 	[
// 		'id' => 3,
// 		'pid' => 1,
// 		'title' => 'title'
// 	],
// 	[
// 		'id' => 4,
// 		'pid' => 1,
// 		'title' => 'title'
// 	],
// ]);

// echo '<pre>';
// print_r($res);

// // 保留两位小数
// $res = devkeep\Tools\Tools::format(100);

// // 二维数组排序
// $res = devkeep\Tools\Tools::arrayMultiSort([
//     ['id' => 1],
//     ['id' => 2],
//     ['id' => 3],
// ], 'id', 'asc');

// var_dump($res);


// // 文件打包
// $zip = time().'.zip';
// devkeep\Tools\Tools::unZip('1588999596.zip', [
// 	'G:\Github\Tools\images\a\b\1.png',
// 	'G:\Github\Tools\images\a\b\2.png'
// ]);


// // 压缩包解压
// $res = devkeep\Tools\Tools::unZip('xxx.zip', './xxx');
// var_dump($res);

// // 文件下载
// devkeep\Tools\Tools::download('G:\Github\Tools\images\a\b\2.png');

// // 发送邮件
// $res = devkeep\Tools\Tools::sendMail([
// 	'host' => 'smtp.aliyun.com',
// 	'port' => 465,
// 	'username' => 'devkeep@aliyun.com',
// 	'password' => 'xxxx',
// 	'address' => 'devkeep@aliyun.com',
// 	'title' => '测试邮件',
// ], [
// 	'mail' => '363927173@qq.com',
// 	'name' => '张三',
// 	'subject' => '主题',
// 	'body' => '这是一个邮件'
// ]);
// var_dump($res);

// // 导出Excel
// devkeep\Tools\Tools::exportExcel(['标题','价格', '重量'], [
// 	['标题一', '1.00', '1KG'],
// 	['标题二', '2.00', '2KG'],
// ], 'abc');

// // 生成二维码
// devkeep\Tools\Tools::qrcode('http://www.baidu.com', false, 'L', 6, 2);

// // 获取系统类型
// devkeep\Tools\Tools::getOS();