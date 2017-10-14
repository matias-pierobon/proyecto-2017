<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 7:30 PM
 */

namespace Melody\Application;


class Container {
    /* @var Application $app */
    protected $app;
    protected $services;
    protected $parameters;

    /* @param Application $app */
    public function __construct($app){
        $this->app = $app;
        $this->services = array();
        $this->parameters = array();
    }

    /**
     *  @return self
     */
    public function register($name, $service)
    {
        $this->services[$name] = $service;
        return $this;
    }

    public function get($name){
        return $this->services[$name];
    }

    public function getParameter($name){
        return $this->parameters[(string) $name];
    }

    /**
     *  @return self
     */
    public function setParameter($name, $parameter){
        $this->parameters[(string) $name] = $parameter;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @return Application
     */
    public function getApp(){
        return $this->app;
    }
}