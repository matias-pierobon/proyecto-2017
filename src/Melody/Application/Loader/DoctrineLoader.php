<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 7:33 PM
 */

namespace Melody\Application\Loader;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineLoader extends Loader
{
    public function load($container)
    {
        $paths = array($container->getParameter('paths.model'));
        $isDevMode = false;

        // the connection configuration
        $dbParams = array(
            'driver'   => $container->getParameter('db.driver'),
            'user'     => $container->getParameter('db.user'),
            'password' => $container->getParameter('db.password'),
            'dbname'   => $container->getParameter('db.database'),
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config);
        $container->register('entityManager', $entityManager);
    }
}