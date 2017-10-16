<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 11:23 PM
 */

namespace Hospital;

use Hospital\Controller\AdminController;
use Hospital\Controller\DemographicController;
use Hospital\Controller\ExceptionController;
use Hospital\Controller\FrontendController;
use Hospital\Controller\PatientController;
use Hospital\Controller\UserController;
use Hospital\Model\Patient;
use Hospital\Service\PaginationService;
use Hospital\Twig\TwigApp;
use Melody\Application\Application as BaseApplication;
use Melody\Application\RouterBuilder\RouterBuilder;

class Application extends BaseApplication
{
    protected function registerRoutes($builder)
    {
        $router = new Router();
        $router->register($builder);
    }

    public function postBoot(){
        /* @var \Twig_Environment $twig */
        $twig = $this->getContainer()->get('twig');

        $twig->addGlobal('app', new TwigApp($this->getContainer()));
    }

    public  function getControllers()
    {
        return array(
            "Exception" => new ExceptionController(),
            "Frontend" => new FrontendController(),
            "Admin" => new AdminController(),
            "User" => new UserController(),
            "Patient" => new PatientController(),
            "Demographic" => new DemographicController()
        );
    }

    public function getServices()
    {
        return array(
            'pagination' => new PaginationService()
        );
    }

    public function handleException($exception, $request){
        return $this->getController('Exception')->errorAction($request, $exception);
    }

    public function getRootDir()
    {
        return __DIR__ . '/../..';
    }

    public function getAppDir()
    {
        return __DIR__;
    }

}