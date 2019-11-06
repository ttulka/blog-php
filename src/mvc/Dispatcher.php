<?php
namespace mvc;

abstract class Dispatcher {

    abstract protected function route();
//    {
//        return [
//            '/' => function() {
//                echo "INDEX";
//            },
//            'POST /abc'=> function() {
//                echo "POST ABC";
//            },
//            '/abc'=> function() {
//                echo "get ABC";
//            },
//            '/abc/{id}'=> function($params) {
//                echo "ABC id={$params['id']}";
//            },
//            'GET /abc/{id}/xyz'=> function($params) {
//                echo "GET ABC id={$params['id']} XYZ";
//            },
//            '/abc/{id1}/xyz/{id2}'=> function($params) {
//                echo "ABC id1={$params['id1']} XYZ id2={$params['id2']}";
//            }
//        ];
//    }

    public final function dispatch($method, $path, $params) {
        $escapedPath = "{$method} " . str_replace('/', ':', '/' . $this->purePath($path));

        foreach ($this->route() as $pattern => $handler) {
            $pathParams = [];
            $matches = [];
            if (preg_match_all('/{(\w+)}/', $pattern, $matches)) {
                $pathParams = $matches[1];
                $pattern = preg_replace('/{\w+}/', '([^:]+)', $pattern);
            }

            $escapedPattern = str_replace('/', ':', $pattern);

            if (!preg_match("/^[A-Z]+ .+$/i", $escapedPattern)) {
                $escapedPattern = "GET {$escapedPattern}";
            }

            $matches = [];
            if (preg_match("/^{$escapedPattern}$/i", $escapedPath, $matches)) {
                for ($i = 0; $i < sizeof($pathParams); $i++) {
                    $params[$pathParams[$i]] = $matches[$i + 1];
                }
                return $handler($params);
            }
        }
        http_response_code(400);
    }

    private final function purePath($path) {
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