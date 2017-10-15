<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 8:02 PM
 */

namespace Melody\Router;


use Melody\Collection\Set;
use Melody\Http\Request;
use Melody\Router\Exception\MethodNotAllowedException;
use Melody\Router\Exception\RouteNotFoundException;

class RequestMatcher
{
    /**
     * @var array
     */
    protected $allow;

    /**
     * @var Set
     */
    protected $routes;

    /**
     * @var Request
     */
    protected $request;

    /* @param Set $routes */
    public function __construct($routes){
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     *
     * @return Match
     *
     * @throws RouteNotFoundException If no matching resource could be found
     * @throws MethodNotAllowedException If a matching resource was found but the request method is not allowed
     */
    public function matchRequest($request){
        $this->request = $request;
        $this->match($request->getPathInfo());

        if(!isset($this->allow[$request->getMethod()])){
            throw new MethodNotAllowedException(
                array_keys($this->allow),
                sprintf('Method "%s" not allow for "%s".', array($request->getMethod(), $request->getPathInfo()))
            );
        }

        return $this->allow[$request->getMethod()];
    }

    /**
     * @param string $pathInfo
     *
     * @return Match
     */
    public function match($pathInfo)
    {
        $this->allow = array();

        /* @var Route $route */
        foreach ($this->routes as $route) {
            if (!preg_match($route->getRegex(), $pathInfo, $matches)) {
                continue;
            }
            $this->allow[$route->getMethod()] = new Match($route, $matches);
        }

        if (count($this->allow) == 0){
            throw new RouteNotFoundException(sprintf('No routes found for "%s".', $pathInfo));
        }
    }

}