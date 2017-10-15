<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 6:25 PM
 */

namespace Hospital\Controller;


use Melody\Application\Controller\Controller;
use Melody\Http\Request;
use Melody\Http\Response;

class ExceptionController extends Controller
{
    /**
     * @param Request $request
     * @param \Exception $exception
     *
     * @return Response
     */
    public function errorAction($request, $exception){
        switch ($exception->getCode()){
            case 404:
                return $this->render('Error/error-404.html.twig', array('request' => $request));
                break;
            default:
                return $this->render('Error/error.html.twig', array(
                    'request' => $request,
                    'exception' => $exception
                ));

        }
    }
}