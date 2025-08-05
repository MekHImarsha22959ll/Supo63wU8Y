<?php
// 代码生成时间: 2025-08-05 18:05:28
namespace App\Http\Tools;

use Illuminate\Support\Facades\Log;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Exception;
use Symfony\Component\ Finder\ Finder;

class FolderStructureOrganizer
{
    /**
     * 整理指定目录的结构
     *
     * @param string $path 需要整理的目录路径
     * @return void
     */
    public function organize(string $path): void
    {
        try {
            $finder = new Finder();
            $files = $finder->files()->in($path);

            foreach ($files as $file) {
                // 可以在这里添加文件整理的逻辑，例如按照文件类型分类
                // 例如：移动图片到一个专门的文件夹
                if ($file->getExtension() === 'jpg') {
                    // 这里只是一个示例，具体逻辑根据需求实现
                    $this->moveFile($file->getPathname(), "{$path}/images");
                }
            }

            // 递归地整理子目录
            $directories = $finder->directories()->in($path);
            foreach ($directories as $directory) {
                $this->organize($directory->getPathname());
            }
        } catch (Exception $e) {
            Log::error("Error organizing folder structure: {$e->getMessage()}");
        }
    }

    /**
     * 移动文件到指定目录
     *
     * @param string $sourceFilePath 文件的源路径
     * @param string $destinationPath 目标目录路径
     * @return bool
     */
    private function moveFile(string $sourceFilePath, string $destinationPath): bool
    {
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $destinationFilePath = $destinationPath . "/" . basename($sourceFilePath);
        return rename($sourceFilePath, $destinationFilePath);
    }
}
