<?php
// 代码生成时间: 2025-09-06 07:43:33
class FileUnzipTool {

    /**
     * Unzips a file to a specified directory.
     *
     * @param string $filePath The path to the zip file.
     * @param string $destination The path to the destination directory.
     * @return bool Returns true on success, false on failure.
     */
    public function unzip($filePath, $destination) {
        // Check if the file exists
        if (!file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }

        // Check if the destination directory exists, if not create it
        if (!file_exists($destination)) {
            if (!mkdir($destination, 0777, true)) {
                throw new Exception("Failed to create destination directory: {$destination}");
            }
        }

        // Initialize the ZipArchive class
        $zip = new ZipArchive();

        // Open the zip file
        if ($zip->open($filePath) !== true) {
            throw new Exception("Failed to open zip file: {$filePath}");
        }

        // Extract the zip file
        if ($zip->extractTo($destination) !== true) {
            $zip->close();
            throw new Exception("Failed to extract zip file to: {$destination}");
        }

        // Close the zip file
        $zip->close();

        return true;
    }
}

// Example usage
try {
    $unzipTool = new FileUnzipTool();
    $filePath = 'path/to/your/file.zip';
    $destination = 'path/to/destination/directory';

    if ($unzipTool->unzip($filePath, $destination)) {
        echo "File unzipped successfully.
";
    } else {
        echo "Failed to unzip file.
";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "
";
}
