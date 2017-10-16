<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 4:18 PM
 */

namespace Hospital\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Hospital\Model\DniType;
use Hospital\Model\MedicalInsurance;
use Hospital\Model\Patient;
use Hospital\Model\Role;
use Hospital\Model\User;
use Melody\Application\Controller\CrudController;
use Melody\Http\Request;

class PatientController extends CrudController
{

    public function processRequest($request, $entity)
    {
        /* @var Patient $patient*/
        $patient = $entity;

        $patient->setLastName($request->getRequest()->get('lastName'));
        $patient->setFirstName($request->getRequest()->get('firstName'));
        $patient->setEmail($request->getRequest()->get('email'));
        $patient->setAddress($request->getRequest()->get('address'));
        $patient->setBirthDate(new \DateTime($request->getRequest()->get('birthDate')));
        $patient->setDni($request->getRequest()->get('dni'));
        $patient->setPhone($request->getRequest()->get('phone'));
        $patient->setSex($request->getRequest()->get('sex', '0') == '1');

        $dniType = $request->getRequest()->get('dniType');
        $dniType = $this->getRepository(DniType::class)->find($dniType);
        $patient->setDniType($dniType);

        $insurance = $request->getRequest()->get('insurance', '-1');
        if($insurance != '-1') {
            $insurance = $this->getRepository(MedicalInsurance::class)->find($dniType);
            $patient->setMedicalInsurance($insurance);
        }

    }

    public function indexAction($request)
    {
        $this->denyAccessUnlessGranted('patients_index');
        return parent::indexAction($request);
    }

    public function newAction($request)
    {
        $this->denyAccessUnlessGranted('patients_new');

        $dnyTypes = $this->getRepository(DniType::class)->findAll();
        $insurances = $this->getRepository(MedicalInsurance::class)->findAll();

        return $this->render($this->getViewFor('new'), array(
            'dniTypes' => $dnyTypes,
            'insurances' => $insurances
        ));
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