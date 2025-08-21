<?php
// 代码生成时间: 2025-08-22 01:09:57
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageResizer {
    /**
     * Resize images in a given directory to a specified size.
     *
     * @param string $directory The directory path containing images.
     * @param string $targetWidth The target width for resizing.
     * @param string $targetHeight The target height for resizing.
     * @param string $outputDirectory The directory path for resized images.
     * @return void
     * @throws Exception
     */
    public function resizeImages(string $directory, string $targetWidth, string $targetHeight, string $outputDirectory): void
    {
        // Check if the directory exists
        if (!is_dir($directory)) {
            throw new Exception("The directory {$directory} does not exist.");
        }

        // Create output directory if it doesn't exist
        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }

        // Get all image files in the directory
        $files = scandir($directory);

        foreach ($files as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                $originalPath = $directory . '/' . $file;
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $outputPath = $outputDirectory . '/' . $filename . '_resized.' . $extension;

                // Resize image using Intervention Image
                $image = Image::make($originalPath);
                $image->resize($targetWidth, $targetHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Save the resized image
                $image->save($outputPath);
            }
        }
    }
}

// Example usage
try {
    $imageResizer = new ImageResizer();
    $imageResizer->resizeImages(
        "path/to/input/directory",
        "800",
        "600",
        "path/to/output/directory"
    );
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
