<?php
namespace blog;

use PDO;

class Sitemap {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function entries() {
        $stmt = $this->pdo->prepare("SELECT url, createdAt FROM Post 
										WHERE isDraft = 'false' 
										ORDER BY createdAt DESC, id DESC");
        $stmt->execute();
        $entries = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $entries[] = new SitemapData($row['url'], $row['createdAt']);
        }
        return $entries;
    }
}

class SitemapData {

    public $loc;
    public $lastmod;

    public function __construct($loc, $lastmod) {
        $this->loc = $loc;
        $this->lastmod = $lastmod;
    }
}