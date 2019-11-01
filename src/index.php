<html>
<body>
<h1>INDEX</h1>

<?php
$host = 'db';
$db = 'blog';
$username = 'blog';
$password = 'secret';
$db = new PDO("mysql:host=" . $host . ";dbname=" . $db, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("set names utf8");

$stmt = $db->prepare('SELECT title FROM Post');        
$stmt->bindValue('id', (int)$articleId, PDO::PARAM_INT);        
$stmt->execute();
        
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo $row['title'] . '<br>';
}
?>

</body>
</html>