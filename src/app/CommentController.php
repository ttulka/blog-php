<?php
namespace blog;

require_once 'mvc/Controller.php';

use mvc\Controller;

class CommentController extends Controller {

    private $commentsOnPage = 10;
    private $emailAdmin;
    private $comments;

    public function __construct(Comments $comments, $emailAdmin) {
        $this->comments = $comments;
        $this->emailAdmin = $emailAdmin;
    }

    public function comments($postId, $page) {
        $count = $this->comments->commentsCount($postId);
        if ($count > 0) {
            $serverUrl = $this->serverUrl();
            $comments = $this->comments->comments($postId, $page, $this->commentsOnPage);
            $nextPage = (($page + 1) * $this->commentsOnPage) < $count ? $page + 1 : null;

            $result = [];
            $result['comments'] = $comments;
            if ($nextPage > 0) {
                $result['next'] = $serverUrl . '?page=' . $nextPage;
            }
            foreach ($result['comments'] as $c) {
                if ($c->next > 0) {
                    $c->next = $serverUrl . '/' . $c->id . '?page=' . $c->next;
                }
            }

            $this->addModelAttribute('result', $result);

        } else {
            $this->addModelAttribute('result', array('comments' => []));
        }

        $this->render('comments', 'json');
    }

    public function answers($commentId, $page) {
        $count = $this->comments->answersCount($commentId);
        if ($count > 0) {
            $serverUrl = $this->serverUrl();
            $answers = $this->comments->answers($commentId, $page, $this->commentsOnPage);
            $nextPage = (($page + 1) * $this->commentsOnPage) < $count ? $page + 1 : null;

            $result = [];
            $result['answers'] = $answers;
            if ($nextPage > 0) {
                $result['next'] = $serverUrl . '?page=' . $nextPage;
            }

            $this->addModelAttribute('result', $result);

        } else {
            $this->addModelAttribute('result', array('answers' => []));
        }

        $this->render('comments', 'json');
    }

    public function publishComment($postId, $body, $author) {
        if (empty($postId) || empty($body) || empty($author)) {
            throw new \InvalidArgumentException("All parameters must be set!");
        }
        $published = $this->comments->publish($postId, null, $body, $author);
        $this->notifyCommentPublished($published);
        $this->setResponseCode(self::CREATED);

        $this->addModelAttribute('result', $published);
        $this->render('comments', 'json');
    }

    public function publishAnswer($postId, $commentId, $body, $author) {
        if (empty($postId) || empty($commentId) || empty($body) || empty($author)) {
            throw new \InvalidArgumentException("All parameters must be set!");
        }
        $published = $this->comments->publish($postId, $commentId, $body, $author);
        $this->notifyCommentPublished($published);
        $this->setResponseCode(self::CREATED);

        $this->addModelAttribute('result', $published);
        $this->render('comments', 'json');
    }

    private function notifyCommentPublished($comment) {
        mail($this->emailAdmin, 'new comment added', json_encode($comment));
    }

    private function serverUrl() {
        return str_replace(!empty($_SERVER['QUERY_STRING']) ? "?{$_SERVER['QUERY_STRING']}" : '', '', $_SERVER['REQUEST_URI']);
    }
}