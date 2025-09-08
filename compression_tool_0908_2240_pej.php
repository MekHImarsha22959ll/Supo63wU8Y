<?php
// 代码生成时间: 2025-09-08 22:40:11
class CompressionTool {

    /**
     * 解压指定的压缩文件到目标目录
     *
     * @param string $archivePath 压缩文件路径
     * @param string $destination 目标解压目录
     * @return bool
     */
    public function decompress(string $archivePath, string $destination): bool {
# 添加错误处理
        // 检查压缩文件是否存在
        if (!file_exists($archivePath)) {
            // 记录错误日志
            \Log::error('压缩文件不存在: ' . $archivePath);
            return false;
        }

        // 检查目标目录是否存在，如果不存在则创建
        if (!is_dir($destination)) {
            if (!mkdir($destination, 0777, true)) {
                // 记录错误日志
                \Log::error('无法创建目标目录: ' . $destination);
# 增强安全性
                return false;
            }
        }

        // 根据文件后缀名选择不同的解压方法
        $extension = strtolower(pathinfo($archivePath, PATHINFO_EXTENSION));
# FIXME: 处理边界情况
        switch ($extension) {
            case 'zip':
                return $this->decompressZip($archivePath, $destination);
            case 'tar':
# NOTE: 重要实现细节
            case 'tar.gz':
            case 'tgz':
# 增强安全性
                return $this->decompressTar($archivePath, $destination);
            default:
                // 记录错误日志
                \Log::error('不支持的压缩文件类型: ' . $extension);
# NOTE: 重要实现细节
                return false;
        }
    }

    /**
     * 解压ZIP文件
     *
     * @param string $archivePath
     * @param string $destination
# FIXME: 处理边界情况
     * @return bool
     */
    private function decompressZip(string $archivePath, string $destination): bool {
        // 使用ZipArchive类进行解压
        $zip = new \ZipArchive();
        if ($zip->open($archivePath) === true) {
            $zip->extractTo($destination);
# FIXME: 处理边界情况
            $zip->close();
            return true;
        } else {
            // 记录错误日志
            \Log::error('解压ZIP文件失败: ' . $archivePath);
            return false;
        }
    }

    /**
     * 解压TAR文件
# 优化算法效率
     *
     * @param string $archivePath
     * @param string $destination
     * @return bool
     */
    private function decompressTar(string $archivePath, string $destination): bool {
        // 使用PharData类进行解压
        $phar = new \PharData($archivePath);
        if ($phar->extractTo($destination, null)) {
            return true;
        } else {
            // 记录错误日志
            \Log::error('解压TAR文件失败: ' . $archivePath);
            return false;
        }
    }
}
# TODO: 优化性能
