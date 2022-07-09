<?php

/**
 * @author devkeep <devkeep@skeep.cc>
 * @link https://github.com/aiqq363927173/Tools
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @copyright The PHP-Tools
 */
declare(strict_types = 1);

namespace devkeep\Tools;

class Tools
{
    /**
     * 获取系统类型
     *
     * @return string
     */
    static public function getOS(): string
    {
        if(PATH_SEPARATOR == ':')
        {
            return 'Linux';
        }
        else
        {
            return 'Windows';
        }
    }

    /**
     * uuid
     * @return string
     */
    static public function uuid(): string
    {     
        $data = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : '';
        $data .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $data .= isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
        $data .= isset($_SERVER['SERVERL_PORT']) ? $_SERVER['SERVERL_PORT'] : '';
        $data .= isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $data .= isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : '';
        $uuid = strtoupper(md5(uniqid() . mt_rand() . $data));
        return $uuid;
    }

    /**
     * 获取IP地址
     * @return string
     */
    static public function getIP(): string
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) 
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        if (isset($_SERVER['HTTP_X_REAL_IP']))
        {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } 
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ips = explode(',', $ip);
            $ip = trim(current($ips));
        } 
        else if (isset($_SERVER['REMOTE_ADDR'])) 
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        } 
        else 
        {
            $ip = '0.0.0.0';
        }

        return $ip;
    }

    /**
     * format 保留两位小数
     *
     * @param int $input 数值
     * @param int $number 小数位数
     *
     * @return string
     */
    static public function format($input, int $number = 2): string
    {
        return sprintf("%." . $number . "f", $input);
    }


    /**
     * formatDate 时间格式化 
     *
     * @param int $time 时间
     *
     * @return string
     */
    static public function formatDate(int $time): string
    {
        $t = time() - $time;

        $f = [
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' =>'秒'
        ];

        foreach ($f as $k => $v)
        {
            if (0 != $c = floor($t / (int)$k)) 
            {
                return $c . $v . '前';
            }
            else
            {
                return '刚刚';
            }
        }
    }

    /**
     * 对象转数组
     *
     * @param object $object 对象
     * 
     * @return array
     */
    static public function toArray(object $object): array
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * 无限级归类
     *
     * @param array $list 归类的数组
     * @param string $id 父级ID
     * @param string $pid 父级PID
     * @param string $child key
     * @param string $root 顶级
     *
     * @return array
     */
    static public function tree(array $list, string $pk = 'id', string $pid = 'pid', string $child = 'child', int $root = 0): array
    {
        $tree = [];

        if(is_array($list))
        {
            $refer = [];

            //基于数组的指针(引用) 并 同步改变数组
            foreach ($list as $key => $val)
            {
                $list[$key][$child] = [];
                $refer[$val[$pk]] = &$list[$key];
            }

            foreach ($list as $key => $val)
            {
                //是否存在parent
                $parentId = isset($val[$pid]) ? $val[$pid] : $root;

                if ($root == $parentId)
                {
                    $tree[$val[$pk]] = &$list[$key];
                }
                else
                {
                    if (isset($refer[$parentId]))
                    {
                        $refer[$parentId][$child][] = &$list[$key];
                    }
                }
            }
        }

        return array_values($tree);
    }

    /**
     * 排列组合
     * 
     * @param array $input 排列的数组
     * 
     * @return array
     */
    static public function arrayArrange(array $input): array
    {
        $temp = [];
        $result = array_shift($input);

        while($item = array_shift($input))
        {
           $temp = $result;
           $result = [];

           foreach($temp as $v)
           {
                foreach($item as $val)
                {
                    $result[] = array_merge_recursive($v, $val);
                }
           }
        }

        return $result;
    }

    /**
     * 二维数组去重
     *
     * @param array $arr 数组
     * @param string $key 字段
     *
     * @return array
     */
    static public function arrayMultiUnique(array $arr, string $key = 'id'): array
    {
        $res = [];

        foreach ($arr as $value)
        {
            if(!isset($res[$value[$key]]))
            {
                $res[$value[$key]] = $value;
            }
        }

        return array_values($res);
    }

    /**
     * 二维数组排序
     *
     * @param array $array 排序的数组
     * @param string $keys 要排序的key
     * @param string $sort 排序类型 ASC、DESC
     *
     * @return array
     */
    static public function arrayMultiSort(array $array, string $keys, string $sort = 'desc'): array
    {
        $keysValue = [];

        foreach ($array as $k => $v)
        {
            $keysValue[$k] = $v[$keys];
        }

        $orderSort = [
            'asc'  => SORT_ASC,
            'desc' => SORT_DESC,
        ];

        array_multisort($keysValue, $orderSort[$sort], $array);

        return $array;
    }

    /**
     * XML转数组
     *
     * @param string $xml xml
     *
     * @return array
     */
    static public function xmlToArray(string $xml): array
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlString = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $result = json_decode(json_encode($xmlString), true);
        return $result;
    }

    /**
     * 数组转XML
     *
     * @param array $input 数组
     *
     * @return string
     */
    static public function arrayToXml(array $input): string
    {
        $str = '<xml>';

        foreach ($input as $k => $v)
        {
            $str .= '<' . $k . '>' . $v . '</' . $k . '>';
        }

        $str .= '</xml>';

        return $str;
    }

    /**
     * 取两经纬度之间距离
     *
     * @param float $lng1
     * @param float $lat1
     * @param float $lng2
     * @param float $lng2
     *
     * @return mixed
     */
    static public function getDistance(float $lng1, float $lat1, float $lng2, float $lat2)
    {
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
    
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
    
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        
        return $s;
    }

    /**
     * 文件打包下载

     * @param string $downloadZip 打包后下载的文件名
     * @param array $list 打包文件组

     * @return void
     */
    static public function addZip(string $downloadZip, array $list)
    {
        // 初始化Zip并打开
        $zip = new \ZipArchive();

        // 初始化
        $bool = $zip->open($downloadZip, \ZipArchive::CREATE|\ZipArchive::OVERWRITE);

        if($bool === TRUE)
        {
            foreach ($list as $key => $val) 
            {
                // 把文件追加到Zip包并重命名  
                // $zip->addFile($val[0]);
                // $zip->renameName($val[0], $val[1]);

                // 把文件追加到Zip包
                $zip->addFile($val, basename($val));
            }
        }
        else
        {
            exit('ZipArchive打开失败，错误代码：' . $bool);
        }

        // 关闭Zip对象
        $zip->close();

        // 下载Zip包
        header('Cache-Control: max-age=0');
        header('Content-Description: File Transfer');            
        header('Content-disposition: attachment; filename=' . basename($downloadZip)); 
        header('Content-Type: application/zip');                     // zip格式的
        header('Content-Transfer-Encoding: binary');                 // 二进制文件
        header('Content-Length: ' . filesize($downloadZip));          // 文件大小
        readfile($downloadZip);

        exit();
    }

    /**
     * 解压压缩包

     * @param string $zipName 要解压的压缩包
     * @param string $dest 解压到指定目录

     * @return boolean
     */
    static public function unZip(string $zipName, string $dest): bool
    {
        //检测要解压压缩包是否存在
        if(!is_file($zipName))
        {
            return false;
        }

        //检测目标路径是否存在
        if(!is_dir($dest))
        {
            mkdir($dest, 0777, true);
        }

        // 初始化Zip并打开
        $zip = new \ZipArchive();

        // 打开并解压
        if($zip->open($zipName))
        {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 文件下载

     * @param string $filename 要下载的文件
     * @param string $refilename 下载后的命名

     * @return void
     */
    static public function download(string $filename, $refilename = null)
    {
        // 验证文件
        if(!is_file($filename)||!is_readable($filename)) 
        {
            return false;
        }

        // 获取文件大小
        $fileSize = filesize($filename);

        // 重命名
        !isset($refilename) && $refilename = $filename;

        // 字节流
        header('Content-Type:application/octet-stream');
        header('Accept-Ranges: bytes');
        header('Accept-Length: ' . $fileSize);
        header('Content-Disposition: attachment;filename='.basename($refilename));
 
        // 校验是否限速(超过1M自动限速,同时下载速度设为1M)
        $limit = 1 * 1024 * 1024;

        if( $fileSize <= $limit )
        {
            readfile($filename);
        }
        else
        {
            // 读取文件资源
            $file = fopen($filename, 'rb');

            // 强制结束缓冲并输出
            ob_end_clean();
            ob_implicit_flush();
            header('X-Accel-Buffering: no');

            // 读取位置标
            $count = 0;

            // 下载
            while (!feof($file) && $fileSize - $count > 0) 
            {
                $res = fread($file, $limit);
                $count += $limit;
                echo $res;
                sleep(1);
            }

            fclose($file);
        }   

        exit();
    }
}
