<?php
// 代码生成时间: 2025-09-01 00:55:46
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;
use ZipArchive;
use PharData;
use Exception;

class FileExtractor {

    /**
     * The path to the file to extract.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The path to extract the files to.
     *
     * @var string
     */
    protected $destinationPath;

    
    /**
     * Create a new FileExtractor instance.
     *
     * @param string $filePath The path to the file to extract.
     * @param string $destinationPath The path to extract the files to.
     */
    public function __construct($filePath, $destinationPath) {
        $this->filePath = $filePath;
        $this->destinationPath = $destinationPath;
    }

    /**
     * Extract the file.
     *
     * @return bool Returns true on success or false on failure.
     * @throws Exception If an error occurs during extraction.
     */
    public function extract() {
        try {
            // Check if the file exists
            if (!file_exists($this->filePath)) {
                throw new Exception('File does not exist.');
            }

            // Check if the destination directory exists, if not create it
            if (!is_dir($this->destinationPath)) {
                mkdir($this->destinationPath, 0777, true);
            }

            // Extract the file based on its type
            switch ($this->getFileType($this->filePath)) {
                case 'zip':
                    return $this->extractZip($this->filePath, $this->destinationPath);
                case 'tar':
                    return $this->extractTar($this->filePath, $this->destinationPath);
                default:
                    throw new Exception('Unsupported file type.');
            }
        } catch (Exception $e) {
            // Log the error and rethrow the exception
            \Log::error('Extraction failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get the file type.
     *
     * @param string $filePath The path to the file.
     * @return string The file type (zip, tar, etc.).
     */
    protected function getFileType($filePath) {
        $fileInfo = new info(FILEINFO_MIME_TYPE);
        return strtolower($fileInfo->file($filePath));
    }

    /**
     * Extract a ZIP file.
     *
     * @param string $filePath The path to the ZIP file.
     * @param string $destinationPath The path to extract the files to.
     * @return bool Returns true on success or false on failure.
     */
    protected function extractZip($filePath, $destinationPath) {
        $zip = new ZipArchive;
        if ($zip->open($filePath) === true) {
            $zip->extractTo($destinationPath);
            $zip->close();
            return true;
        }
        return false;
    }

    /**
     * Extract a TAR file.
     *
     * @param string $filePath The path to the TAR file.
     * @param string $destinationPath The path to extract the files to.
     * @return bool Returns true on success or false on failure.
     */
    protected function extractTar($filePath, $destinationPath) {
        $phar = new PharData($filePath);
        $files = $phar->extractTo($destinationPath, null, true);
        return count($files) > 0;
    }
}

// Usage example:
try {
    $extractor = new FileExtractor('path/to/your/file.zip', 'path/to/destination/folder');
    $extractor->extract();
    echo 'Extraction complete.';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}