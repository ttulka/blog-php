<?php
namespace blog;

use PDO;

class Sitemap {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function entries() {
        $stmt = $this->pdo->prepare('SELECT url, createdAt FROM Post ORDER BY createdAt DESC, id DESC');
        $stmt->execute();
        $entries = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $entries[] = new SitemapEntry($row['url'], $row['createdAt']);
        }
        return $entries;
    }
}

class SitemapEntry {

    public $loc;
    public $lastmod;

    public function __construct($loc, $lastmod) {
        $this->loc = $loc;
        $this->lastmod = $lastmod;
    }
}