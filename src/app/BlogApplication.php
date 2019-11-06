<?php
namespace blog;

require_once 'mvc/Dispatcher.php';

use mvc\Dispatcher;

class BlogApplication extends Dispatcher {

    private $postController;
    private $commentController;
    private $staticContentController;
    private $sitemapController;

    public function __construct(
            PostController $postController,
            CommentController $commentController,
            StaticContentController $staticContentController,
            SitemapController $sitemapController) {
        $this->postController = $postController;
        $this->commentController = $commentController;
        $this->staticContentController = $staticContentController;
        $this->sitemapController = $sitemapController;
    }

    public function dispatch($method, $path, $params) {
        $path = $this->parsePath($path);

        if (!empty($path) && !empty($path[0])) {
            if ($path[0] === 'sitemap') {
                $this->sitemapController->sitemap();

            } else if ($path[0] === 'privacypolicy') {
                $this->staticContentController->staticContent('privacypolicy');

            } else if ($path[0] === 'post' && !empty($path[2]) && $path[2] === 'comments') {
                if (!empty($path[3])) {
                    if ($method === 'GET') {
                        $this->commentController->answers($path[3], $params['page']);
                    } else if ($method === 'POST') {
                        $this->commentController->publishAnswer($path[1], $path[3], $_POST['body'], $_POST['author']);
                        http_response_code(201);
                    }
                } else {
                    if ($method === 'GET') {
                        $this->commentController->comments($path[1], $params['page']);
                    } else if ($method === 'POST') {
                        $this->commentController->publishComment($path[1], $_POST['body'], $_POST['author']);
                        http_response_code(201);
                    }
                }
            } else {
                $this->postController->postDetail($path[0]);
            }
        } else if ($method === 'GET') {
            $this->postController->posts($params);
        } else {
            http_response_code(400);
        }
    }
}