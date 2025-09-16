<?php
// 代码生成时间: 2025-09-16 12:12:21
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * ErrorLogCollector - Error log collector class
 *
 * This class collects and handles error logs using Laravel's logging facilities and Monolog.
 */
class ErrorLogCollector
{
    protected $logPath;
    protected $logger;

    public function __construct()
    {
        // Set the log path configuration
        $this->logPath = Config::get('logging.channels.daily.path') . 'error-' . date('Y-m-d') . '.log';
        
        // Create a logger instance
        $this->logger = new Logger('errorLogger');
        
        // Set up the log handler
        $stream = new StreamHandler(storage_path($this->logPath), Logger::ERROR);
        $this->logger->pushHandler($stream);
    }

    /**
     * Log an error with a message
     *
     * @param string $message The error message
     * @param array $context Additional context for the error
     */
    public function logError($message, array $context = [])
    {
        try {
            // Log the error message
            $this->logger->error($message, $context);
        } catch (Exception $e) {
            // Handle any exceptions during logging
            Log::error('Error while logging error: ' . $e->getMessage());
        }
    }

    /**
     * Get the current logger instance
     *
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
