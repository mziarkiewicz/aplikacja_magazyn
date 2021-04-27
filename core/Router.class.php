<?php

namespace core;

class Router {

    private $action = null;
    public  $routes = array();
    private $default = null;
    private $login = 'login';
    private $config = null;

    public function __construct(&$config) {
        if (!(isset($config) && $config instanceof Config)){
            throw new \Exception('Configuration missing or incorrect');
        }
        $this->config = $config;
    }
    
    public function setAction($action) {
        $this->action = $action;
    }

    public function getAction() {
        return $this->action;
    }
    
    public function addRouteEx($action, $namespace, $controller, $method, $roles = null) {
        $this->routes[$action] = new Route($namespace, $controller, $method, $roles);
    }

    public function addRoute($action, $controller, $roles = null) {
        $this->routes[$action] = new Route(null, $controller, 'action_'.$action, $roles);
    }

    public function setDefaultRoute($route) {
        $this->default = $route;
    }
    
    public function getDefaultRoute(){
        return $this->default;
    }

    public function setLoginRoute($route) {
        $this->login = $route;
    }

    public function getLoginRoute() {
        return $this->login;
    }
    
    private function control($namespace, $controller, $method, $roles = null) {
        if (!empty($roles)) {
            $found = false;
            if (is_array($roles)) {
                foreach ($roles as $role) {
                    if (RoleUtils::inRole($role)) {
                        $found = true;
                        break;
                    }
                }
            } else {
                if (RoleUtils::inRole($roles))
                    $found = true;
            }
            if (!$found)
                $this->forwardTo($this->login);
        }
        if (empty($namespace)) {
            $controller = "app\\controllers\\" . $controller;
        } else {
            $controller = $namespace . "\\" . $controller;
        }
        $ctrl = new $controller;
        if (method_exists($ctrl, $method)) {
            $ctrl->$method();
        } else {
            throw new \Exception('Method "' . $method . '" does not exist in "' . $controller . '"');
        }
        exit;
    }

    public function go() {
        if (isset($this->routes[$this->action])) {
            $r = $this->routes[$this->action];
            $this->control($r->namespace, $r->controller, $r->method, $r->roles);
        } else {
            if (isset($this->default) && isset($this->routes[$this->default])) {
                $r = $this->routes[$this->default];
                $this->control($r->namespace, $r->controller, $r->method, $r->roles);
            } else {
                throw new \Exception('Route for "' . $this->action . '" is not defined');
            }
        }
    }

    public function forwardTo($action_name) {
        $this->setAction($action_name);
        include $this->config->root_path . $this->config->action_script;
        exit;
    }

    public function redirectTo($action_name,$header = null) {
        if (empty($header)){
            $header = "Location";
        }
        header($header .": " . $this->config->action_url . $action_name);
        exit;
    }

}
