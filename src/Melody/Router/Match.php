<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 9:58 PM
 */

namespace Melody\Router;


class Match
{
    /* @var Route */
    private $route;

    /* @var array */
    private $params;

    /**
     * @param Route $route
     * @param array $params
     */

    public function __construct($route, $params)
    {
        $this->route = $route;
        $this->params = $params;
    }

    /**
     * @param mixed $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getParameter($name, $default=null)
    {
        if(!isset($this->params[$name]))
            return $default;

        return $this->params[$name];
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }
}