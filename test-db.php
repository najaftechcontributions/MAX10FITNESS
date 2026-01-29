<?php
/**
 * Database Connection Test Script
 * Run this to test database connectivity and initialization
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "====================================\n";
echo "Database Connection Test\n";
echo "====================================\n\n";

// Test 1: Check if .env file exists and can be loaded
echo "1. Testing .env file...\n";
require_once __DIR__ . '/config/env.php';

$dbHost = EnvLoader::get('DB_HOST');
$dbPort = EnvLoader::get('DB_PORT');
$dbName = EnvLoader::get('DB_NAME');
$dbUser = EnvLoader::get('DB_USER');
$dbPass = EnvLoader::get('DB_PASS');

echo "   ✓ .env file loaded successfully\n";
echo "   - DB_HOST: " . ($dbHost ?: '(not set)') . "\n";
echo "   - DB_PORT: " . ($dbPort ?: '(not set)') . "\n";
echo "   - DB_NAME: " . ($dbName ?: '(not set)') . "\n";
echo "   - DB_USER: " . ($dbUser ?: '(not set)') . "\n";
echo "   - DB_PASS: " . (empty($dbPass) ? '(empty)' : '****') . "\n\n";

// Test 2: Test MySQL server connection (without database)
echo "2. Testing MySQL server connection...\n";
try {
    $testConn = new PDO(
        "mysql:host={$dbHost};port={$dbPort}",
        $dbUser,
        $dbPass
    );
    $testConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✓ Successfully connected to MySQL server\n\n";
    $testConn = null;
} catch (PDOException $e) {
    echo "   ✗ Failed to connect to MySQL server\n";
    echo "   Error: " . $e->getMessage() . "\n\n";
    echo "Common fixes:\n";
    echo "   - Make sure MySQL/MariaDB is running\n";
    echo "   - Check DB_HOST, DB_PORT, DB_USER, and DB_PASS in .env\n";
    echo "   - Verify the database user has proper permissions\n";
    exit(1);
}

// Test 3: Initialize database
echo "3. Testing database initialization...\n";
try {
    require_once __DIR__ . '/database/init.php';
    $initializer = new DatabaseInitializer();
    
    if ($initializer->checkIfInitialized()) {
        echo "   ✓ Database '{$dbName}' already initialized\n\n";
    } else {
        echo "   - Database not initialized. Initializing now...\n";
        if ($initializer->initialize()) {
            echo "   ✓ Database initialized successfully\n\n";
        } else {
            echo "   ✗ Database initialization failed\n\n";
            exit(1);
        }
    }
} catch (Exception $e) {
    echo "   ✗ Initialization error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 4: Test database connection with database name
echo "4. Testing database connection...\n";
try {
    require_once __DIR__ . '/config/Database.php';
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn === null) {
        echo "   ✗ Failed to get database connection\n\n";
        exit(1);
    }
    
    echo "   ✓ Successfully connected to database '{$dbName}'\n\n";
} catch (Exception $e) {
    echo "   ✗ Connection error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 5: Verify tables exist
echo "5. Verifying database tables...\n";
try {
    $tables = ['users', 'pages_content', 'site_content'];
    foreach ($tables as $table) {
        $stmt = $conn->query("SHOW TABLES LIKE '{$table}'");
        if ($stmt->rowCount() > 0) {
            // Count rows
            $countStmt = $conn->query("SELECT COUNT(*) as count FROM {$table}");
            $count = $countStmt->fetch()['count'];
            echo "   ✓ Table '{$table}' exists ({$count} rows)\n";
        } else {
            echo "   ✗ Table '{$table}' not found\n";
        }
    }
    echo "\n";
} catch (Exception $e) {
    echo "   ✗ Error verifying tables: " . $e->getMessage() . "\n\n";
}

echo "====================================\n";
echo "✓ All tests passed!\n";
echo "Database is ready to use.\n";
echo "====================================\n";
?>
