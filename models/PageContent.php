<?php
class PageContent {
    private $conn;
    private $table_name = "pages_content";

    public $id;
    public $page_name;
    public $title;
    public $content;
    public $meta_description;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all pages
    public function getAllPages() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY page_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get page by name
    public function getByName($page_name) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE page_name = :page_name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":page_name", $page_name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->page_name = $row['page_name'];
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->meta_description = $row['meta_description'];
            $this->is_active = $row['is_active'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }

        return false;
    }

    // Get page by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->page_name = $row['page_name'];
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->meta_description = $row['meta_description'];
            $this->is_active = $row['is_active'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }

        return false;
    }

    // Create new page
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET page_name=:page_name, title=:title, content=:content, 
                      meta_description=:meta_description, is_active=:is_active";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->page_name = htmlspecialchars(strip_tags($this->page_name));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars($this->content);
        $this->meta_description = htmlspecialchars(strip_tags($this->meta_description));
        $this->is_active = isset($this->is_active) ? $this->is_active : 1;

        // Bind values
        $stmt->bindParam(":page_name", $this->page_name);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":meta_description", $this->meta_description);
        $stmt->bindParam(":is_active", $this->is_active);

        return $stmt->execute();
    }

    // Update page
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET title=:title, content=:content, 
                      meta_description=:meta_description, is_active=:is_active 
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars($this->content);
        $this->meta_description = htmlspecialchars(strip_tags($this->meta_description));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":meta_description", $this->meta_description);
        $stmt->bindParam(":is_active", $this->is_active);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Delete page
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    // Toggle active status
    public function toggleActive() {
        $query = "UPDATE " . $this->table_name . " 
                  SET is_active = NOT is_active 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>
