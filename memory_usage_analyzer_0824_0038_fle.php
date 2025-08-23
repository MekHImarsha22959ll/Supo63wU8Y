<?php
// 代码生成时间: 2025-08-24 00:38:21
 * It includes error handling and follows PHP best practices for maintainability and scalability.
 */
class MemoryUsageAnalyzer {

    public function analyze() {
        // Check if the memory_get_usage function is available
        if (!function_exists('memory_get_usage')) {
            throw new Exception('Memory usage analysis is not supported on this system.');
        }

        // Get the current memory usage
        $currentMemoryUsage = memory_get_usage();

        // Get the peak memory usage
        $peakMemoryUsage = memory_get_peak_usage();

        // Return the memory usage report
        return $this->generateReport($currentMemoryUsage, $peakMemoryUsage);
    }

    /**
     * Generates a memory usage report.
     *
     * @param int $currentMemoryUsage Current memory usage in bytes
     * @param int $peakMemoryUsage Peak memory usage in bytes
     * @return array Memory usage report
     */
    protected function generateReport($currentMemoryUsage, $peakMemoryUsage) {
        // Format the memory usage values for better readability
        $currentMemoryUsageFormatted = $this->formatMemoryValue($currentMemoryUsage);
        $peakMemoryUsageFormatted = $this->formatMemoryValue($peakMemoryUsage);

        return [
            'current_memory_usage' => $currentMemoryUsageFormatted,
            'peak_memory_usage' => $peakMemoryUsageFormatted,
        ];
    }

    /**
     * Formats a memory value for better readability.
     *
     * @param int $memoryValue Memory value in bytes
     * @return string Formatted memory value
     */
    protected function formatMemoryValue($memoryValue) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $power = 0;

        while ($memoryValue > 1024 && $power < count($units) - 1) {
            $memoryValue /= 1024;
            $power++;
        }

        return round($memoryValue, 2) . ' ' . $units[$power];
    }
}

// Usage example:
try {
    $analyzer = new MemoryUsageAnalyzer();
    $report = $analyzer->analyze();
    echo "Current Memory Usage: " . $report['current_memory_usage'] . "
";
    echo "Peak Memory Usage: " . $report['peak_memory_usage'] . "
";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "
";
}