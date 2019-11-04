<?php
namespace mvc;

require_once __DIR__ . '/ModelView.php';

class Controller {

    protected $model = [];

    protected function view($name, $type = 'html') {
        return new ModelView($name, $this->model, $type);
    }

    protected final function addModelAttribute($key, $value) {
        $this->model[$key] = $value;
    }

    protected final function responseHeaderNotFound() {
        http_response_code(404);
    }
}