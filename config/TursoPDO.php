<?php
/**
 * TursoPDO - PDO-compatible wrapper for Turso Database
 * Provides a PDO-like interface for Turso's HTTP API
 */
class TursoPDO {
    private $url;
    private $token;
    private $errorMode = PDO::ERRMODE_EXCEPTION;
    private $fetchMode = PDO::FETCH_ASSOC;

    public function __construct($url, $token) {
        $this->url = rtrim($url, '/');
        $this->token = $token;
        
        // Test connection
        $this->testConnection();
    }

    private function testConnection() {
        try {
            $this->execute("SELECT 1");
        } catch (Exception $e) {
            throw new PDOException("Failed to connect to Turso: " . $e->getMessage());
        }
    }

    public function setAttribute($attribute, $value) {
        if ($attribute === PDO::ATTR_ERRMODE) {
            $this->errorMode = $value;
        } elseif ($attribute === PDO::ATTR_DEFAULT_FETCH_MODE) {
            $this->fetchMode = $value;
        }
        return true;
    }

    public function prepare($statement) {
        return new TursoPDOStatement($this, $statement);
    }

    public function query($statement) {
        $stmt = $this->prepare($statement);
        $stmt->execute();
        return $stmt;
    }

    public function exec($statement) {
        $result = $this->execute($statement);
        return $result['rows_affected'] ?? 0;
    }

    public function lastInsertId() {
        $result = $this->execute("SELECT last_insert_rowid() as id");
        return $result['results'][0]['id'] ?? 0;
    }

    public function execute($sql, $params = []) {
        // Convert libsql:// to https://
        $httpUrl = str_replace('libsql://', 'https://', $this->url);
        
        $data = [
            'statements' => [
                [
                    'q' => $sql,
                    'params' => $this->formatParams($params)
                ]
            ]
        ];

        $ch = curl_init($httpUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            $error = json_decode($response, true);
            $message = $error['error'] ?? 'Unknown error';
            throw new PDOException("Turso query failed: " . $message);
        }

        $result = json_decode($response, true);
        
        if (isset($result['error'])) {
            throw new PDOException("Turso query error: " . $result['error']);
        }

        return $result['results'][0] ?? [];
    }

    private function formatParams($params) {
        $formatted = [];
        foreach ($params as $key => $value) {
            if (is_int($key)) {
                // Positional parameter
                $formatted[] = ['type' => $this->getType($value), 'value' => $value];
            } else {
                // Named parameter
                $formatted[$key] = ['type' => $this->getType($value), 'value' => $value];
            }
        }
        return $formatted;
    }

    private function getType($value) {
        if (is_null($value)) return 'null';
        if (is_int($value)) return 'integer';
        if (is_float($value)) return 'float';
        if (is_bool($value)) return 'integer';
        return 'text';
    }

    public function getFetchMode() {
        return $this->fetchMode;
    }
}

/**
 * TursoPDOStatement - PDO Statement wrapper for Turso
 */
class TursoPDOStatement {
    private $pdo;
    private $statement;
    private $params = [];
    private $result = null;
    private $position = 0;

    public function __construct($pdo, $statement) {
        $this->pdo = $pdo;
        $this->statement = $statement;
    }

    public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR) {
        $this->params[$parameter] = &$variable;
        return true;
    }

    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR) {
        $this->params[$parameter] = $value;
        return true;
    }

    public function execute($params = null) {
        if ($params !== null) {
            $this->params = $params;
        }

        try {
            $this->result = $this->pdo->execute($this->statement, $this->params);
            $this->position = 0;
            return true;
        } catch (Exception $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function fetch($fetch_style = null) {
        if ($this->result === null || !isset($this->result['rows'])) {
            return false;
        }

        if ($this->position >= count($this->result['rows'])) {
            return false;
        }

        $row = $this->result['rows'][$this->position];
        $this->position++;

        $fetchMode = $fetch_style ?? $this->pdo->getFetchMode();
        
        if ($fetchMode === PDO::FETCH_ASSOC) {
            return $this->convertRowToAssoc($row);
        }
        
        return $this->convertRowToAssoc($row);
    }

    public function fetchAll($fetch_style = null) {
        if ($this->result === null || !isset($this->result['rows'])) {
            return [];
        }

        $rows = [];
        foreach ($this->result['rows'] as $row) {
            $rows[] = $this->convertRowToAssoc($row);
        }

        return $rows;
    }

    public function fetchColumn($column_number = 0) {
        $row = $this->fetch();
        if ($row === false) {
            return false;
        }
        
        $values = array_values($row);
        return $values[$column_number] ?? false;
    }

    public function rowCount() {
        if ($this->result === null) {
            return 0;
        }
        
        return $this->result['rows_affected'] ?? count($this->result['rows'] ?? []);
    }

    private function convertRowToAssoc($row) {
        if (!isset($this->result['columns'])) {
            return $row;
        }

        $assoc = [];
        $columns = $this->result['columns'];
        
        foreach ($row as $index => $value) {
            $columnName = $columns[$index] ?? $index;
            $assoc[$columnName] = $value;
        }

        return $assoc;
    }
}
?>
