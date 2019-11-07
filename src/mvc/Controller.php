<?php
namespace mvc;

require_once __DIR__ . '/ModelView.php';

class Controller {

    const OK = 200;
    const CREATED = 201;
    const MOVED = 301;
    const NOT_FOUND = 404;
    const CLIENT_ERROR = 400;
    const SERVER_ERROR = 500;

    protected $model = [];

    private $responseCode = self::OK;

    protected function view($name, $model, $type) {
        return new ModelView($name, $model, $type);
    }

    protected final function render($name, $type = 'html') {
        http_response_code($this->responseCode);
        $this->view($name, $this->model, $type)->render();
    }

    protected final function addModelAttribute($key, $value) {
        $this->model[$key] = $value;
    }

    protected final function setResponseCode($code) {
        $this->responseCode = (int)$code;
    }
}