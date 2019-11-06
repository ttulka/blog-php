<?php
namespace blog;

require_once 'mvc/Controller.php';
require_once 'mvc/ModelView.php';

use mvc\Controller;
use mvc\ModelView;

abstract class AbstractBlogLayoutController extends Controller {

    private $categories;
    private $properties;

    protected function __construct(Categories $categories, Properties $properties) {
        $this->categories = $categories;
        $this->properties = $properties;
    }

    protected function view($name, $model, $type) {
        return new BlogLayoutModelView($name, $model, $this->categories, $this->properties);
    }

    protected final function setPageTitle($title) {
        $this->addModelAttribute('PAGE_TITLE', $title);
    }

    protected final function setPageDescription($description) {
        $this->addModelAttribute('PAGE_DESCRIPTION', $description);
    }

    protected final function setPageAuthor($author) {
        $this->addModelAttribute('PAGE_AUTHOR', $author);
    }

    protected final function setActiveCaption($id) {
        $this->addModelAttribute('PAGE_ACTIVE_CAPTION', $id);
    }
}

class BlogLayoutModelView extends ModelView {

    private $categories;
    private $properties;

    public function __construct($name, $model, Categories $categories, Properties $properties) {
        parent::__construct($name, $model, 'html');
        $this->categories = $categories;
        $this->properties = $properties;
    }

    public final function blogCategories() {
        return $this->categories->listAll();
    }

    public final function pageTitle() {
        return isset($this->model['PAGE_TITLE']) ? $this->model['PAGE_TITLE']
            : $this->properties->propertyValue('blogTitle');
    }

    public final function pageDescription() {
        return isset($this->model['PAGE_DESCRIPTION']) ? $this->model['PAGE_DESCRIPTION']
            : $this->properties->propertyValue('blogDescription');
    }

    public final function pageAuthor() {
        return isset($this->model['PAGE_AUTHOR']) ? $this->model['PAGE_AUTHOR']
            : $this->properties->propertyValue('blogAuthor');
    }

    public final function isActiveCaption($id = null) {
        $activeCaption = isset($this->model['PAGE_ACTIVE_CAPTION']) ? $this->model['PAGE_ACTIVE_CAPTION'] : null;
        return $activeCaption == $id;
    }
}