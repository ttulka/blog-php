<?php
namespace mvc;

class ModelView {

    protected $name;
    protected $model;
    protected $type;

    public function __construct($name, $model, $type = 'html') {
        $this->name = $name;
        $this->model = $model;
        $this->type = $type;
    }

    public final function render() {
        switch ($this->type) {
            case 'xml':
                header('Content-type: text/xml; charset=UTF-8');
                header('Pragma: public');
                header('Cache-control: private');
                header('Expires: -1');
                break;
            case 'json':
                //header("Access-Control-Allow-Origin: " . ORIGIN_URL);
                header("Content-Type: application/json; charset=UTF-8");
                break;
            default:
                header("Content-Type: text/html; charset=UTF-8");
        }
        require_once "./layout/{$this->type}.php";
    }

    public final function content() {
        ob_start();

        require_once "./view/{$this->name}.php";

        $out = ob_get_contents();
        ob_end_clean();

        return $out;
    }

    public final function __get($key) {
        return isset($this->model[$key]) ? $this->model[$key] : "__{$key}__";
    }
}