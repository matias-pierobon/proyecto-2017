<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 3:58 AM
 */

namespace Melody\Application\Controller;


use Hospital\Model\User;
use Melody\Application\Exception\AccessDeniedException;
use Melody\Application\Security\UserInterface;
use Melody\Http\Request;

trait SecurityContainerTrait
{
    /**
     * @param $attribute
     * @return bool
     */
    protected function isGranted($attribute){
        $user = $this->getUser();

        if(!$user)
            return false;

        return $user->isGranted($attribute);
    }

    protected function denyAccessUnlessGranted($attribute, $message = 'Access Denied.')
    {
        if (!$this->isGranted($attribute)) {
            throw $this->createAccessDeniedException($message);
        }
    }

    protected function createAccessDeniedException($message = 'Access Denied.', \Exception $previous = null)
    {
        return new AccessDeniedException($message, $previous);
    }

    /* @return UserInterface|null */
    protected function getUser()
    {
        /* @var Request $request */
        $request = $this->get('request');
        $user = $request->getSession()->get('user');

        if (!is_object($user)) {
            return null;
        }

        if ($user instanceof User) {
            $repo = $this->getEntityManager()->getRepository(User::class);
            /* @var User $user */
            $user = $repo->find($user->getId());
        }

        return $user;
    }
}