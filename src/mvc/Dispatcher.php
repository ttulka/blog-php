<?php
namespace mvc;

abstract class Dispatcher {

    abstract public function dispatch($method, $path, $params);

    protected final function parsePath($path) {
        $path = !empty($path) && $path[strlen($path) - 1] == '/' ? substr($path, 0, strlen($path) - 1) : $path;
        if (empty($path)) {
            return array();
        }
        $queryPos = strpos($path, '?');
        if ($queryPos !== FALSE) {
            $path = substr($path, 0, $queryPos);
        }
        return explode('/', $path[0] == '/' ? substr($path, 1) : $path);
    }
}