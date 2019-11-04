<?php
namespace blog;

require_once __DIR__ . '/BlogLayoutController.php';

class StaticContentController extends AbstractBlogLayoutController {

    public function __construct(Categories $categories, Properties $properties) {
        parent::__construct($categories, $properties);
    }

    public function staticContent($name) {
        return $this->view($name);
    }
}