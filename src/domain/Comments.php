<?php
namespace blog;

use PDO;

class Comments {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function comments($postId, $page = 0, $limit = 10) {
        $q = 'SELECT id, createdAt, author, body
                FROM Comment
                WHERE parentId IS NULL AND postId = :postId
                ORDER BY createdAt DESC, id DESC
                LIMIT '. (($page + 0) * $limit) .','. $limit;
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue('postId', $postId + 0, PDO::PARAM_INT);
        $stmt->execute();
        $comments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $answersCount = $this->answersCount($row['id']);
            $answers = $answersCount > 0 ? $this->answers($row['id'], 0, $limit) : null;

            $comments[] = new CommentExtendedData($row['id'], $row['createdAt'], $row['author'], $row['body'],
                $answers, $limit < $answersCount ? 1 : null);
        }
        return $comments;
    }

    public function commentsCount($postId) {
        $q = 'SELECT COUNT(DISTINCT id) commentsCount
                FROM Comment
                WHERE parentId IS NULL AND postId = :postId';
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue('postId', $postId + 0, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['commentsCount'] + 0;
    }

    public function answers($commentId, $page = 0, $limit = 10) {
        $q = 'SELECT id, createdAt, author, body
                FROM Comment
                WHERE parentId = :commentId
                ORDER BY createdAt ASC, id ASC
                LIMIT '. (($page + 0) * $limit) .','. $limit;
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue('commentId', $commentId + 0, PDO::PARAM_INT);
        $stmt->execute();
        $answers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $answers[] = new CommentBaseData($row['id'], $row['createdAt'], $row['author'], $row['body']);
        }
        return $answers;
    }

    public function answersCount($commentId) {
        $q = 'SELECT COUNT(DISTINCT id) answersCount
                FROM Comment
                WHERE parentId = :commentId';
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue('commentId', $commentId + 0, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['answersCount'] + 0;
    }

    public function publish($postId, $commentId, $body, $author) {
        $q = "INSERT INTO Comment (id, createdAt, author, body, parentId, postId)
                VALUES (0, :createdAt, :author, :body, :commentId, :postId)";

        $stmt = $this->pdo->prepare($q);
        if ($postId > 0) {
            $stmt->bindValue('postId', $postId, PDO::PARAM_INT);
        } else {
            $stmt->bindValue('postId', null, PDO::PARAM_NULL);
        }
        if ($commentId > 0) {
            $stmt->bindValue('commentId', $commentId, PDO::PARAM_INT);
        } else {
            $stmt->bindValue('commentId', null, PDO::PARAM_NULL);
        }
        $createdAt = time();
        $stmt->bindValue('createdAt', $createdAt, PDO::PARAM_INT);
        $stmt->bindValue('author', $author, PDO::PARAM_STR);
        $stmt->bindValue('body', $body, PDO::PARAM_STR);
        $stmt->execute();

        $id = $this->pdo->lastInsertId();

        return new CommentBaseData($id, $createdAt, $author, $body);
    }
}

class CommentExtendedData {

    public $id;
    public $createdAt;
    public $author;
    public $body;

    public $answers;
    public $next;

    public function __construct($id, $createdAt, $author, $body, $answers, $next) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->body = $body;
        $this->answers = $answers;
        $this->next = $next;
    }
}

class CommentBaseData {

    public $id;
    public $createdAt;
    public $author;
    public $body;

    public function __construct($id, $createdAt, $author, $body) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->body = $body;
    }
}