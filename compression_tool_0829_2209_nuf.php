<?php
// 代码生成时间: 2025-08-29 22:09:23
use Illuminate\Support\Facades\Storage;
use ZipArchive;

/**
 * CompressionTool class for handling file compression and extraction.
 *
 * @author Your Name
 * @version 1.0
 */
class CompressionTool {

    /**
     * Compress a directory into a ZIP file.
     *
     * @param string $sourceDir The directory path to compress.
     * @param string $destinationFile The destination ZIP file path.
     * @return bool
     */
    public function compressDirectory(string $sourceDir, string $destinationFile): bool {
        if (!file_exists($sourceDir)) {
            // Handle error: Directory does not exist.
            return false;
        }

        $zip = new ZipArchive();
        $zip->open($destinationFile, ZipArchive::CREATE);
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($sourceDir) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
        return true;
    }

    /**
     * Extract a ZIP file to a specified directory.
     *
     * @param string $zipFile The ZIP file path to extract.
     * @param string $destinationDir The destination directory path.
     * @return bool
     */
    public function extractZipFile(string $zipFile, string $destinationDir): bool {
        if (!file_exists($zipFile)) {
            // Handle error: File does not exist.
            return false;
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFile) === true) {
            $zip->extractTo($destinationDir);
            $zip->close();
            return true;
        } else {
            // Handle error: Unable to open ZIP file.
            return false;
        }
    }
}
