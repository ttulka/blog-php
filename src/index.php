<?php
namespace blog;

require_once('./domain/Categories.php');
require_once('./domain/Properties.php');
require_once('./domain/Posts.php');
require_once('./domain/Sitemap.php');

require_once('./app/PostController.php');
require_once('./app/StaticContentController.php');
require_once('./app/SitemapController.php');

require_once('./app/BlogApplication.php');

use PDO, blog;

// Bootstrap the application

$pdo = new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8',
    getenv('DB_USER'), getenv('DB_PASS'));

$categories = new Categories($pdo);
$properties = new Properties($pdo);
$posts = new Posts($pdo);
$sitemap = new Sitemap($pdo);

$application = new BlogApplication(
    new PostController($posts, $categories, $properties),
    new StaticContentController($categories, $properties),
    new SitemapController($sitemap)
);

// Dispatch the request

$application->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_REQUEST);
