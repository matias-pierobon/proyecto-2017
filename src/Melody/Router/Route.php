<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 4:39 PM
 */

namespace Melody\Router;


class Route
{
    /* @var string $regex */
    private $regex;
    private $method;
    private $controller;
    private $action;

    public function __construct($regex, $method, $controller, $action){
        $this->regex = $regex;
        $this->method = $method;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getRegex()
    {
        return $this->regex;
    }

}