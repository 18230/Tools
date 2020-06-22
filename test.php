<?php

require __DIR__ . '/vendor/autoload.php';

// // 获取系统类型
// $res = devkeep\Tools\Tools::getOS();
// var_dump($res);

// 保留两位小数
// $res = devkeep\Tools\Tools::format(100, 2);
// var_dump($res);
 
// 对象转数组
// $obj = new stdClass;  
// $obj->foo = "foo";  
// $obj->bar = "bar"; 
// $res = devkeep\Tools\Tools::toArray($obj);
// echo '<pre>';
// print_r($res);

// 归类（非递归）
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

// 根据子级找父顶级
// $res = devkeep\Tools\Tools::parentFind([
// 	['id' => 1, 'pid' => 0],
// 	['id' => 2, 'pid' => 0],
// 	['id' => 3, 'pid' => 1],
// 	['id' => 4, 'pid' => 1],
// 	['id' => 5, 'pid' => 2],
// 	['id' => 6, 'pid' => 2],
// 	['id' => 9, 'pid' => 6],
// 	['id' => 10, 'pid' => 9],
// 	['id' => 11, 'pid' => 10],
// 	['id' => 12, 'pid' => 3],
// ], 12);
// echo '<pre>';
// print_r($res);

// 排列组合（适用多规格商品SKU生成）
// $res = devkeep\Tools\Tools::arrayArrange([
//     [
//         ['id' => 1, 'name' => '红色'],
//         ['id' => 2, 'name' => '黑色'],
//         ['id' => 3, 'name' => '蓝色'],
//     ],
//     [
//         ['id' => 4, 'name' => '32G'],
//         ['id' => 5, 'name' => '64G'],
//     ],
//     [
//         ['id' => 6, 'name' => '移动版'],
//         ['id' => 7, 'name' => '联通版'],   
//     ]
// ]);

// [
// 	'id'=>[1,4,6], 'name' => [红色,32G,移动版]
// 	'id'=>[1,4,7], 'name' => [红色,32G,联通版]
// 	'id'=>[1,5,6], 'name' => [红色,64G,移动版]
// 	'id'=>[1,5,7], 'name' => [红色,64G,联通版]
// 	...
// ]
// 
// echo '<pre>';
// print_r($res);

// 二维数组排序
// $res = devkeep\Tools\Tools::arrayMultiSort([
//     ['id' => 1],
//     ['id' => 2],
//     ['id' => 3],
// ], 'id', 'desc');
// var_dump($res);

// // 文件打包
// $zip = time().'.zip';
// devkeep\Tools\Tools::addZip('1588999596.zip', [
// 	'G:\Github\Tools\images\a\b\1.png',
// 	'G:\Github\Tools\images\a\b\2.png'
// ]);

// XML转数组
// $res = devkeep\Tools\Tools::xmlToArray()
// var_dump($res);

// GET
// $res = devkeep\Tools\Tools::get('http://www.baidu.com');
// var_dump($res);

// POST
// $res = devkeep\Tools\Tools::post('http://www.baidu.com', ['name'=>'xxx']);
// var_dump($res);

// 文件打包下载
// devkeep\Tools\Tools::addZip()

// // 压缩包解压
// $res = devkeep\Tools\Tools::unZip('xxx.zip', './xxx');
// var_dump($res);

// // 文件下载
// devkeep\Tools\Tools::download('G:\Github\Tools\images\a\b\2.png');

// 发送邮件
// $res = devkeep\Tools\Tools::sendMail([
// 	'host' => 'smtp.aliyun.com',
// 	'port' => 465,
// 	'username' => 'devkeep@aliyun.com',
// 	'password' => '',
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

// 生成二维码(第二个参数可选，输出或保存)
// devkeep\Tools\Tools::qrcode('http://www.baidu.com', false, 'L', 6, 2);

// 大文件分片上传
// $obj = new devkeep\Tools\Block($_FILES['file']['tmp_name'], './upload', '123.mp4', $_POST['total_num'], $_POST['num']);
// $res = $obj->returnResult();
// var_dump($res);