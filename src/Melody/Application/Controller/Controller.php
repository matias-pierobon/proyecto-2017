<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:38 PM
 */

namespace Melody\Application\Controller;


use Melody\Application\ContainerAwareInterface;
use Melody\Application\ContainerAwareTrait;
use Doctrine\ORM\EntityManager;
use Twig_Environment;

abstract class Controller implements DoctrineControllerInterface, RenderControllerInterface
{
    use DoctrineControllerTrait;
    use RenderControllerTrait;

}