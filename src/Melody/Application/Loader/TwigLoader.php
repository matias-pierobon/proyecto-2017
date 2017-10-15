<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 7:33 PM
 */

namespace Melody\Application\Loader;

use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigLoader extends Loader
{
    public  function load($container)
    {
        $loader = new Twig_Loader_Filesystem($container->getParameter('paths.view'));
        $twig = new Twig_Environment($loader, array(
            //'cache' => $container->getParameter('paths.cache')
        ));

        $container->register('twig', $twig);
    }
}