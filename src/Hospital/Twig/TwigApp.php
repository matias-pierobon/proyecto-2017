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
use Melody\Application\Security\UserAwareTrait;
use Melody\Http\Request;

class TwigApp
{
    use ContainerAwareTrait, UserAwareTrait;

    public function __construct($container){
        $this->container = $container;
    }

    /* @return Application */
    public function getApplication()
    {
        return $this->container->getApp();
    }

    /* @return Request */
    public function getRequest()
    {
        return $this->container->get('request');
    }

    protected function getEntityManager(){
        return $this->container->get('entityManager');
    }
}