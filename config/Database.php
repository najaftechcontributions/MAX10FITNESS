<?php
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/../database/init.php';

class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    private static $initialized = false;

    // Constructor
    public function __construct() {
        // Load database credentials from .env file
        $this->host = EnvLoader::get('DB_HOST', '127.0.0.1');
        $this->port = EnvLoader::get('DB_PORT', '3306');
        $this->db_name = EnvLoader::get('DB_NAME', 'max1on1fitness');
        $this->username = EnvLoader::get('DB_USER', 'root');
        $this->password = EnvLoader::get('DB_PASS', 'root');
        $this->conn = null;
        $this->autoInitialize();
    }

    // Auto-initialize database on first use
    private function autoInitialize() {
        if (!self::$initialized) {
            self::$initialized = true; // Set this first to prevent recursion
            try {
                $initializer = new DatabaseInitializer();
                if (!$initializer->checkIfInitialized()) {
                    if (php_sapi_name() === 'cli') {
                        echo "Database not initialized. Initializing now...\n";
                    }
                    error_log("Database not initialized. Initializing now...");
                    $initializer->initialize();
                }
            } catch (Exception $e) {
                error_log("Auto-initialization error: " . $e->getMessage());
                if (php_sapi_name() === 'cli') {
                    echo "Auto-initialization error: " . $e->getMessage() . "\n";
                }
                // Continue anyway - connection attempt will show specific error
            }
        }
    }

    // Get database connection
    public function getConnection() {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Connection Error: " . $e->getMessage() . "\n";
            error_log("Connection Error: " . $e->getMessage());
            $this->conn = null;
        }

        return $this->conn;
    }

    // Close connection
    public function closeConnection() {
        $this->conn = null;
    }
}
?>
