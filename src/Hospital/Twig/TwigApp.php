<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 11:14 PM
 */

namespace Hospital\Twig;


use Hospital\Application;
use Melody\Application\ContainerAwareTrait;

class TwigApp
{
    use ContainerAwareTrait;

    public function __construct($container){
        $this->container = $container;
    }

    /* @return Application */
    public function getApplication()
    {
        return $this->container->getApp();
    }
}