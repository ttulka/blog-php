<?php
namespace blog;

require_once 'mvc/Dispatcher.php';

use mvc\Dispatcher;

class BlogApplication extends Dispatcher {

    private $postController;
    private $staticContentController;
    private $sitemapController;

    public function __construct(PostController $postController, StaticContentController $staticContentController, SitemapController $sitemapController) {
        $this->postController = $postController;
        $this->staticContentController = $staticContentController;
        $this->sitemapController = $sitemapController;
    }

    public function dispatch($method, $path, $params) {
        if ($method !== 'GET') {
            http_response_code(405);
            header('Allow: GET');
            return;
        }
        $view = $this->view($this->parsePath($path), $params);
        $view->render();
    }

    private function view($path, $params) {
        if (!empty($path) && !empty($path[0])) {

            if ($path[0] === 'sitemap') {
                return $this->sitemapController->sitemap();
            }
            if ($path[0] === 'privacypolicy') {
                return $this->staticContentController->staticContent('privacypolicy');
            }
            return $this->postController->postDetail($path[0]);
        }
        return $this->postController->posts($params);
    }
}