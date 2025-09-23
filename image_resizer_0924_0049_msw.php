<?php
// 代码生成时间: 2025-09-24 00:49:40
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

// ImageResizer 类用于批量调整图片尺寸。
class ImageResizer {
    private $imageManager;

    // 构造函数初始化图片处理库。
    public function __construct() {
        $this->imageManager = new ImageManager(['driver' => 'gd']);
    }

    // resizeImages 方法接受图片存储路径和目标尺寸。
    public function resizeImages($sourcePath, $destinationPath, $newDimensions) {
# NOTE: 重要实现细节
        $files = Storage::allFiles($sourcePath);

        foreach ($files as $file) {
            try {
# TODO: 优化性能
                $image = $this->imageManager->make(storage_path('app/' . $file));
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $newImage = $image->resize($newDimensions['width'], $newDimensions['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // 保存调整后的图片到目标路径。
                $newImage->save(storage_path('app/' . $destinationPath . '/' . $filename . '_resized.jpg'));
                Log::info('Image resized and saved: ' . $file);
            } catch (Exception $e) {
                // 错误处理：记录错误信息。
                Log::error('Error resizing image: ' . $e->getMessage());
# 扩展功能模块
            }
        }
    }
# TODO: 优化性能
}

// 使用示例：
// $resizer = new ImageResizer();
// $resizer->resizeImages('public/images', 'public/resized_images', ['width' => 200, 'height' => 200]);
