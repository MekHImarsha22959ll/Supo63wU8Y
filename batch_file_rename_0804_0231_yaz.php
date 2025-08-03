<?php
// 代码生成时间: 2025-08-04 02:31:30
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

// BatchFileRenamer 类定义了一个批量文件重命名工具
class BatchFileRenamer {
    // 存储目录路径
    private $storagePath;

    // 构造函数
    public function __construct($storagePath) {
        $this->storagePath = $storagePath;
    }

    // 重命名指定目录下的所有文件
    public function renameFiles($newNamePattern) {
        $files = Storage::disk('local')->files($this->storagePath);

        foreach ($files as $file) {
            try {
                // 获取原始文件名
                $originalName = basename($file);

                // 生成新文件名
                $newName = $this->generateNewName($originalName, $newNamePattern);

                // 重命名文件
                Storage::disk('local')->move($file, $this->storagePath . '/' . $newName);
            } catch (\Exception $e) {
                // 错误处理
                error_log('Error renaming file: ' . $file . ' - ' . $e->getMessage());
            }
        }
    }

    // 生成新文件名
    private function generateNewName($originalName, $newNamePattern) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $newNameWithoutExtension = preg_replace('/\.' . $extension . '$/', '', $originalName);

        return $newNamePattern . '_' . $newNameWithoutExtension . '.' . $extension;
    }
}

// 使用示例
try {
    $renamer = new BatchFileRenamer('storage/app/files');
    $renamer->renameFiles('new-');
} catch (\Exception $e) {
    error_log('Error in batch file renamer: ' . $e->getMessage());
}
