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

    public function route() {
        return [
            '/' => function($params) {
                $this->postController->posts($params);
            },
            '/sitemap' => function() {
                $this->sitemapController->sitemap();
            },
            '/privacypolicy' => function() {
                $this->staticContentController->staticContent('privacypolicy');
            },
            '/{url}' => function($params) {
                $this->postController->postDetail($params['url']);
            },
            '/post/{postId}/comments' => function($params) {
                $this->commentController->comments($params['postId'], $params['page']);
            },
            'POST /post/{postId}/comments' => function($params) {
                $this->commentController->publishComment($params['postId'], $params['body'], $params['author']);
            },
            '/post/{postId}/comments/{commentId}' => function($params) {
                $this->commentController->answers($params['commentId'], $params['page']);
            },
            'POST /post/{postId}/comments/{commentId}' => function($params) {
                $this->commentController->publishAnswer($params['postId'], $params['commentId'], $params['body'], $params['author']);
            }
        ];
    }
}