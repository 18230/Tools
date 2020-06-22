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
	 * tmpPath
	 * @var string
	 */
	private $tmpPath;

	/**
	 * filePath
	 * @var string
	 */
	private $filePath;

	/**
	 * fileName
	 * @var string
	 */
	private $fileName;

	/**
	 * num
	 * @var int
	 */
	private $num;

	/**
	 * totalNum
	 * @var int
	 */
	private $totalNum;
	
    /**
     * 初始化
     *
     * @param string $tmpPath 临时文件
     * @param string $filePath 上传的目录
     * @param string $fileName 上传后的文件名
     * @param int $totalNum 文件块总数
     * @param int $num 文件块索引
     *
     * @return void
     */
	public function __construct(string $tmpPath, string $filePath, string $fileName, int $totalNum = 0, int $num = 0)
	{
		$this->tmpPath = $tmpPath;
		$this->filePath = $filePath;
		$this->fileName = $fileName;
		$this->totalNum = $totalNum;
		$this->num = $num;

		// 上传全路径
		$this->path = $this->filePath . '/' . $this->fileName;

		// 上传
		$this->uploadFileBlob();

		// 合并
		$this->mergeFileBlob();
	}

    /**
     * 文件块上传
     *
     * @return void
     */
	private function uploadFileBlob()
	{
		// 分块上传
		$file = $this->path . '_' . $this->num;

		move_uploaded_file($this->tmpPath, $file);
	}

	/**
	 * 文件块合并(采用多次写方式以防止内存不足)
	 *
	 * @return void
	 */
	private function mergeFileBlob()
	{
		if( $this->num == $this->totalNum )
		{
			for ($i = 1; $i <= $this->totalNum; $i++) 
			{ 
				$blob = file_get_contents($this->path . '_' . $i);

				file_put_contents($this->path, $blob, FILE_APPEND|LOCK_EX);
			}

			// 销毁
			$this->removeFileBlob();
		}
	}

	/**
	 * 返回上传结果
	 *
	 * @return int
	 */
	public function returnResult(): int
	{
		if( $this->num == $this->totalNum )
		{
			return file_exists($this->path) ? 1 : 0;
		}
		else
		{
			return -1;
		}
	}

	/**
	 * 文件块删除
	 * 
	 * @return void
	 */
	private function removeFileBlob()
	{
		for ($i = 1; $i <= $this->totalNum; $i++) 
		{
			@unlink($this->path . '_' . $i);
		}
	}
}