<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 4:07 PM
 */

namespace Hospital\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Hospital\Model\Patient;
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

        if(trim($dni = $request->getQuery()->get('dni', '')) != ''){
            $qb->andWhere(
                $qb->expr()->eq('p.dni', $qb->expr()->literal($dni))
            );
        }

        if(($dniType = $request->getQuery()->get('dniType', -1)) != -1){
            $qb->andWhere(
                $qb->expr()->eq('p.dniType', $qb->expr()->literal($dniType))
            );
        }

        $results = new ArrayCollection($qb->getQuery()->getResult());
        /* @var Patient $result */
        foreach ($results as $result) {
            if(trim($firstName = $request->getQuery()->get('firstName', '')) != ''){
                if (strpos($result->getFirstName(), $firstName) === false)
                    $results->removeElement($result);
            }
            if(trim($lastName = $request->getQuery()->get('lastName', '')) != ''){
                if (strpos($result->getLastName(), $lastName) === false)
                    $results->removeElement($result);
            }
        }

        return $results->toArray();

    }
}