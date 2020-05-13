## 功能
- 常用PHP工具函数集合

## 介绍
历经无数个项目沉淀出的工具函数，有兴趣的可以一起来维护， 作者邮箱：devkeep@skeep.cc

## 环境
- PHP 7.0+
- composer

## 安装使用
```shell
composer require devkeep/tools
```

## 工具函数集合
```php
// 获取系统类型
devkeep\Tools\Tools::getOS()

// 对象转数组  
devkeep\Tools\Tools::toArray()

// 无限级归类 
devkeep\Tools\Tools::tree()

// 二维数组去重
devkeep\Tools\Tools::arrayMultiUnique()

// 二维数组排序
devkeep\Tools\Tools::arrayMultiSort()

// 保留小数
devkeep\Tools\Tools::format()

// GET请求
devkeep\Tools\Tools::get()

// POST请求
devkeep\Tools\Tools::post()

// 数组转XML
devkeep\Tools\Tools::arrayToXml()

// XML转数组
devkeep\Tools\Tools::xmlToArray()

// 文件打包下载
devkeep\Tools\Tools::addZip()

// 压缩包解压
devkeep\Tools\Tools::unZip()

// 文件下载
devkeep\Tools\Tools::download()

// 发送邮件
devkeep\Tools\Tools::sendMail()

// 导出excel
devkeep\Tools\Tools::exportExcel()

// 生成二维码
devkeep\Tools\Tools::qrcode();
```

## 实例
```php
// 保留两位小数
$res = devkeep\Tools\Tools::format(100, 2);

// 100.00

// 二维数组排序
$res = devkeep\Tools\Tools::arrayMultiSort([
    ['id' => 1],
    ['id' => 2],
    ['id' => 3],
], 'id', 'desc');

// [
//     ['id' => 3],
//     ['id' => 2],
//     ['id' => 1],
// ]

// tree归类（非递归）
$res = devkeep\Tools\Tools::tree([
	[
		'id' => 1,
		'pid' => 0,
		'title' => 'title'
	],
	[
		'id' => 3,
		'pid' => 1,
		'title' => 'title3'
	],
	[
		'id' => 4,
		'pid' => 1,
		'title' => 'title4'
	],
]);

// Array
// (
//     [0] => Array
//         (
//             [id] => 1
//             [pid] => 0
//             [title] => title
//             [child] => Array
//                 (
//                     [0] => Array
//                         (
//                             [id] => 3
//                             [pid] => 1
//                             [title] => title3
//                             [child] => []
//                         )
//                     [1] => Array
//                         (
//                             [id] => 4
//                             [pid] => 1
//                             [title] => title4
//                             [child] => []
//                         )
//                 )
//         )
// )



// 导出Excel
devkeep\Tools\Tools::exportExcel(['标题','价格', '重量'], [
	['标题一', '1.00', '1KG'],
	['标题二', '2.00', '2KG'],
], 'abc');

// 生成二维码
devkeep\Tools\Tools::qrcode('http://www.baidu.com', false, 'L', 6, 2);

// 发送邮件
$res = devkeep\Tools\Tools::sendMail([
	'host' => 'smtp.aliyun.com',
	'port' => 465,
	'username' => 'devkeep@aliyun.com',
	'password' => 'xxxx',
	'address' => 'devkeep@aliyun.com',
	'title' => '测试邮件',
], [
	'mail' => '363927173@qq.com',
	'name' => '张三',
	'subject' => '主题',
	'body' => '这是一个邮件'
]);
var_dump($res);
```

欢迎`Star`，欢迎`Fork`！
