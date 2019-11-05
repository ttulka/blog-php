<?php
namespace blog;

use PDO;

class Categories {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listAll() {
        $stmt = $this->pdo->prepare('SELECT id, name FROM Category ORDER BY id ASC');
        $stmt->execute();
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new CategoryData($row['id'], $row['name']);
        }
        return $categories;
    }
}

class CategoryData {

    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
}