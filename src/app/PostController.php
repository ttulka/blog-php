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
        $tag = isset($params['tag']) ? $params['tag'] : null;
        $page = isset($params['page']) ? (int)$params['page'] : 0;

        $posts = $this->posts->listBy($categoryId, $authorId, $tag, $page, $this->postsOnPage);

        if (empty($posts)) {
            $this->setResponseCode(self::NOT_FOUND);
            
        } else {
            $this->addModelAttribute('posts', $posts);
            $this->addModelAttribute('pagination', new Pagination(
                $page, $this->posts->countBy($categoryId, $authorId, $tag), $this->postsOnPage, $params));
            
            $this->setActiveCaption($categoryId);
        }

        $this->addModelAttribute('tag', $tag === null ? '' : $tag);

        $this->render('posts');
    }
}