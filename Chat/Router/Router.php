<?php
namespace Router;

/**
 * Class Router
 * @package Router
 */
class Router
{

    private $url;
    private $routes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param $path
     * @param $callable
     * @return Route
     */
    public function get($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes["GET"][] = $route;
        return $route;
    }

    /**
     * @param $path
     * @param $callable
     * @return Route
     */
    public function post($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes["POST"][] = $route;
        return $route;
    }

    /**
     * @param $path
     * @param $callable
     * @return Route
     */
    public function delete($path, $callable)
    {
        $route = new Route($path, $callable);
        $this->routes["DELETE"][] = $route;
        return $route;
    }

    /**
     * @param $pseudo
     * @return mixed
     * @throws \Exception
     */
    public function run($pseudo)
    {

        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new \Exception('REQUEST_METHOD does not exist', 400);
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                if (!$pseudo && $route->getPath() != 'login') {
                    header('Location: login');
                }

                return $route->call();
            }
        }
        throw new Exception('No matching routes');
    }
}