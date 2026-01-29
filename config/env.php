<?php
/**
 * Environment Configuration Loader
 * Loads environment variables from .env file
 */

class EnvLoader {
    private static $loaded = false;
    private static $env = [];

    /**
     * Load environment variables from .env file
     */
    public static function load() {
        if (self::$loaded) {
            return;
        }

        $envFile = __DIR__ . '/../.env';
        
        if (!file_exists($envFile)) {
            throw new Exception('.env file not found. Please create one from .env.example');
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes if present
                $value = trim($value, '"\'');
                
                // Store in both $_ENV and our static array
                $_ENV[$key] = $value;
                self::$env[$key] = $value;
                putenv("$key=$value");
            }
        }

        self::$loaded = true;
    }

    /**
     * Get environment variable value
     * 
     * @param string $key The environment variable key
     * @param mixed $default Default value if key not found
     * @return mixed
     */
    public static function get($key, $default = null) {
        self::load();
        
        // Check our static array first
        if (isset(self::$env[$key])) {
            return self::$env[$key];
        }
        
        // Check $_ENV
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        
        // Check getenv()
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }
        
        return $default;
    }
}

// Auto-load environment variables
EnvLoader::load();
?>
