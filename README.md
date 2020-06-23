## 功能
- 常用PHP工具函数库

## 介绍
历经无数个项目沉淀的工具函数，有兴趣的可以一起来维护， 邮箱：devkeep@skeep.cc

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

// 保留小数
devkeep\Tools\Tools::format()

// 对象转数组  
devkeep\Tools\Tools::toArray()

// 无限级归类 
devkeep\Tools\Tools::tree()

// 通过子级查找父顶级
devkeep\Tools\Tools::parentFind()

// 排列组合（适用多规格SKU生成）
devkeep\Tools\Tools::arrayArrange()

// 二维数组去重
devkeep\Tools\Tools::arrayMultiUnique()

// 二维数组排序
devkeep\Tools\Tools::arrayMultiSort()

// 数组转XML
devkeep\Tools\Tools::arrayToXml()

// XML转数组
devkeep\Tools\Tools::xmlToArray()

// GET请求
devkeep\Tools\Tools::get()

// POST请求
devkeep\Tools\Tools::post()

// 文件打包下载
devkeep\Tools\Tools::addZip()

// 压缩包解压
devkeep\Tools\Tools::unZip()

// 文件下载(可限速)
devkeep\Tools\Tools::download()

// 导出excel
devkeep\Tools\Tools::exportExcel()

// 发送邮件
devkeep\Tools\Tools::sendMail()

// 生成二维码
devkeep\Tools\Tools::qrcode()

// 文件分块上传(支持10G以上大文件)
devkeep\Tools\Block()
```

## 实例

- 更多使用请参照test用例

```php
// 保留小数
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

// 大文件分片上传
$obj = new \devkeep\Tools\Block([
    'tmpPath'   => $_FILES['file']['tmp_name'],
    'filePath'  => $filePath,
    'fileSize'  => $fileSize,
    'num'       => $num,
    'totalNum'  => $totalNum
]);
$res = $obj->returnResult();
echo $res;

```

欢迎`Star`，欢迎`Fork`
