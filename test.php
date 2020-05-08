<?php

require __DIR__ . '/vendor/autoload.php';

// 保留两位小数
$res = devkeep\Tools\Tools::format(100);

// 二维数组排序
$res = devkeep\Tools\Tools::arrayMultiSort([
    ['id' => 1],
    ['id' => 2],
    ['id' => 3],
], 'id', 'asc');

var_dump($res);