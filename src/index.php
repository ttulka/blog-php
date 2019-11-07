<?php
namespace blog;

require_once('./domain/Categories.php');
require_once('./domain/Properties.php');
require_once('./domain/Posts.php');
require_once('./domain/Comments.php');
require_once('./domain/Sitemap.php');

require_once('./app/PostController.php');
require_once('./app/CommentController.php');
require_once('./app/StaticContentController.php');
require_once('./app/SitemapController.php');

require_once('./mvc/Dispatcher.php');

use mvc\Dispatcher;
use PDO;

// Bootstrap the application

$pdo = new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8',
    getenv('DB_USER'), getenv('DB_PASS'));

$categories = new Categories($pdo);
$properties = new Properties($pdo);
$posts = new Posts($pdo);
$comments = new Comments($pdo);
$sitemap = new Sitemap($pdo);

$postController = new PostController($posts, $categories, $properties);
$commentController = new CommentController($comments, getenv('EMAIL_ADMIN'));
$staticContentController = new StaticContentController($categories, $properties);
$sitemapController = new SitemapController($sitemap);

// Define routing and dispatch

(new Dispatcher([
    '/' => function($params) use($postController) {
        $postController->posts($params);
    },
    '/sitemap' => function() use($sitemapController) {
        $sitemapController->sitemap();
    },
    '/privacypolicy' => function() use($staticContentController) {
        $staticContentController->staticContent('privacypolicy');
    },
    '/{url}' => function($params) use($postController) {
        $postController->postDetail($params['url']);
    },
    '/post/{postId}/comments' => function($params) use($commentController) {
        $commentController->comments($params['postId'], $params['page']);
    },
    'POST /post/{postId}/comments' => function($params) use($commentController) {
        $commentController->publishComment($params['postId'], $params['body'], $params['author']);
    },
    '/post/{postId}/comments/{commentId}' => function($params) use($commentController) {
        $commentController->answers($params['commentId'], $params['page']);
    },
    'POST /post/{postId}/comments/{commentId}' => function($params) use($commentController) {
        $commentController->publishAnswer($params['postId'], $params['commentId'], $params['body'], $params['author']);
    }
]))->dispatch();
