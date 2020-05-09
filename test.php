<?php

require __DIR__ . '/vendor/autoload.php';

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