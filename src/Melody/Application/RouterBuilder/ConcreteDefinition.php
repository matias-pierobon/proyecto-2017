<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 9:22 PM
 */

namespace Melody\Application\RouterBuilder;


use Melody\Router\Route;

class ConcreteDefinition extends Definition
{
    private $method;
    private $action;

    /* @param Definition $parent */
    public function __construct($parent, $action, $method)
    {
        parent::__construct($parent, '', $parent->getController());
        $this->action = $action;
        $this->method = $method;
        $this->getBuilder()->register($this);
    }

    /* @return Route */
    public function compile()
    {
        return new Route(
            $this->getRegex(),
            $this->getMethod(),
            $this->getController(),
            $this->getAction()
        );
    }

    /* @return string */
    public function getRegex()
    {
        return "/^" . str_replace("/", "\\/", $this->getPattern()) . "$/i";
    }

    public function getMethod(){
        return strtoupper($this->method);
    }

    public function setMethod($method){
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}