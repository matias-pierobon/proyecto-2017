<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 3:30 PM
 */

namespace Hospital\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Hospital\Model\Site;
use Melody\Application\ContainerAwareInterface;
use Melody\Application\Controller\ContainerControllerTrait;
use Melody\Application\Controller\DoctrineControllerTrait;
use Melody\Http\Request;

class PaginationService implements ContainerAwareInterface
{
    use ContainerControllerTrait, DoctrineControllerTrait;

    /**
     * @param ArrayCollection $entities
     * @param Request $request
     * @return array
     */
    public function paginate($entities, $request, $orders = array())
    {
        $maxElements = (int) $this->getMaxElements();
        $page = (int) $request->getQuery()->get('page', 1);
        $pages = ceil($entities->count() / $maxElements);
        $first = $maxElements * ($page-1);

        $criteria = Criteria::create()
            ->setFirstResult($first)
            ->setMaxResults($maxElements)
            ->orderBy($orders);

        return array(
            'entities' => $entities->matching($criteria),
            'first' => $first,
            'next' => $page + 1,
            'prev' => $page - 1,
            'page' => $page,
            'pages' => $pages
        );
    }

    /* @return Site */
    public function getSite()
    {
        return $this->getRepository(Site::class)->getSite();
    }

    public function getMaxElements(){
        return $this->getSite()->getMaxElements();
    }

}