## 功能
- 常用PHP工具函数库

## 介绍
历经无数个项目沉淀的工具函数， 问题邮箱：devkeep@skeep.cc

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

// 获取IP
devkeep\Tools\Tools::getIP()

// 生成UUID
devkeep\Tools\Tools::uuid()

// 保留小数
devkeep\Tools\Tools::format()

// 对象转数组  
devkeep\Tools\Tools::toArray()

// 无限级归类 
devkeep\Tools\Tools::tree()

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

// 取两经纬度之间距离
devkeep\Tools\Tools::getDistance()

// 文件打包下载
devkeep\Tools\Tools::addZip()

// 压缩包解压
devkeep\Tools\Tools::unZip()

// 文件下载(可限速)
devkeep\Tools\Tools::download()

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


```

欢迎`Star`，欢迎`Fork`
