<?php
// 代码生成时间: 2025-10-02 02:12:24
namespace App\Services;

use App\Exceptions\DesensitizationException;
use Exception;

class DataDesensitizationTool
{
    /**
     * Desensitize the given data using a predefined pattern.
     *
     * @param string $data The data to be desensitized.
     * @param string $pattern The pattern to use for desensitization, defaults to '****'.
     *
     * @return string The desensitized data.
     *
     * @throws DesensitizationException If an error occurs during desensitization.
     */
    public function desensitize(string $data, string $pattern = '****'): string
    {
        try {
            // Validate the input data
            if (empty($data)) {
                throw new DesensitizationException('No data provided for desensitization.');
            }

            // Desensitize the data
            return $this->applyPattern($data, $pattern);
        } catch (Exception $e) {
            // Handle any exceptions that may occur
            throw new DesensitizationException('Error desensitizing data: ' . $e->getMessage());
        }
    }

    /**
     * Apply the desensitization pattern to the data.
     *
     * @param string $data The data to be desensitized.
     * @param string $pattern The pattern to use for desensitization.
     *
     * @return string The desensitized data.
     */
    protected function applyPattern(string $data, string $pattern): string
    {
        // Replace the data with the pattern, leaving the first and last characters unchanged
        return mb_substr($data, 0, 1) . str_repeat($pattern, mb_strlen($data) - 2) . mb_substr($data, -1);
    }
}

// Custom exception for desensitization errors
class DesensitizationException extends Exception
{
    // Custom exception handling can be added here
}