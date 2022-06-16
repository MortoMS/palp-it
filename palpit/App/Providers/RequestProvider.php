<?php

namespace App\Providers;

class RequestProvider
{
    private $json = null;

    private static $method;
    private static $url;
    private static $prefix = '';

    private static $request = [
        'SCHEME'  => null,
        'HOST'    => null,
        'PORT'    => null,
        'REQUEST' => null
    ];

    private static $middlewares = [];

    public static function setMiddleware($args, callable $middleware = null)
    {
        if (is_array($args) and count($args) > 0) {
            foreach ($args as $index => $middleware) {
                self::$middlewares[$index] = $middleware;
            }
        } elseif (is_string($args) and !is_null($middleware)) { 
            self::$middlewares[$args] = $middleware;
        }
    }

    public static function removeMiddleware($args)
    {
        if (is_string($args) and array_key_exists($args, self::$middlewares)) {
            unset(self::$middlewares[$args]);
        } elseif (is_array($args) and count($args) > 0) {
            foreach ($args as $index) {
                if (array_key_exists($index, self::$middlewares)) {
                    unset(self::$middlewares[$index]);
                }
            }
        }
    }

    public static function group(string $prefix, callable $group, array $middlewares = [])
    {
        if (count($middlewares) > 0) {
            foreach ($middlewares as $middleware) {
                self::setMiddleware($middleware);
            }
        }

        self::$prefix = $prefix;

        call_user_func($group, self::class);

        self::$prefix = substr(0, strlen(self::$prefix) - strlen($prefix));

        if (count($middlewares) > 0) {
            foreach (array_keys($middlewares) as $middleware) {
                self::removeMiddleware($middleware);
            }
        }
    }
 
    public static function router()
    {
        self::$method = strtoupper($_SERVER['REQUEST_METHOD']);
        self::$url    = self::getRequest();
    }

    public static function get(string $request, $callback)
    {
        return self::request('GET', $request, $callback);
    }

    public static function post(string $request, $callback)
    {
        return self::request('POST', $request, $callback);
    }

    public static function delete(string $request, $callback)
    {
        return self::request('DELETE', $request, $callback);
    }

    public static function put(string $request, $callback)
    {
        return self::request('PUT', $request, $callback);
    }

    public static function any($methods, string $request, callable $callback)
    {
        return self::request($methods, $request, $callback);
    }

    private static function request(
        $method, string $request,
        callable $callback
    ) {   
        if (!is_array($method) and $method !== self::$method) {
            return;
        } elseif (
            is_array($method) and 
            array_search(self::$method, $method) === false
        ) {
            return;
        }

        $request = self::$prefix . $request;

        if ($request === self::$request['REQUEST']) {
            if (is_callable($callback)) {
                $request = new self;
                $response = new ResponseProvider;

                if (count(self::$middlewares) > 0) {
                    $next = function (&$callback, &$request, &$response, &$next) {
                        if (count(self::$middlewares) === 0) {
                            return call_user_func($callback, $request, $response);
                        }

                        return call_user_func(
                            array_shift(self::$middlewares),
                            function () use ($callback, &$request, &$response, &$next) {
                                return $next($callback, $request, $response, $next);
                            },
                            $request,
                            $response
                        );
                    };

                    $next($callback, $request, $response, $next);
                } else {
                    call_user_func($callback, $request, $response);
                }

                die();
            }
        }
    }

    public static function error($callback)
    {
        if (is_callable($callback)) {
            call_user_func($callback);
        }

        die();
    }

    private static function getRequest()
    {
        self::$request['SCHEME']  = $_SERVER['REQUEST_SCHEME'];
        self::$request['HOST']    = $_SERVER['HTTP_HOST'];
        self::$request['PORT']    = $_SERVER['SERVER_PORT'];
        self::$request['REQUEST'] = explode('?', $_SERVER['REQUEST_URI'])[0];

        return (
            self::$request['SCHEME'] . '://' .
            self::$request['HOST'] . 
            ((
                self::$request['PORT'] != 80 and
                self::$request['PORT'] != 443
            ) ? ':' . self::$request['PORT'] : '') .
            self::$request['REQUEST']
        );
    }

    public function getMethod()
    {
        return self::$method;
    }

    public function getURL()
    {
        return self::$url;
    }

    public function getScheme()
    {
        return self::$request['SCHEME'];
    }

    public function getInput(string $index = null, $default = null)
    {
        if (is_null($index)) {
            if (count($_POST) > 0 or count($_GET) > 0) {
                return array_merge($_POST, $_GET);
            }
        }

        if (array_search($index, $_POST) !== false) {
            return $_POST[$index];
        }

        if (array_search($index, $_GET) !== false) {
            return $_GET[$index];
        }

        return $default;
    }

    public function getJSON(string $index = null, $default = null)
    {
        if (is_null($this->json)) {
            $this->json = file_get_contents('php://input');
            $this->json = json_decode($this->json);
        }

        if (!is_null($index)) {
            if (isset($this->json->{$index})) {
                return $this->json->{$index};
            }

            return $default;
        }

        return $this->json;
    }
}
