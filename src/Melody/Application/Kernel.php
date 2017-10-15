<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 7:31 PM
 */

namespace Melody\Application;

use Melody\Http\Request;
use Melody\Http\Response;
use Melody\Router\Match;
use Melody\Router\Route;
use Melody\Router\Router;

/**
 * Class Kernel
 * @package Melody\Application
 */
class Kernel {

    /* @var Application */
    private $application;

    /**
     * @param Application $application
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * @param Request $request
     */
    public function handle($request)
    {
        /* @var Response|null $response */
        $response = null;
        try {
            $response = $this->handleRaw($request);
        }catch (\Exception $exception){
            $response = $this->handleException($exception, $request);
        }finally{
            $response->send();
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    private function handleRaw($request){
        $route = $this->getRoute($request);
        $ctrl = $this->getController($route->getController());
        $action = $route->getAction() . 'Action';
        return $ctrl->$action($request);
    }

    protected function getController($controller){
        return $this->application->getController($controller);
    }

    /**
     * @param Request $request
     *
     * @return Route
     */
    protected function getRoute($request){

        $match = $this->matchRequest($request);
        $request->setParameters($match->getParams());
        return $match->getRoute();
    }

    /* @return Match */
    protected function matchRequest($request){
        return $this->getRouter()->matchRequest($request);
    }

    /* @return Router */
    protected function getRouter(){
        return $this->application->getRouter();
    }

    /**
     * @param \Exception $exception
     * @param Request $request
     * @return Response
     */
    private function handleException($exception, $request){
        return new Response($exception->getMessage(), $exception->getCode());
    }
}