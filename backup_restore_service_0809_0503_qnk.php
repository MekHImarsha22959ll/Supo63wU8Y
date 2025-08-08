<?php
// 代码生成时间: 2025-08-09 05:03:21
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class BackupRestoreService {
    /**
     * 备份数据库到指定文件
     *
     * @param string $backupFileName 文件名
     * @return bool
     */
    public function backupDatabase(string $backupFileName): bool
    {
        try {
            // 连接数据库
            $connection = DB::getPdo();

            // 打开文件句柄
            $fileHandle = fopen(storage_path('app/' . $backupFileName), 'w+');
            if (!$fileHandle) {
                throw new Exception('无法打开文件句柄。');
            }

            // 获取数据库中的数据
            $dump = '';
            foreach ($connection->query('SHOW TABLES') as $row) {
                $tableName = $row[0];
                $dump .= 'DROP TABLE IF EXISTS `' . $tableName . '`;' . PHP_EOL;
                foreach ($connection->query('SHOW CREATE TABLE ' . $tableName) as $row) {
                    $dump .= $row[1] . ';' . PHP_EOL . PHP_EOL;
                }
                foreach ($connection->query('SELECT * FROM ' . $tableName) as $row) {
                    $dump .= 'INSERT INTO `' . $tableName . '` VALUES(' . implode(', ', array_map(function($item) {
                        return '\'' . addcslashes($item, "\'") . '\'';
                    }, $row)) . ');' . PHP_EOL;
                }
            }

            // 写入文件
            fwrite($fileHandle, $dump);
            fclose($fileHandle);

            return true;
        } catch (Exception $e) {
            // 错误处理
            Log::error('数据库备份失败: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 从指定文件恢复数据库
     *
     * @param string $backupFileName 文件名
     * @return bool
     */
    public function restoreDatabase(string $backupFileName): bool
    {
        try {
            // 检查文件是否存在
            if (!Storage::exists('app/' . $backupFileName)) {
                throw new Exception('备份文件不存在。');
            }

            // 读取文件内容
            $backupContent = Storage::get('app/' . $backupFileName);

            // 执行SQL语句
            DB::unprepared($backupContent);

            return true;
        } catch (Exception $e) {
            // 错误处理
            Log::error('数据库恢复失败: ' . $e->getMessage());
            return false;
        }
    }
}
