<?php
// 代码生成时间: 2025-08-02 19:44:33
// audit_log.php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Container\BindingResolutionException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AuditLog {
    /**
     * Logs an audit event.
     *
     * @param string $message The message to log.
     * @param array $context Additional context for the log entry.
     * @return void
     */
    public function log(string $message, array $context = []): void
    {
        try {
            // Retrieve the custom log channel from the config.
            $logChannel = Config::get('logging.channels.audit');

            // If the channel is not defined in the config, throw an exception.
            if (!$logChannel) {
                throw new \Exception('Audit log channel is not configured.');
            }

            // Create a logger instance.
            $logger = Log::channel($logChannel);

            // Add the audit log entry.
            $logger->info($message, $context);
        } catch (BindingResolutionException $e) {
            // Handle container binding resolution errors gracefully.
            Log::error('Failed to resolve logger channel: ' . $e->getMessage());
        } catch (Exception $e) {
            // Handle any other unexpected errors.
            Log::error('An error occurred while logging audit event: ' . $e->getMessage());
        }
    }
}
