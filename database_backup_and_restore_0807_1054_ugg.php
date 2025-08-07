<?php
// 代码生成时间: 2025-08-07 10:54:46
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class DatabaseBackupAndRestore {
    /**
     * Backup the database to a file.
     *
     * @param string $fileName
     * @return bool
     */
    public function backupDatabase($fileName) {
        try {
            // Ensure the backup directory exists
            $backupPath = storage_path('app/backups/');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0777, true);
            }

            // Dump the database to a file
            $command = "mysqldump -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " 