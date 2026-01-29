<?php
class SiteContent {
    private $conn;
    private $table_name = "site_content";

    public $id;
    public $content_key;
    public $content_value;
    public $page_name;
    public $section_name;
    public $content_type;
    public $description;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all content
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY page_name ASC, section_name ASC, content_key ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get content by page
    public function getByPage($page_name) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE page_name = :page_name ORDER BY section_name ASC, content_key ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":page_name", $page_name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get content by key
    public function getByKey($content_key) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE content_key = :content_key LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":content_key", $content_key);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->content_key = $row['content_key'];
            $this->content_value = $row['content_value'];
            $this->page_name = $row['page_name'];
            $this->section_name = $row['section_name'];
            $this->content_type = $row['content_type'];
            $this->description = $row['description'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }

        return false;
    }

    // Get content by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->content_key = $row['content_key'];
            $this->content_value = $row['content_value'];
            $this->page_name = $row['page_name'];
            $this->section_name = $row['section_name'];
            $this->content_type = $row['content_type'];
            $this->description = $row['description'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }

        return false;
    }

    // Update content
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET content_value = :content_value, 
                      description = :description
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->content_value = htmlspecialchars($this->content_value);
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Bind values
        $stmt->bindParam(":content_value", $this->content_value);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Get content value by key (helper function for views)
    public static function getValue($db, $content_key, $default = '') {
        $query = "SELECT content_value FROM site_content WHERE content_key = :content_key LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":content_key", $content_key);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return htmlspecialchars_decode($row['content_value']);
        }

        return $default;
    }

    // Get all pages
    public function getPages() {
        $query = "SELECT DISTINCT page_name FROM " . $this->table_name . " ORDER BY page_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Search content
    public function search($search_term) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE content_key LIKE :search 
                     OR content_value LIKE :search 
                     OR description LIKE :search 
                     OR page_name LIKE :search 
                     OR section_name LIKE :search
                  ORDER BY page_name ASC, section_name ASC";
        
        $stmt = $this->conn->prepare($query);
        $search_param = "%{$search_term}%";
        $stmt->bindParam(":search", $search_param);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
