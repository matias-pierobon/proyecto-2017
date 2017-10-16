<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 4:18 PM
 */

namespace Hospital\Controller;


use Hospital\Model\User;
use Melody\Application\Controller\CrudController;
use Melody\Http\Request;

class UserController extends CrudController
{
    /**
     * @param Request $request
     * @param User $user
     */
    public function processNewRequest($request, $user)
    {
        parent::processNewRequest($request, $user);
        $date = new \DateTime();
        $user->setUpdatedAt($date);
        $user->setCreatedAt($date);
    }

    /**
     * @param Request $request
     * @param User $user
     */
    public function processEditRequest($request, $user)
    {
        parent::processEditRequest($request, $user);
        $user->setUpdatedAt(new \DateTime());
    }

    public function getEntityName()
    {
        return User::class;
    }

    public  function createEntity()
    {
        return new User();
    }

    public function getRoutePrefix()
    {
        return '/admin/user';
    }

    public function getViewPath()
    {
        return 'User';
    }

}