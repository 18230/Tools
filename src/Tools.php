<?php

/**
 * Tools.
 * User: devkeep
 * Date: 2020/05/08
 */

namespace devkeep\tools;

class Tools
{
    /**
     * 对象转数组
     * 
     * @param object $object 对象
     * 
     * @return array
     */
    static public function toArray($object)
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * 无限级归类
     * 
     * @param array $list 归类数组
     * @param string $id 父级ID
     * @param string $pid 父级PID
     * @param string $child key
     * @param string $root 顶级
     * 
     * @return array
     */
    static public function tree($list, $pk = 'id', $pid = 'pid', $child = 'child', $root = 0)
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
     * 二维数组去重
     * 
     * @param array $arr 数组
     * @param string $key 字段
     * 
     * @return array
     */
    static public function arrayMultiUnique($arr, $key = 'id')
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
    static public function arrayMultiSort($array, $keys, $sort = 'desc') 
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
     * format 保留两位小数
     * 
     * @param int $input 数值
     * @param int $number 小数位数
     * 
     * @return float
     */
    static public function format($input, $number = 2)
    {
        return sprintf("%." . $number . "f", $input);
    }

    /**
     * get请求
     * 
     * @param string $url URL地址
     * @param string $header header头
     * 
     * @return string
     */
    static public function get($url, $header = null)
    {
        $ch = curl_init();

        if(isset($header))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Post请求
     * 
     * @param string $url URL地址
     * @param string $param 参数
     * @param string $dataType 数据类型
     * 
     * @return string
     */
    static public function post($url, $param = '', $dataType = 'form')
    {
        $dataTypeArr = [
            'form' => ['content-type: application/x-www-form-urlencoded;charset=UTF-8'],
            'json' => ['Content-Type: application/json;charset=utf-8'],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $dataTypeArr[$dataType]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = trim($result, "\xEF\xBB\xBF");
        return $result;
    }
}