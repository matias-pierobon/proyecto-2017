<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 11:23 PM
 */

namespace Hospital;

use Melody\Application\Application as BaseApplication;
use Melody\Application\RouterBuilder\RouterBuilder;

class Application extends BaseApplication
{
    protected function registerRoutes($builder)
    {
        $router = new Router();
        $router->register($builder);
    }

    public function getRootDir()
    {
        return __DIR__ . '/../../';
    }

    public function getAppDir()
    {
        return __DIR__;
    }

}