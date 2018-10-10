<?php
namespace Router;

use Controller\AuthentificationController;

/**
 * Class Route
 * @package Router
 */
class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    /**
     * Route constructor.
     * @param $path
     * @param $callable
     */
    public function __construct($path, $callable){
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
     * @param $url
     * @return bool
     */
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    /**
     * @return mixed
     */
    public function call(){
        if(is_string($this->callable)){
            $params = explode('#', $this->callable);
            $controller = '\\Controller\\'.$params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

}