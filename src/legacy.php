<?php
/**
 * A workaround to handle legacy link '/xxx-123'.
 * Remove after a while together with the record in .htaccess
 */
$id = $_REQUEST['id'];

$pdo = new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8',
    getenv('DB_USER'), getenv('DB_PASS'));

$stmt = $pdo->prepare("SELECT url FROM Post WHERE id = :id AND isDraft = 'false'");
$stmt->bindValue('id', $id, PDO::PARAM_INT);
$stmt->execute();
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    http_response_code(301);
    header("Location:{$row['url']}");
} else {
    http_response_code(404);
    header("Location:/");
}
