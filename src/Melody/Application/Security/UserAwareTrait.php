<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 6:16 AM
 */

namespace Melody\Application\Security;


trait UserAwareTrait
{
    /* @return UserInterface|null */
    public function getUser()
    {
        /* @var Request $request */
        $request = $this->getRequest();
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