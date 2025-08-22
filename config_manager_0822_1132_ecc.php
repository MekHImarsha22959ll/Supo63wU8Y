<?php
// 代码生成时间: 2025-08-22 11:32:32
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;

/**
 * Config Manager handles configuration operations.
 */
class ConfigManager {

    protected $configPath;

    /**
     * Constructor to initialize the config path.
     *
     * @param string $configPath
     */
    public function __construct($configPath = 'config/') {
        $this->configPath = $configPath;
    }

    /**
     * Get a configuration value by key.
     *
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public function getValue($key) {
        try {
            return Config::get($key);
        } catch (Exception $e) {
            throw new Exception("Failed to get the configuration value for key: {$key}. Error: {$e->getMessage()}");
        }
    }

    /**
     * Set a configuration value by key and save it to the configuration file.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     * @throws Exception
     */
    public function setValue($key, $value) {
        try {
            Config::set($key, $value);
            return $this->saveConfig();
        } catch (Exception $e) {
            throw new Exception("Failed to set the configuration value for key: {$key}. Error: {$e->getMessage()}");
        }
    }

    /**
     * Save the updated configuration to the configuration file.
     *
     * @return bool
     * @throws Exception
     */
    protected function saveConfig() {
        try {
            $config = Config::all();
            return file_put_contents($this->configPath . 'app.php', '<?php return ' . var_export($config, true) . ';') !== false;
        } catch (Exception $e) {
            throw new Exception("Failed to save the configuration. Error: {$e->getMessage()}");
        }
    }

    /**
     * Validate the configuration data.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateConfigData($data) {
        $validator = Validator::make($data, [
            'app_name' => 'required|string',
            'app_env' => 'required|in:local,production,testing',
            'key' => 'required|string',
            'debug' => 'required|boolean',
        ]);

        return $validator;
    }
}
