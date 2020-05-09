## 功能
- 常用PHP函数集合

## 环境
- PHP 7.0+
- composer

## 安装使用
```shell
composer require devkeep/tools
```


## 工具函数集合
```php
// 对象转数组  
toArray()

// 无限级归类 
tree()

// 二维数组去重
arrayMultiUnique()

// 二维数组排序
arrayMultiSort()

// 保留小数
format()

// GET请求
get()

// POST请求
post()

// 数组转XML
arrayToXml()

// XML转数组
xmlToArray()

// 文件打包下载
addZip()

// 压缩包解压
unZip()

// 文件下载
download()

// 发送邮件
sendMail()

// 导出excel
exportExcel()
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

// 导出Excel
devkeep\Tools\Tools::exportExcel(['标题','价格', '重量'], [
	['标题一', '1.00', '1KG'],
	['标题二', '2.00', '2KG'],
], 'abc');
```

欢迎`Star`，欢迎`Fork`！
