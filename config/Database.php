<?php
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/../database/init.php';

class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $db_connection;
    private $turso_url;
    private $turso_token;
    private $conn;
    private static $initialized = false;

    // Constructor
    public function __construct() {
        // Load database type
        $this->db_connection = EnvLoader::get('DB_CONNECTION', 'mysql');

        if ($this->db_connection === 'turso') {
            // Load Turso credentials
            $this->turso_url = EnvLoader::get('TURSO_DATABASE_URL');
            $this->turso_token = EnvLoader::get('TURSO_AUTH_TOKEN');
        } else {
            // Load MySQL credentials
            $this->host = EnvLoader::get('DB_HOST', '127.0.0.1');
            $this->port = EnvLoader::get('DB_PORT', '3306');
            $this->db_name = EnvLoader::get('DB_NAME', 'max1on1fitness');
            $this->username = EnvLoader::get('DB_USER', 'root');
            $this->password = EnvLoader::get('DB_PASS', 'root');
        }

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
            if ($this->db_connection === 'turso') {
                $this->conn = $this->createTursoConnection();
            } else {
                $this->conn = $this->createMySQLConnection();
            }
        } catch(Exception $e) {
            echo "Connection Error: " . $e->getMessage() . "\n";
            error_log("Connection Error: " . $e->getMessage());
            $this->conn = null;
        }

        return $this->conn;
    }

    // Create MySQL connection
    private function createMySQLConnection() {
        $conn = new PDO(
            "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
            $this->username,
            $this->password
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    }

    // Create Turso connection (using libSQL over HTTP)
    private function createTursoConnection() {
        if (empty($this->turso_url) || empty($this->turso_token)) {
            throw new Exception('Turso credentials not configured. Please set TURSO_DATABASE_URL and TURSO_AUTH_TOKEN in .env');
        }

        // Turso uses libSQL which is SQLite-compatible
        // We'll create a TursoPDO wrapper that implements PDO-like interface
        require_once __DIR__ . '/TursoPDO.php';
        $conn = new TursoPDO($this->turso_url, $this->turso_token);
        return $conn;
    }

    // Close connection
    public function closeConnection() {
        $this->conn = null;
    }

    // Get database type
    public function getConnectionType() {
        return $this->db_connection;
    }
}
?>
