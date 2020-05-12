<?php

/**
 * Tools.
 * User: devkeep
 * Date: 2020/05/08
 */

namespace devkeep\Tools;

class Tools
{
    /**
     * 获取系统类型
     *
     * @return string
     */
    static public function getOS() 
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
     * XML转数组
     *
     * @param string $xml xml
     *
     * @return array
     */
    static public function xmlToArray($xml)
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
    static public function arrayToXml($input)
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
    static public function get(string $url, $header = null)
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

    /**
     * 文件打包下载

     * @param string $downloadZip 打包后下载的文件名
     * @param array $list 打包文件组

     * @return void
     */
    static public function addZip($downloadZip, $list)
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
    static public function unZip($zipName, $dest)
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
    static public function download($filename, $refilename = null)
    {
        if(!is_file($filename)||!is_readable($filename)) 
        {
            return false;
        }

        //通过header()发送头信息
        //告诉浏览器输出的是字节流
        header('Content-Type:application/octet-stream');
 
        //告诉浏览器返回的文件大小是按照字节进行计算的
        header('Accept-Ranges: bytes');
 
        //告诉浏览器返回的文件大小
        header('Accept-Length: '.filesize($filename));

        // 文件重命名
        !isset($refilename) && $refilename = $filename;
 
        //告诉浏览器文件作为附件处理，告诉浏览器最终下载完的文件名称
        header('Content-Disposition: attachment;filename='.basename($refilename));
 
        //读取文件中的内容
        readfile($filename);

        exit();
    }

    /**
     * 导出excel表格

     * @param array   $columName  第一行的列名称
     * @param array   $list       二维数组
     * @param array   $fileName   文件名称
     * @param string  $setTitle   sheet名称
     * @param string  $table   表单元格，用于合并
     *
     * @return void
     */
    static public function exportExcel($columName, $list, $fileName = 'demo', $setTitle = 'Sheet1', $table = [])
    {
        if ( empty($columName) || empty($list) )
        {
            return '列名或者内容不能为空';
        }

        if ( count($list[0]) != count($columName) )
        {
            return '列名跟数据的列不一致';
        }

        //实例化PHPExcel类
        $PHPExcel = new \PHPExcel();

        //获得当前sheet对象
        $PHPSheet = $PHPExcel->getActiveSheet();

        //定义sheet名称
        $PHPSheet->setTitle($setTitle);

        //Excel列
        $letter = [
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK',
        ];

        // 设置字体大小
        $PHPSheet->getDefaultStyle()->getFont()->setSize(12);

        // 水平居中
        $PHPSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 垂直居中
        $PHPSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // 合并单元格
        if(count($table) > 0)
        {
            foreach ($table as $res)
            {
                $PHPSheet->mergeCells($res);
            }
        }

        //把列名写入第1行
        for ($i = 0; $i < count($list[0]); $i++)
        {
            //$letter[$i]1 = A1 B1 C1  $letter[$i] = 列1 列2 列3

            // 第一行加粗
            $PHPSheet->getStyle($letter[$i] . '1')->getFont()->setBold(true);

            // 设置值
            $PHPSheet->setCellValue("$letter[$i]1", "$columName[$i]");
        }

        //内容第2行开始
        foreach ($list as $key => $val)
        {
            //array_values 把一维数组的键转为0 1 2 ..
            foreach (array_values($val) as $key2 => $val2)
            {
                //$letter[$key2].($key+2) = A2 B2 C2 ……
                $PHPSheet->setCellValue($letter[$key2] . ($key+2), $val2);

                // 自动换行
                $PHPSheet->getStyle($letter[$key2] . ($key+2))->getAlignment()->setWrapText(true);
            }
        }

        //生成2007版本的xlsx
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel,'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
        $PHPWriter->save("php://output");
    }

    /**
     * 发送邮件

     * @param array  $form 发件人信息
     * @param array  $data 收件人信息
     *
     * @return boolean
     */
    static public function sendMail($form, $data) 
    {    
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);       // 实例化PHPMailer对象
        $mail->CharSet = 'UTF-8';                               // 设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->isSMTP();                                        // 设定使用SMTP服务
        $mail->SMTPDebug = 0;                                   // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
        $mail->SMTPAuth = true;                                 // 启用 SMTP 验证功能
        $mail->SMTPSecure = 'ssl';                              // 使用安全协议
        $mail->isHTML(true);

        // 发件人信息
        $mail->Host = $form['host'];                            // SMTP 服务器
        $mail->Port = $form['port'];                            // SMTP服务器的端口号
        $mail->Username = $form['username'];                    // SMTP服务器用户名
        $mail->Password = $form['password'];                    // SMTP服务器密码
        $mail->SetFrom($form['address'], $form['title']);

        // 阿里云邮箱
        // $mail->Host = "smtp.aliyun.com";                          // SMTP 服务器
        // $mail->Port = 465;                                        // SMTP服务器的端口号
        // $mail->Username = "devkeep@aliyun.com";                   // SMTP服务器用户名
        // $mail->Password = "xxxxxxxxxxxx";                         // SMTP服务器密码
        // $mail->SetFrom('devkeep@aliyun.com', '项目完成通知');

        // 网易邮箱
        // $mail->Host = "smtp.163.com";                           // SMTP 服务器
        // $mail->Port = 465;                                      // SMTP服务器的端口号
        // $mail->Username = "devkeep@163.cc";                     // SMTP服务器用户名
        // $mail->Password = "xxxxxxxxx";                          // SMTP服务器密码
        // $mail->SetFrom('devkeep@163.cc', '系统通知');

        // QQ邮箱
        // $mail->Host = "smtp.qq.com";                            // SMTP 服务器
        // $mail->Port = 465;                                      // SMTP服务器的端口号
        // $mail->Username = "363927173@qq.com";                   // SMTP服务器用户名
        // $mail->Password = "xxxxxxxxxxxxxxxx";                   // SMTP服务器密码
        // $mail->SetFrom('devkeep@skeep.cc', '管理系统');

        // 收件人信息
        $mail->Subject = $data['subject'];
        $mail->MsgHTML($data['body']);
        $mail->AddAddress($data['mail'], $data['name']);

        // $mail->Subject = $subject;
        // $mail->MsgHTML($body);
        // $mail->AddAddress($tomail, $name);

        // 是否携带附件
        if (isset($data['attachment'])) 
        { 
            foreach ($attachment as $file) 
            {
                is_file($file) && $mail->AddAttachment($file);
            }
        }


        return $mail->Send() ? true : $mail->ErrorInfo;
    }

    /**
     * 生成二维码

     * @param array  $text 二维码内容
     * @param array  $outfile 文件
     * @param array  $level 纠错级别
     * @param array  $size 二维码大小
     * @param array  $margin 边距
     * @param array  $saveandprint
     *
     * @return void
     */
    static public function qrcode($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 6, $margin = 2, $saveandprint = false)
    {
        QRcode::png($text, $outfile, $level, $size, $margin, $saveandprint);

        exit();
    }
}
