<?php
// 代码生成时间: 2025-08-22 20:20:58
use Illuminate\Support\Facades\Http;
use Exception;

class NetworkConnectionChecker {

    /**
     * The base URL to check for network connection.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Constructor to set the base URL.
     *
     * @param string $baseUrl
     */
    public function __construct($baseUrl = 'https://www.google.com') {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Check if the network connection is active.
     *
     * @return bool
     * @throws Exception
     */
    public function checkConnection() {
        try {
            $response = Http::head($this->baseUrl);
            if ($response->successful()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Log the error message for debugging purposes
            // Log::error($e->getMessage());
            throw new Exception("Network connection check failed: " . $e->getMessage());
        }
    }
}

// Usage example

try {
    $checker = new NetworkConnectionChecker();
    if ($checker->checkConnection()) {
        echo "Connection is active.\
";
    } else {
        echo "Connection is not active.\
";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\
";
}
