<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 8:26 PM
 */

namespace Melody\Application\Loader;


class PathsLoader implements Loader
{
    public function load($container)
    {
        $container
            ->setParameter('paths.root', $container->getApp()->getRootDir())
            ->setParameter('paths.app', $container->getApp()->getAppDir())
            ->setParameter('paths.model', $container->getApp()->getModelDir())
            ->setParameter('paths.view', $container->getApp()->getViewDir())
            ->setParameter('paths.config', $container->getApp()->getConfigDir())
            ->setParameter('paths.cache', $container->getApp()->getCacheDir())
            ->setParameter('paths.logs', $container->getApp()->getLogDir());
    }
}