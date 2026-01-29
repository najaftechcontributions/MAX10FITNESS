<?php
/**
 * Database Initialization Script
 * This script automatically creates the database and tables if they don't exist
 */

require_once __DIR__ . '/../config/env.php';

class DatabaseInitializer {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;

    private $isCli;

    public function __construct() {
        // Load database credentials from .env file
        $this->host = EnvLoader::get('DB_HOST', '127.0.0.1');
        $this->port = EnvLoader::get('DB_PORT', '3306');
        $this->db_name = EnvLoader::get('DB_NAME', 'max1on1fitness');
        $this->username = EnvLoader::get('DB_USER', 'root');
        $this->password = EnvLoader::get('DB_PASS', '');
        $this->isCli = php_sapi_name() === 'cli';
    }

    private function output($message) {
        if ($this->isCli) {
            echo $message . "\n";
        }
    }

    public function initialize() {
        try {
            // First, connect without specifying database to create it if needed
            $conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port,
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create database if not exists
            $conn->exec("CREATE DATABASE IF NOT EXISTS `{$this->db_name}`");
            $this->output("✓ Database '{$this->db_name}' created/verified");

            $conn->exec("USE `{$this->db_name}`");

            // Read and execute schema file
            $schemaFile = __DIR__ . '/schema.sql';
            if (file_exists($schemaFile)) {
                $sql = file_get_contents($schemaFile);

                // Remove comments
                $sql = preg_replace('/--.*$/m', '', $sql);
                $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

                // Split by semicolon and execute each statement
                $statements = array_filter(array_map('trim', explode(';', $sql)));

                foreach ($statements as $statement) {
                    if (!empty($statement)) {
                        try {
                            $conn->exec($statement);
                        } catch(PDOException $e) {
                            // Display error for debugging
                            $errorMsg = "Schema execution error: " . $e->getMessage();
                            error_log($errorMsg);
                            $this->output("✗ " . $errorMsg);
                            // Only continue if it's a "table already exists" error
                            if (strpos($e->getMessage(), '1050') === false) {
                                throw $e;
                            }
                        }
                    }
                }
                $this->output("✓ Database schema created/updated");

                // Verify tables were created
                $tables = ['users', 'pages_content', 'site_content'];
                foreach ($tables as $table) {
                    $stmt = $conn->query("SHOW TABLES LIKE '{$table}'");
                    if ($stmt->rowCount() > 0) {
                        $this->output("  ✓ Table '{$table}' verified");
                    } else {
                        throw new Exception("Table '{$table}' was not created");
                    }
                }
            } else {
                throw new Exception("Schema file not found: {$schemaFile}");
            }

            // Auto-seed dummy data
            $this->seedData($conn);

            return true;
        } catch(PDOException $e) {
            error_log("Database initialization error: " . $e->getMessage());
            $this->output("✗ Database initialization error: " . $e->getMessage());
            return false;
        }
    }

    private function seedData($conn) {
        try {
            require_once __DIR__ . '/seed.php';
            $seeder = new DatabaseSeeder($conn, $this->isCli);
            $seeder->seed();
        } catch(Exception $e) {
            error_log("Seeding error: " . $e->getMessage());
            $this->output("Note: Seeding completed with some warnings. Database is ready to use.");
        }
    }

    public function checkIfInitialized() {
        try {
            $conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if users table exists
            $stmt = $conn->query("SHOW TABLES LIKE 'users'");
            return $stmt->rowCount() > 0;
        } catch(PDOException $e) {
            return false;
        }
    }
}

// Run initialization if called directly from CLI
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['PHP_SELF'])) {
    echo "Initializing database...\n";
    $initializer = new DatabaseInitializer();

    if ($initializer->initialize()) {
        echo "✓ Database initialized successfully!\n";
    } else {
        echo "✗ Database initialization failed. Check error logs.\n";
        exit(1);
    }
}
?>
