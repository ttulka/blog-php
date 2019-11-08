<?php
namespace mvc;

class Dispatcher {

    private $router;

    public function __construct($routing) {
        $this->router = new Router($routing);
    }

    public final function dispatch() {
        $this->router->route(
            $_SERVER['REQUEST_METHOD'],
            $this->pathFromUri($_SERVER['REQUEST_URI']),
            $_REQUEST);
    }

    private final function pathFromUri($path) {
        $path = !empty($path) && $path[strlen($path) - 1] == '/' ? substr($path, 0, strlen($path) - 1) : $path;
        if (empty($path)) {
            return '';
        }
        $queryPos = strpos($path, '?');
        if ($queryPos !== FALSE) {
            $path = substr($path, 0, $queryPos);
        }
        return $path[0] === '/' ? substr($path, 1) : $path;
    }
}

class Router {

    private $routing;
//    [
//        '/' => function() {
//            echo "INDEX";
//        },
//        'POST /abc'=> function() {
//            echo "POST ABC";
//        },
//        '/abc'=> function() {
//            echo "get ABC";
//        },
//        '/abc/{id}'=> function($params) {
//            echo "ABC id={$params['id']}";
//        },
//        'GET /abc/{id}/xyz'=> function($params) {
//            echo "GET ABC id={$params['id']} XYZ";
//        },
//        '/abc/{id1}/xyz/{id2}'=> function($params) {
//            echo "ABC id1={$params['id1']} XYZ id2={$params['id2']}";
//        }
//    ]
    function __construct($routing) {
        $this->routing = $routing;
    }

    public final function route($method, $path, $params) {
        $path = "{$method} " . $this->withEscapedSlashes("/{$path}");

        foreach ($this->routing as $pattern => $handler) {
            $patternParams = $this->patternParams($pattern);
            if (!empty($patternParams)) {
                $pattern = $this->withGreedyPatternParams($pattern);
            }

            $pattern = $this->withEscapedSlashes($pattern);
            $pattern = $this->withMethod($pattern);

            if ($this->patternMatchesWithParamsEnhancement($pattern, $path, $patternParams, $params)) {
                $handler($params);
                return;
            }
        }

        http_response_code(404);
        if (array_key_exists('/', $this->route)) {
            $this->route['/']([]);
        }
    }

    private function patternMatchesWithParamsEnhancement($pattern, $path, $patternParams, &$params) {
        if (preg_match("/^{$pattern}$/i", $path, $matches)) {
            for ($i = 0; $i < sizeof($patternParams); $i++) {
                $params[$patternParams[$i]] = $matches[$i + 1];
            }
            return true;
        }
        return false;
    }

    private function patternParams($pattern) {
        $matches = [];
        if (preg_match_all('/{(\w+)}/', $pattern, $matches)) {
            return $matches[1];
        }
    }

    private function withEscapedSlashes($pattern) {
        return str_replace('/', ':', $pattern);
    }

    private function withMethod($pattern) {
        return !preg_match("/^[A-Z]+ .+$/i", $pattern) ? "GET {$pattern}" : $pattern;
    }

    private function withGreedyPatternParams($pattern) {
        return preg_replace('/{\w+}/', '([^:]+)', $pattern);
    }
}