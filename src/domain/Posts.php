<?php
namespace blog;

use PDO;

class Posts {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function byUrl($url) {
        $stmt = $this->pdo->prepare("SELECT p.id, p.title, p.summary, p.body, p.createdAt, p.categoryId,
                                            p.isMenu, a.id authorId, a.name authorName, p.tags
                                        FROM Post p
                                        JOIN Author a ON p.authorId = a.id
                                        WHERE p.url = :url AND isDraft = 'false'");
        $stmt->bindValue('url', $url, PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new PostDetailData($row['id'], $row['title'], $row['summary'], $row['body'],
                $row['createdAt'], $row['isMenu'] === 'true' ? $url : $row['categoryId'],
                $row['authorId'], $row['authorName'], 
                preg_split('/,[\s]*/', $row['tags'], -1, PREG_SPLIT_NO_EMPTY));
        }
        return null;
    }

    public function listBy($categoryId = null, $authorId = null, $tag = null, $page = 0, $limit = 10) {
        $q = "SELECT p.id, p.url, p.title, p.summary, p.createdAt, a.id authorId, a.name authorName
                FROM Post p
                JOIN Author a ON p.authorId = a.id
                WHERE isDraft = 'false' AND isMenu = 'false'";
        if ($categoryId !== null) {
            $q .= 'AND p.categoryId = :categoryId ';
        }
        if ($authorId !== null) {
            $q .= 'AND p.authorId = :authorId ';
        }
        if ($tag !== null) {
            $q .= "AND CONCAT(',', p.tags, ',') LIKE :tag ";
        }
        $q .= 'ORDER BY p.createdAt DESC, p.id DESC ';
        $q .= 'LIMIT '. ($page * $limit) .','. ($limit+0);
        $stmt = $this->pdo->prepare($q);
        if ($categoryId !== null) {
            $stmt->bindValue('categoryId', $categoryId, PDO::PARAM_INT);
        }
        if ($authorId !== null) {
            $stmt->bindValue('authorId', $authorId, PDO::PARAM_INT);
        }
        if ($tag !== null) {
            $stmt->bindValue('tag', "%,{$tag},%");
        }
        $stmt->execute();
        $posts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new PostListData($row['id'], $row['url'], $row['title'], $row['summary'],
                $row['createdAt'], $row['authorId'], $row['authorName']);
        }
        return $posts;
    }

    public function countBy($categoryId = null, $authorId = null, $tag = null) {
        $q = "SELECT COUNT(DISTINCT p.id) postsCount
                FROM Post p
                JOIN Author a ON p.authorId = a.id
                WHERE isDraft = 'false' AND isMenu = 'false' ";
        if ($categoryId !== null) {
            $q .= 'AND p.categoryId = :categoryId ';
        }
        if ($authorId !== null) {
            $q .= 'AND p.authorId = :authorId ';
        }
        if ($tag !== null) {
            $q .= "AND CONCAT(',', p.tags, ',') LIKE :tag ";
        }
        $stmt = $this->pdo->prepare($q);
        if ($categoryId !== null) {
            $stmt->bindValue('categoryId', $categoryId, PDO::PARAM_INT);
        }
        if ($authorId !== null) {
            $stmt->bindValue('authorId', $authorId, PDO::PARAM_INT);
        }
        if ($tag !== null) {
            $stmt->bindValue('tag', "%,{$tag},%");
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['postsCount'] + 0;
    }
}

class PostDetailData {

    public $id;
    public $title;
    public $summary;
    public $body;
    public $createdAt;
    public $caption;
    public $authorId;
    public $authorName;
    public $tags;

    public function __construct($id, $title, $summary, $body, $createdAt, $caption, $authorId, $authorName, $tags) {
        $this->id = $id;
        $this->title = $title;
        $this->summary = $summary;
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->caption = $caption;
        $this->authorId = $authorId;
        $this->authorName = $authorName;
        $this->tags = $tags;
    }
}

class PostListData {

    public $id;
    public $url;
    public $title;
    public $summary;
    public $createdAt;
    public $authorId;
    public $authorName;

    public function __construct($id, $url, $title, $summary, $createdAt, $authorId, $authorName) {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->summary = $summary;
        $this->createdAt = $createdAt;
        $this->authorId = $authorId;
        $this->authorName = $authorName;
    }
}