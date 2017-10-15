<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 3:24 PM
 */

namespace Melody\Router;

use Melody\Collection\Set;
use Melody\Http\Request;

class Router
{
    /* @var RequestMatcher */
    private $matcher;

    /* @var Set */
    private $routes;

    public function __construct()
    {
        $this->routes = new Set();
        $this->matcher = new RequestMatcher($this->routes);
    }

    /**
     * @param Request $request
     *
     * @return Match
     */
    public function matchRequest($request)
    {
        $matcher = $this->getMatcher();
        return $matcher->matchRequest($request);
    }

    /**
     * @param Route $route
     *
     * @return self
     */
    public function add($route)
    {
        $this->routes->add($route);
        return $this;
    }

    /**
     * @param Route $route
     *
     * @return self
     */
    public function remove($route)
    {
        $this->routes->remove($route);
        return $this;
    }

    /**
     * @return RequestMatcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @return Set
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}