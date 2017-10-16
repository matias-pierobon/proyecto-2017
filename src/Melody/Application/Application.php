<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 6:13 PM
 */

namespace Melody\Application;


use Melody\Application\Loader\ServiceLoader;
use RuntimeException;
use Melody\Application\Loader\ConfigLoader;
use Melody\Application\Loader\DoctrineLoader;
use Melody\Application\Loader\PathsLoader;
use Melody\Application\Loader\TwigLoader;
use Melody\Application\RouterBuilder\RouterBuilder;
use Melody\Http\Request;
use Melody\Http\Response;
use Melody\Router\Router;

abstract class Application  implements ContainerAwareInterface{

    use ContainerAwareTrait;

    /* @var Router */
    private $router;

    /* @var Kernel */
    protected $kernel;

    protected $booted;

    protected $controllers;

    public function __construct(){
        $this->controllers = array();
        $this->kernel = new Kernel($this);
        $this->booted = false;
        $this->router = new Router();
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param Request $request
     */
    public function handle($request){
        $this->boot();
        $this->container->register('request', $request);
        $this->kernel->handle($request);
    }

    /**
     * @param \Exception $exception
     * @param Request $request
     * @return Response
     */
    public function handleException($exception, $request){
        return new Response($exception->getMessage(), $exception->getCode());
    }

    public function registerController($name, $controller){
        $this->controllers[$name] = $controller;
        if($controller instanceof ContainerAwareInterface)
            $controller->setContainer($this->container);
    }

    /* @return array */
    public abstract function getControllers();

    public function getController($name){
        if (!isset($this->controllers[$name]))
            throw new RuntimeException(sprintf('No controller named "%s"', $name));
        return $this->controllers[$name];
    }

    public function boot(){
        if($this->booted)
            return;

        $this->initializeContainer();
        $this->initializeControllers();
        $this->generateRoutes();
        $this->postBoot();
        $this->booted = true;
    }

    public function dump($var){
        echo("<pre><code>");
        var_dump($var);
        echo("</code></pre>");
    }

    public function initializeContainer(){
        $this->container = new Container($this);
        $loaders = array(
            new PathsLoader(),
            new ConfigLoader(),
            new TwigLoader(),
            new DoctrineLoader(),
            new ServiceLoader()
        );

        foreach ($loaders as $loader) {
            $loader->load($this->container);
        }
    }

    public function initializeControllers()
    {
        foreach ($this->getControllers() as $name => $controller) {
            $this->registerController($name, $controller);
        }
    }

    public function getServices(){ return array(); }

    protected function generateRoutes(){
        $builder = new RouterBuilder();
        $this->registerRoutes($builder);
        $builder->build($this->router);
    }

    public function postBoot(){}


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