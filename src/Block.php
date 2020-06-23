<?php

/**
 * @author devkeep <devkeep@skeep.cc>
 * @link https://github.com/aiqq363927173/Tools
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @copyright The PHP-Tools
 */
declare(strict_types = 1);

namespace devkeep\Tools;

class Block
{

	/**
	 * params

	 * @var array
	 */
	private $params;

    /**
     * 初始化
     *
     * @param string $tmpPath 临时文件
     * @param string $filePath 上传的目录
     * @param string $fileSize 文件总大小
     * @param int $num 文件块索引
     * @param int $totalNum 文件块总数
     *
     * @return void
     */
	public function __construct(array $params)
	{
		$this->params = $params;

		// 上传
		$this->uploadFileBlob();
	}

    /**
     * 文件块上传(采用多次写防止内存不足)
     *
     * @return void
     */
	private function uploadFileBlob()
	{
		// 文件块读写
		$blob = file_get_contents($this->params['tmpPath']);

		file_put_contents($this->params['filePath'], $blob, FILE_APPEND|LOCK_EX);
	}

	/**
	 * 返回上传结果
	 *
	 * @return int
	 */
	public function returnResult(): int
	{
		if( $this->params['num'] == $this->params['totalNum'] )
		{
			// 文件校验
			return file_exists($this->params['filePath']) && filesize($this->params['filePath']) == $this->params['fileSize'] ? 1 : 0;
		}
		else
		{
			return -1;
		}
	}
}