<?php
// 代码生成时间: 2025-09-13 01:50:52
require_once 'vendor/autoload.php';

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class ImageResizerService
{
    /**
     * Resize images in the specified directory.
     *
     * @param string $sourceDirectory The source directory containing images.
     * @param string $destinationDirectory The destination directory for resized images.
     * @param int $width New width for the images.
     * @param int $height New height for the images.
     * @return array
     */
    public function resizeImages($sourceDirectory, $destinationDirectory, $width, $height)
    {
        // Initialize the Image Manager with preferred driver.
        $imageManager = new ImageManager(array('driver' => 'gd'));
        
        // Check if the source directory exists.
        if (!file_exists($sourceDirectory)) {
            return ['error' => 'Source directory does not exist.'];
        }

        // Check if the destination directory is writable.
        if (!is_writable($destinationDirectory)) {
            return ['error' => 'Destination directory is not writable.'];
        }

        // Initialize an array to store the results.
        $results = [];
        
        // Get all files in the source directory.
        $files = scandir($sourceDirectory);
        
        foreach ($files as $file) {
            // Skip the '.' and '..' entries.
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            // Construct the full file path.
            $filePath = $sourceDirectory . '/' . $file;
            
            try {
                // Attempt to resize the image.
                $image = $imageManager->make($filePath)->resize($width, $height);
                
                // Construct the destination file path.
                $destinationFilePath = $destinationDirectory . '/' . $file;
                
                // Save the resized image to the destination directory.
                $image->save($destinationFilePath);
                
                // Add a success message to the results array.
                $results[$file] = 'Resized successfully.';
            } catch (Exception $e) {
                // Handle any exceptions that occur during the resizing process.
                $results[$file] = 'Error: ' . $e->getMessage();
            }
        }
        
        return $results;
    }
}

// Usage example:
// $resizer = new ImageResizerService();
// $results = $resizer->resizeImages('/path/to/source', '/path/to/destination', 800, 600);
// print_r($results);