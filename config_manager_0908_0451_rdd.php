<?php
// 代码生成时间: 2025-09-08 04:51:20
class ConfigManager {

    /**
     * Load a configuration file.
     *
     * @param string $fileName
     * @return array
     */
    public function loadConfig(string $fileName): array {
        // Check if the file exists
        if (!file_exists($fileName)) {
            throw new \Exception("Configuration file not found: {$fileName}");
        }

        // Return the configuration data as an associative array
        return $this->parseConfig(file_get_contents($fileName));
    }

    /**
     * Parse the configuration data from a string.
     *
     * @param string $data
     * @return array
     */
    private function parseConfig(string $data): array {
        // Assuming the config file is in PHP format, we can use eval()
        // But for better security, we should use a safer method like parsing JSON or INI files
        // Here we are using eval() for simplicity, but in production, consider using a safer method
        $config = eval('?' . '>' . $data);

        // Check if the parsed data is an array
        if (!is_array($config)) {
            throw new \Exception("Invalid configuration data");
        }

        return $config;
    }

    /**
     * Save a configuration file.
     *
     * @param string $fileName
     * @param array $data
     * @return bool
     */
    public function saveConfig(string $fileName, array $data): bool {
        // Convert the array to a PHP format string
        $dataString = var_export($data, true);

        // Check if the file can be written
        if (file_exists($fileName) && !is_writable($fileName)) {
            throw new \Exception("Configuration file is not writable: {$fileName}");
        } elseif (!file_exists($fileName) && !is_writable(dirname($fileName))) {
            throw new \Exception("Directory is not writable: {$fileName}");
        }

        // Save the configuration data to the file
        return file_put_contents($fileName, '<?php return ' . $dataString . ';') === strlen($dataString);
    }
}
