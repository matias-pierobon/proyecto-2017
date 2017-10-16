<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 3:57 PM
 */

namespace Hospital\Repository;


use Doctrine\ORM\EntityRepository;
use Melody\Http\Request;

class UserRepository extends EntityRepository
{
    /**
     * @param Request $request
     * @return array
     */
    public function findByRequest($request)
    {
        $qb = $this->createQueryBuilder('u');

        if(trim($username = $request->getQuery()->get('username', '')) != ''){
            $qb->andWhere(
                $qb->expr()->like('u.username', "%" . $username . "%")
            );
        }

        if(($enabled = $request->getQuery()->get('enabled', -1)) != -1){
            $qb->andWhere(
                $qb->expr()->eq('u.enabled', $enabled == 1)
            );
        }

        return $qb->getQuery()->getArrayResult();
    }
}