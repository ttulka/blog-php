<?php
namespace blog;

require_once __DIR__ . '/BlogLayoutController.php';
require_once __DIR__ . '/Pagination.php';

class PostController extends AbstractBlogLayoutController {

    private $postsOnPage = 10;
    private $posts;

    public function __construct(Posts $posts, Categories $categories, Properties $properties) {
        parent::__construct($categories, $properties);
        $this->posts = $posts;
    }

    public function postDetail($url) {
        $post = $this->posts->byUrl($url);
        if ($post !== null) {
            $this->addModelAttribute('post', $post);
            $this->setPageTitle($post->title . ' by ' . $post->authorName);
            $this->setPageAuthor($post->authorName);
            $this->setActiveCaption($post->caption);

            $this->render('post');

        } else {
            $this->setResponseCode(self::NOT_FOUND);
            $this->posts();
        }
    }

    public function posts($params = []) {
        $categoryId = isset($params['category']) ? (int)$params['category'] : null;
        $authorId = isset($params['author']) ? (int)$params['author'] : null;
        $page = isset($params['page']) ? (int)$params['page'] : 0;

        $this->addModelAttribute('posts', $this->posts->listBy($categoryId, $authorId, $page, $this->postsOnPage));
        $this->addModelAttribute('pagination', new Pagination(
            $page, $this->posts->countBy($categoryId, $authorId), $this->postsOnPage, $params));
        $this->setActiveCaption($categoryId);

        $this->render('posts');
    }
}