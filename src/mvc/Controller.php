<?php
namespace mvc;

require_once __DIR__ . '/ModelView.php';

class Controller {

    protected $model = [];

    protected function view($name, $model, $type) {
        return new ModelView($name, $model, $type);
    }

    protected final function render($name, $type = 'html') {
        return $this->view($name, $this->model, $type)->render();
    }

    protected final function addModelAttribute($key, $value) {
        $this->model[$key] = $value;
    }

    protected final function responseHeaderNotFound() {
        http_response_code(404);
    }
}