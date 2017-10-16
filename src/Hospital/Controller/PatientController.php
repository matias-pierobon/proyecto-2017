<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 4:18 PM
 */

namespace Hospital\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Hospital\Model\Patient;
use Hospital\Model\Role;
use Hospital\Model\User;
use Melody\Application\Controller\CrudController;
use Melody\Http\Request;

class PatientController extends CrudController
{

    public function indexAction($request)
    {
        $this->denyAccessUnlessGranted('patients_index');
        return parent::indexAction($request);
    }

    public function newAction($request)
    {
        $this->denyAccessUnlessGranted('patients_new');
        return parent::newAction($request);
    }

    public function createAction($request)
    {
        $this->denyAccessUnlessGranted('patients_new');
        return parent::createAction($request);
    }

    public function showAction($request)
    {
        $this->denyAccessUnlessGranted('patients_show');
        return parent::showAction($request);
    }

    public function editAction($request)
    {
        $this->denyAccessUnlessGranted('patients_update');
        $user = $this->getEntityByRequest($request);
        $roles = $this->getRepository(Role::class)->findAll();

        return $this->render(
            $this->getViewFor('edit'),
            array('user' => $user, 'roles' => $roles)
        );
    }

    public function updateAction($request)
    {
        $this->denyAccessUnlessGranted('patients_update');
        return parent::updateAction($request);
    }

    public function deleteAction($request)
    {
        $this->denyAccessUnlessGranted('patients_destroy');
        return parent::deleteAction($request);
    }

    public function getEntityName()
    {
        return Patient::class;
    }

    public  function createEntity()
    {
        return new Patient();
    }

    public function getRoutePrefix()
    {
        return '/admin/patient';
    }

    public function getViewPath()
    {
        return 'Patient';
    }

}