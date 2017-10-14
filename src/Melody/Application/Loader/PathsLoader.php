<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 8:26 PM
 */

namespace Melody\Application\Loader;


class PathsLoader extends Loader
{
    public function load($container)
    {
        $container
            ->setParameter('paths.model', $container->getApp()->getModelDir())
            ->setParameter('paths.view', $container->getApp()->getModelDir())
            ->setParameter('paths.cache', $container->getApp()->getCacheDir())
            ->setParameter('paths.logs', $container->getApp()->getLogDir())
            ->setParameter('paths.app', $container->getApp()->getAppDir())
            ->setParameter('paths.root', $container->getApp()->getRootDir());
    }
}