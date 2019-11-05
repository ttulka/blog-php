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
        $view = null;

        if (!empty($path) && !empty($path[0])) {
            if ($path[0] === 'sitemap') {
                $view = $this->sitemapController->sitemap();

            } else if ($path[0] === 'privacypolicy') {
                $view = $this->staticContentController->staticContent('privacypolicy');

            } else if ($path[0] === 'post' && !empty($path[2]) && $path[2] === 'comments') {
                if (!empty($path[3])) {
                    if ($method === 'GET') {
                        $view = $this->commentController->answers($path[3], $params['page']);
                    } else if ($method === 'POST') {
                        $view = $this->commentController->publishAnswer($path[1], $path[3], $_POST['body'], $_POST['author']);
                        http_response_code(201);
                    }
                } else {
                    if ($method === 'GET') {
                        $view = $this->commentController->comments($path[1], $params['page']);
                    } else if ($method === 'POST') {
                        $view = $this->commentController->publishComment($path[1], $_POST['body'], $_POST['author']);
                        http_response_code(201);
                    }
                }
            } else {
                $view = $this->postController->postDetail($path[0]);
            }
        } else if ($method === 'GET') {
            $view = $this->postController->posts($params);
        }

        if ($view === null) {
            http_response_code(400);
            return;
        }
        $view->render();
    }
}