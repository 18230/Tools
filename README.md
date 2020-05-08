## 功能
- 常用PHP函数集合

## 环境
- PHP 7.0+
- composer

## 安装使用
```shell
composer require devkeep/tools:dev-master
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
```

## 实例
```php
// 保留两位小数
$res = Tools\Tools::format(100, 2);

// 100.00

// 二维数组排序
$res = Tools\Tools::arrayMultiSort([
    ['id' => 1],
    ['id' => 2],
    ['id' => 3],
], 'id', 'desc');

// [
//     ['id' => 3],
//     ['id' => 2],
//     ['id' => 1],
// ]
```

欢迎`Star`，欢迎`Fork`！