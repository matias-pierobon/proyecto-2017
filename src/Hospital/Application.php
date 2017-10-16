<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 11:23 PM
 */

namespace Hospital;

use Hospital\Controller\ExceptionController;
use Hospital\Controller\FrontendController;
use Melody\Application\Application as BaseApplication;
use Melody\Application\RouterBuilder\RouterBuilder;

class Application extends BaseApplication
{
    protected function registerRoutes($builder)
    {
        $router = new Router();
        $router->register($builder);
    }

    public  function getControllers()
    {
        return array(
            "Exception" => new ExceptionController(),
            "Frontend" => new FrontendController()
        );
    }

    public function handleException($exception, $request){
        return $this->getController('Exception')->errorAction($request, $exception);
    }

    public function getRootDir()
    {
        return __DIR__ . '/../..';
    }

    public function getAppDir()
    {
        return __DIR__;
    }

}