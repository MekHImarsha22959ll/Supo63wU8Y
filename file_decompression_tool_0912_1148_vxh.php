<?php
// 代码生成时间: 2025-09-12 11:48:55
use Illuminate\Support\Facades\Storage;
use ZipArchive;

/**
 * 文件压缩解压工具类
 *
 * 该类提供了一个简单的文件压缩和解压功能。
 * 支持.zip格式的文件压缩和解压。
 */
class FileDecompressionTool {

    /**
     * 解压ZIP文件
     *
     * @param string $zipFilePath 要解压的ZIP文件路径
     * @param string $destination 解压后的文件存放目录
     * @return bool 返回解压结果，成功返回true，失败返回false
     */
    public function unzipFile(string $zipFilePath, string $destination): bool {
        try {
            // 创建ZipArchive对象
            $zip = new ZipArchive();

            // 打开ZIP文件
            if ($zip->open($zipFilePath) === true) {
                // 将ZIP文件内容解压到指定目录
                if ($zip->extractTo($destination)) {
                    // 资源回收，关闭ZIP文件
                    $zip->close();
                    return true;
                } else {
                    // 资源回收，关闭ZIP文件
                    $zip->close();
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            // 错误处理
            // 记录错误信息到日志
            // 此处省略日志记录代码
            return false;
        }
    }

    /**
     * 压缩文件
     *
     * @param array $files 要压缩的文件数组
     * @param string $zipFilePath 输出的ZIP文件路径
     * @return bool 返回压缩结果，成功返回true，失败返回false
     */
    public function zipFiles(array $files, string $zipFilePath): bool {
        try {
            // 创建ZipArchive对象
            $zip = new ZipArchive();

            // 创建ZIP文件
            if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
                foreach ($files as $file) {
                    // 将文件添加到ZIP文件
                    if (!$zip->addFile($file, basename($file))) {
                        // 资源回收，关闭ZIP文件
                        $zip->close();
                        return false;
                    }
                }
                // 资源回收，关闭ZIP文件
                $zip->close();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            // 错误处理
            // 记录错误信息到日志
            // 此处省略日志记录代码
            return false;
        }
    }
}
