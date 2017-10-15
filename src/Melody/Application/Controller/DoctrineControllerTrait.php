<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:53 PM
 */

namespace Melody\Application\Controller;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

trait DoctrineControllerTrait
{
    use ContainerControllerTrait;

    /* @return EntityManager */
    public function getEntityManager()
    {
        return $this->get('entityManager');
    }

    /* @return EntityRepository */
    public function getRepository($entity)
    {
        return $this->getEntityManager()->getRepository($entity);
    }
}