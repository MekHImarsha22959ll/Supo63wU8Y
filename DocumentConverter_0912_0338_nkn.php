<?php
// 代码生成时间: 2025-09-12 03:38:25
// DocumentConverter.php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use League\CommonMark\CommonMarkConverter;
use League\Flysystem\FileNotFoundException;
use InvalidArgumentException;

class DocumentConverter
{
    // 文件路径
    protected string $filePath;

    // 文件格式
    protected string $format;

    public function __construct(string $filePath, string $format)
    {
        $this->filePath = $filePath;
        $this->format = $format;
    }

    /**
     * 转换文档格式
     *
   * @return string 转换后的文档内容
   */
    public function convert(): string
    {
        try {
            // 检查文件是否存在
            $content = Storage::get($this->filePath);

            if ($content === null) {
                throw new FileNotFoundException("The file at {$this->filePath} does not exist.");
            }

            // 根据文件格式进行转换
            switch ($this->format) {
                case 'markdown':
                    return $this->convertMarkdownToHtml($content);
                default:
                    throw new InvalidArgumentException("Unsupported format: {$this->format}.");
            }
        } catch (FileNotFoundException $exception) {
            // 处理文件未找到异常
            return "Error: {$exception->getMessage()}";
        } catch (InvalidArgumentException $exception) {
            // 处理不支持的格式异常
            return "Error: {$exception->getMessage()}";
        } catch (Exception $exception) {
            // 处理其他异常
            return "Error: {$exception->getMessage()}";
        }
    }

    // 将Markdown转换为HTML
    protected function convertMarkdownToHtml(string $content): string
    {
        $converter = new CommonMarkConverter();

        return $converter->convert($content);
    }
}
