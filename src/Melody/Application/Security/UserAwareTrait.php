<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 6:16 AM
 */

namespace Melody\Application\Security;


use Hospital\Model\User;

trait UserAwareTrait
{
    /* @return UserInterface|null */
    public function getUser()
    {
        /* @var Request $request */
        $request = $this->getRequest();
        $user = $request->getSession()->get('user');

        if (!($user instanceof UserInterface)) {
            return null;
        }

        if ($user instanceof User) {
            $repo = $this->getEntityManager()->getRepository(User::class);
            /* @var User $user */
            $user = $repo->find($user->getId());
        }

        if(!$user->isEnabled())
            return null;

        return $user;
    }
}