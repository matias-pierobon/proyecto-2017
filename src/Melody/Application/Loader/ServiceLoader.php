<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 11:16 PM
 */

namespace Melody\Application\Loader;


use Melody\Application\Container;

class ServiceLoader implements Loader
{
    public function load($container)
    {
        foreach ($container->getApp()->getServices() as $name => $service) {
            $container->register($name, $service);
        }
    }

}