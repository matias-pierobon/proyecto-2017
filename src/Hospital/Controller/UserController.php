<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 4:18 PM
 */

namespace Hospital\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Hospital\Model\Role;
use Hospital\Model\User;
use Hospital\Service\PaginationService;
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

    public function indexAction($request)
    {
        $this->denyAccessUnlessGranted('users_index');
        $entities = new ArrayCollection($this->getAllEntities($request));

        /* @var PaginationService $paginationService*/
        $paginationService = $this->get('pagination');

        $pagination = $paginationService->paginate($entities, $request);

        return $this->render(
            $this->getViewFor('index'),
            array(
                "entities" => $pagination['entities'],
                "first" => $pagination['first'],
                "next" => $pagination['next'],
                "prev" => $pagination['prev'],
                "page" => $pagination['page'],
                "pages" => $pagination['pages'],
            )
        );
    }

    public function newAction($request)
    {
        $this->denyAccessUnlessGranted('users_new');
        return parent::newAction($request);
    }

    public function createAction($request)
    {
        $this->denyAccessUnlessGranted('users_new');
        return parent::createAction($request);
    }

    public function showAction($request)
    {
        $this->denyAccessUnlessGranted('users_show');
        return parent::showAction($request);
    }

    public function editAction($request)
    {
        $this->denyAccessUnlessGranted('users_update');
        $user = $this->getEntityByRequest($request);
        $roles = $this->getRepository(Role::class)->findAll();

        return $this->render(
            $this->getViewFor('edit'),
            array('user' => $user, 'roles' => $roles)
        );
    }

    public function updateAction($request)
    {
        $this->denyAccessUnlessGranted('users_update');
        return parent::updateAction($request);
    }

    public function deleteAction($request)
    {
        $this->denyAccessUnlessGranted('users_destroy');
        return parent::deleteAction($request);
    }

    /**
     * @param Request $request
     * @param User $user
     */
    public function processEditRequest($request, $user)
    {
        $user->setEmail($request->getRequest()->get('email', $user->getEmail()));
        $user->setFirstName($request->getRequest()->get('firstName', $user->getFirstName()));
        $user->setLastName($request->getRequest()->get('lastName', $user->getLastName()));

        $user->setEnabled($request->getRequest()->get('enabled', 'off') == 'on');

        $user->setUpdatedAt(new \DateTime());
        $roleRepo = $this->getRepository(Role::class);
        $roles = new ArrayCollection($request->getRequest()->get('rolesId', array()));

        /* @var Role $role */
        foreach ($user->getRoles() as $role) {
            if(!$roles->contains((string) $role->getId()))
                $user->removeRole($role);
        }

        foreach ($roles as $role) {
            $role = $roleRepo->find($role);
            $user->addRole($role);
        }
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