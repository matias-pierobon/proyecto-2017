<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 6:11 PM
 */

namespace Hospital\Controller;


use Hospital\Model\DemographicData;
use Hospital\Model\HeatingType;
use Hospital\Model\HouseType;
use Hospital\Model\Patient;
use Hospital\Model\WaterType;
use Melody\Application\Controller\Controller;
use Melody\Http\Request;
use Melody\Http\Response;

class DemographicController extends Controller
{

    protected function getData(){
        return array(
            'waterTypes' => $this->getRepository(WaterType::class)->findAll(),
            'houseTypes' => $this->getRepository(HouseType::class)->findAll(),
            'heatingTypes' => $this->getRepository(HeatingType::class)->findAll(),
        );
    }
    /**
     * @param Request $request
     * @return Response
     */
    public function newAction($request)
    {
        $this->denyAccessUnlessGranted('demographic_add');

        $patient = $this->getPatient();
        $data = $this->getData();
        return $this->render('DemographicData/new.html.twig', array(
            'patient' => $patient,
            'waterTypes' => $data['waterTypes'],
            'houseTypes' => $data['houseTypes'],
            'heatingTypes' => $data['heatingTypes'],
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction($request)
    {
        $this->denyAccessUnlessGranted('demographic_add');

        $demographic = new DemographicData();
        $demographic->setElectricity($request->getRequest()->get('electricity', 'off') == 'on');
        $demographic->setRefrigerator($request->getRequest()->get('refrigerator', 'off') == 'on');
        $demographic->setPet($request->getRequest()->get('pet', 'off') == 'on');

        $waterType = $this->getRepository(WaterType::class)->find($request->getRequest()->get('waterType'));
        $houseType = $this->getRepository(HouseType::class)->find($request->getRequest()->get('houseType'));
        $heatingType = $this->getRepository(HeatingType::class)->find($request->getRequest()->get('heatingType'));

        $demographic->setWaterType($waterType);
        $demographic->setHouseType($houseType);
        $demographic->setHeatingType($heatingType);

        $this->getPatient()->setDemographicData($demographic);

        $em = $this->getEntityManager();
        $em->persist($demographic);
        $em->flush();

        return $this->redirect('/admin/patient/' . $this->getPatient()->getId());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editAction($request)
    {
        $this->denyAccessUnlessGranted('demographic_update');

        $patient = $this->getPatient();
        $data = $this->getData();

        return $this->render('DemographicData/edit.html.twig', array(
            'patient' => $patient,
            'data' => $patient->getDemographicData(),
            'waterTypes' => $data['waterTypes'],
            'houseTypes' => $data['houseTypes'],
            'heatingTypes' => $data['heatingTypes'],
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateAction($request)
    {
        $this->denyAccessUnlessGranted('demographic_update');

        $demographic = $this->getPatient()->getDemographicData();
        $demographic->setElectricity($request->getRequest()->get('electricity', 'off') == 'on');
        $demographic->setRefrigerator($request->getRequest()->get('refrigerator', 'off') == 'on');
        $demographic->setPet($request->getRequest()->get('pet', 'off') == 'on');

        $waterType = $this->getRepository(WaterType::class)->find($request->getRequest()->get('waterType'));
        $houseType = $this->getRepository(HouseType::class)->find($request->getRequest()->get('houseType'));
        $heatingType = $this->getRepository(HeatingType::class)->find($request->getRequest()->get('heatingType'));

        $demographic->setWaterType($waterType);
        $demographic->setHouseType($houseType);
        $demographic->setHeatingType($heatingType);

        $this->getEntityManager()->flush();

        return $this->redirect('/admin/patient/' . $this->getPatient()->getId());
    }

    /* @return Patient */
    protected function getPatient()
    {
        $id = $this->getRequest()->getParameters()->get('id');
        return $this->getRepository(Patient::class)->find($id);
    }
}