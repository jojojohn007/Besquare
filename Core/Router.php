<?php

namespace Core;

class Router
{
    protected array $routes = [];
    protected array $params = [];
    protected Request $request;
    protected string $method;

    public function __construct()
    {
        $this->request = new Request();
        $this->method = $this->request->getMethod();
    }

    public function get($route, $param = []): void
    {
        if ($this->method == 'get') {
            $this->addRoutes($route, $param);
        }
    }

    public function delete($route, $param)
    {

        if ($this->method == 'delete') {
            $this->addRoutes($route, $param);
        }
    }

    public function post($route, $param = []): void
    {
        if ($this->method == 'post') {
            $this->addRoutes($route, $param);
        }
    }

    public function addRoutes($route, $param = []): void
    {
        // vd($param);
        // vd($route);
        $route = preg_replace('/\//', '\\/', $route);
        // vd($route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        // vd($route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $param;
    }

    public function getAllRoutes(): array
    {

        return $this->routes;
    }

    public function dispatch($url)
    {

        if ($this->matched($url)) {
            $controller = str_replace('-', '', ($this->params['controller']) ?? 'View');
            $controller = ($this->convertToStudlyCaps($controller));
            $controller = $this->getNamespace() . $controller;
            //check if controller class exist ; 

            if (class_exists($controller)) {
                //check is method callable 
                $action = $this->params['action'] ?? 'view';
                $action = ($this->convertToCamelcase($action)) . 'Action';
                $controller_object = new $controller();

                if (is_callable([$controller_object, $action])) {
                    self::callController($controller_object, $action);
                } else {
                    // echo  "method $action not found in $controller";
                    throw new \Exception("method $action not found in $controller");
                }
            } else {
                // echo "controller $controller  does not exist";
                throw new \Exception("controller $controller  does not exist");
            }
        } else {
            // echo 'router not found';
            throw new \Exception($url . 'router not found', 404);
        }
    }



    public  function callController($controller_object, $action)
    {


        $r  = new \ReflectionMethod($controller_object, $action);
        if (array_key_exists('View', $this->params)) {
            $controller_object->$action($this->params['View']);
            unset($controller_object);
            exit();
        } elseif (count($r->getParameters())) {
            //if calling controller methods require any parameters
            $calledControllerParameters = $r->getParameters();
            // vd($calledControllerParameters);
            $objectstopass = [];
            foreach ($calledControllerParameters as $parameter) {
                $methodtypeisobject = $parameter->getType() ?? null;
                if ($methodtypeisobject) {
                    $methodsClassName = ($methodtypeisobject->getName());
                    $requiredObj = new $methodsClassName();
                    // vd($requiredObj);
                    array_push($objectstopass, $requiredObj);
                } else {
                    $requiredParam = ($this->params[$parameter->name]);

                    // $controller_object->$action($requiredParam);
                    array_push($objectstopass, $requiredParam);
                }
            }

            $controller_object->$action(...$objectstopass);
        
        } else {
            $controller_object->$action($this->params['action']);
            exit();
        }
    }

    public function matched($url): bool
    {
        $url = lcfirst($url);

        foreach ($this->routes as $router => $params) {
            // pr($router);
            // pr($params);
            if (preg_match($router, $url, $matches)) {
                // pr($matches);
                foreach ($matches as $key => $values) {
                    // pr($key);
                    // pr($values);
                    if (is_string($key)) {
                        $params[$key] = $values;
                    }
                }
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    public function getAllParams(): array
    {

        return $this->params;
    }
    protected function convertToCamelcase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }
    protected function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }
    public function getNamespace(): string
    {

        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {

            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }

    private function runDynamicController()
    {
    }
}
