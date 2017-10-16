<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 4:12 PM
 */

namespace Hospital\Repository;


use Doctrine\ORM\EntityRepository;
use Hospital\Model\Site;

class SiteRepository extends EntityRepository
{
    public function getSite()
    {
        $site = $this->findAll();
        if(count($site) > 0)
            return $site[0];

        $site = new Site();

        $em = $this->getEntityManager();
        $em->persist($site);
        $em->flush();
    }
}