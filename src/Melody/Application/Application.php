<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 6:13 PM
 */

namespace Melody\Application;


use Melody\Application\Loader\ConfigLoader;
use Melody\Application\Loader\DoctrineLoader;
use Melody\Application\Loader\PathsLoader;
use Melody\Application\Loader\TwigLoader;
use Melody\Application\RouterBuilder\RouterBuilder;
use Melody\Http\Request;

abstract class Application  implements ContainerAwareInterface{

    use ContainerAwareTrait;

    private $routes;

    /* @var Kernel */
    protected $kernel;

    protected $booted;

    protected $controllers;

    public function __construct(){
        $this->controllers = array();
        $this->kernel = new Kernel($this);
        $this->booted = false;
    }


    /**
     * @param Request $request
     */
    public function handle($request){
        $this->boot();
        $this->kernel->handle($request);
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
        if($this->booted)
            return;

        $this->initializeContainer();
        $this->initializeControllers();
        $this->booted = true;
    }

    public function initializeContainer(){
        $this->container = new Container($this);
        $loaders = array(
            new PathsLoader(),
            new ConfigLoader(),
            new TwigLoader(),
            new DoctrineLoader()
        );

        foreach ($loaders as $loader) {
            $loader->load($this->container);
        }
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

    public function getConfigDir()
    {
        return $this->getRootDir() . '/config';
    }

    public function getViewDir()
    {
        return $this->getAppDir() . '/View';
    }

    public function getModelDir()
    {
        return $this->getAppDir() . '/Model';
    }
}