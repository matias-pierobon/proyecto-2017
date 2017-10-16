<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 4:07 PM
 */

namespace Hospital\Repository;


use Doctrine\ORM\EntityRepository;
use Melody\Http\Request;

class PatientRepository extends EntityRepository
{
    /**
     * @param Request $request
     * @return array
     */
    public function findByRequest($request)
    {
        $qb = $this->createQueryBuilder('p');

        if(trim($firstName = $request->getQuery()->get('firstName', '')) != ''){
            $qb->andWhere(
                $qb->expr()->like('p.firstName', "%" . $firstName . "%")
            );
        }

        if(trim($lastName = $request->getQuery()->get('lastName', '')) != ''){
            $qb->andWhere(
                $qb->expr()->like('p.lastName', "%" . $lastName . "%")
            );
        }

        if(trim($dni = $request->getQuery()->get('dni', '')) != ''){
            $qb->andWhere(
                $qb->expr()->eq('p.dni', $dni)
            );
        }

        if(($dniType = $request->getQuery()->get('dniType', -1)) != -1){
            $qb->andWhere(
                $qb->expr()->eq('p.dniType', $dniType)
            );
        }

        return $qb->getQuery()->getArrayResult();
    }
}