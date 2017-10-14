<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 6:13 PM
 */

namespace Melody\Application;


use Melody\Application\Loader\DoctrineLoader;
use Melody\Application\Loader\PathsLoader;
use Melody\Application\Loader\TwigLoader;
use Melody\Application\RouterBuilder\RouterBuilder;

abstract class Application {

    private $routes;

    /* @var Container $container*/
    protected $container;

    protected $controllers;

    public function __construct(){
        $this->controllers = array();
    }

    public function registerController($name, $controller){
        $this->controllers[$name] = $controller;
    }

    public function getControllers()
    {
        return $this->controllers;
    }

    public function getController($name){
        return $this->controllers[$name];
    }

    public function boot(){
        $this->initializeContainer();
        $this->initializeControllers();
    }

    public function initializeContainer(){
        $this->container = new Container($this);
        $loaders = array(
            new PathsLoader(),
            new TwigLoader(),
            new DoctrineLoader()
        );

        foreach ($loaders as $loader) {
            $loader->load($this->container);
        }
    }

    public function getContainer(){
        return $this->container;
    }

    public function initializeControllers()
    {
        foreach ($this->getControllers() as $controller) {
            $controller->setContainer($this->container);
        }
    }

    protected function generateRoutes(){
        $builder = new RouterBuilder();
        $this->registerRoutes($builder);
    }

    /* @param RouterBuilder $builder */
    protected abstract function registerRoutes($builder);

    public abstract function getRootDir();

    public abstract function getAppDir();

    public function getLogDir()
    {
        return $this->getRootDir() . '/var/logs';
    }

    public function getCacheDir()
    {
        return $this->getRootDir() . '/var/cache';
    }

    public function getViewDir()
    {
        return $this->getAppDir() . '/view';
    }

    public function getModelDir()
    {
        return $this->getAppDir() . '/model';
    }
}