<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 11:14 PM
 */

namespace Hospital\Twig;


use Hospital\Application;
use Hospital\Model\Site;
use Melody\Application\ContainerAwareInterface;
use Melody\Application\ContainerAwareTrait;
use Melody\Application\Controller\ContainerControllerTrait;
use Melody\Application\Controller\DoctrineControllerTrait;
use Melody\Application\Security\UserAwareTrait;
use Melody\Http\Request;

class TwigApp  implements ContainerAwareInterface
{
    use ContainerControllerTrait, DoctrineControllerTrait, UserAwareTrait;

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

    /* @return Site */
    public function getSite()
    {
        return $this->getRepository(Site::class)->getSite();
    }
}