<?php

// ====================================================================
// 基础配置(根据业务目录配置)
// ====================================================================

// 文档名称
$title = 'APIdoc';

// 基础域名配置
$host = 'http://www.888.com';

// 要生成的PHP代码目录
$dir = 'E:/worker/tp6/app/index/controller/';


// 注释示例
/**
 * 首页 /index/index
 * @method post
 * @group Index
 * 
 * @header string uid UID
 * 
 * @param string title 标题
 * @param string content 文章
 */




// =====================================================================
// 文档生成功能
// =====================================================================

// 文件集合
$files = [];

if (is_dir($dir)) 
{
	if ($handle = opendir($dir)) 
	{
		while (($file = readdir($handle)) !== false)
		{
			if ($file != '' && $file != '..')
			{
				// 是否为目录
				if (!is_dir($dir . '/' . $file)) 
				{
					$files[] = $file;
				}
			}
		}
	}
}

// var_dump($files);exit;

$result = [];

foreach ($files as $key => $val) 
{
	// 读取文件
	$content = file_get_contents($dir . $val);

	// 提取文档
	preg_match_all('/\/\*\*[\s\S]*?\*\//i', $content, $res);

	// 校验
	if(empty($res) || count($res) == 0)
	{
		break;
	}

	// 解析字符串
	foreach ($res[0] as $k => &$v) 
	{
		if(strpos($v, '@method') !== false)
		{
			$v = explode("\n", $v);
			$count = count($v);

			for ($i = 0; $i < $count; $i++) 
			{ 
		    	$v[$i] = str_replace('/**', '', $v[$i]);
		    	$v[$i] = str_replace('*/', '', $v[$i]);
		    	$v[$i] = str_replace('*', '', $v[$i]);
		    	$v[$i] = trim($v[$i]);
		    	$v[$i] = preg_replace( "/\s(?=\s)/","\\1", $v[$i]);
			}

			$v = array_values(array_filter($v));
		}
		else
		{
			$v = null;
		}
	}

	unset($v);

	$result[] = array_filter($res[0]);
}

	// echo '<pre>';
	// print_r($result);
	// exit;

?>




<html>
    <meta charset="utf-8" />
    <title><?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="API doc" name="description" />
    <meta content="devkeep" name="author" />

    <style>

		body{
		    margin: 0;
		    padding: 0;
		    font-family:"Times New Roman",Georgia,Serif;
		}

		a{
			text-decoration: none;
			display: block;
			width: 100%;
			height: 100%;
			color: #333;
		}

		.top
		{
		    width: 100%;
		    border-bottom: 1px #ccc solid;
		    height: 40px;
		    line-height: 40px;
		    font-weight: bold;
		    font-size: 16px;
		    overflow: hidden;
		    position:fixed;
		    text-align: left;
		    top: 0;
		    left: 0;
		    text-indent: 10px;
		    background: #fff;
		}

		.left
		{
		    width: 200px;
		    height: 94%;
		    border-right:1px #ccc solid;
		    overflow: auto;
		    position: fixed;
		    top: 51px;
		    left: 0;
		}

		.content
		{
		    margin-top: 50px;
		    margin-left: 250px;
		}

		.left ul
		{
		    width: 100%;
		    margin: 0;
		    padding: 0;
		    overflow: hidden;
		}

		.left ul li
		{
		    height: 32px;
		    line-height: 32px;
		    text-align: left;
		    padding: 0 15px;
		    font-size: 14px;
		    list-style-type:none;
		    position: relative;
		    cursor: pointer;
		    font-weight: bold;
		    color: #333;
		}

		.table
		{
			width: 50%;
			border-collapse:collapse;
			margin-bottom: 30px;
			background: #fbfbfb;
			box-shadow:0px 0px 8px #666;
		}

		.table tr td
		{
			border: 1px #ccc solid;
			padding: 10px;
		}

		.act
		{
			background: #0088cc;
			color: #fff !important;
		}

    </style>

    <body>

        <div class="top"><?php echo $title; ?></div>
        
        <div class="left">
            <ul class="ul">
            	<?php 
            		foreach ($result as $key => $val) 
            		{
            			foreach ($val as $k => $v) 
            			{
            				$toper = explode(' ', $v[0]);
            				echo '<li data-tag="'.$toper[1].'">'.$toper[0].'</li>';
            			}
            		}
            	?>
            </ul>
	    
        </div>

        <div class="content">
        	<?php foreach ($result as $key => $val) { ?>

        		<?php foreach ($val as $k => $v) { ?>

        			<?php $toper = explode(' ', $v[0]); ?>
        			<?php $num = count($v); ?>

        			<div id="<?php echo $toper[1]; ?>" style="padding: 25px;"></div>
        			<table class="table" border="1" cellspacing="1" cellpadding="0">

			        	<?php for ($i = 0; $i < $num; $i++) { ?> 
			        	<tr>
				        <?php $dd = explode(' ', $v[$i]); ?> 

				        	<?php for ($j = 0; $j < count($dd); $j++) { ?> 

				        		<td><?php echo $i == 0 && $j == 1 ? $host.$dd[$j] : $dd[$j]; ?></td>

				        	<?php } ?>
				        </tr>
			        	<?php } ?>

            		</table>

        		<?php } ?>

        	<?php } ?>
        </div>

        <!-- 引入库 -->
        <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

        <script type="text/javascript">
        	
        	$('ul').find('li').on('click', function()
        	{
        		$('ul').find('li').removeClass();
        		$(this).addClass('act');

        		var tag = $(this).attr('data-tag');

        		window.location.hash = "#" + tag;
        	})

        </script>
        
    </body>
</html>




















