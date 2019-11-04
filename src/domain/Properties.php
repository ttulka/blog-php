<?php
namespace blog;

use PDO;

class Properties {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function propertyValue($name) {
        $stmt = $this->pdo->prepare('SELECT value FROM Property WHERE name = :name');
        $stmt->bindValue('name', $name, PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['value'];
        }
        return null;
    }
}