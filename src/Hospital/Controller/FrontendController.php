<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 8:08 PM
 */

namespace Hospital\Controller;


use Melody\Application\Controller\Controller;
use Melody\Http\Request;
use Melody\Http\Response;

class FrontendController extends Controller
{
    public function indexAction($request)
    {
        return $this->render('Frontend/index.html.twig');
    }

    public function signInAction($request)
    {
        return $this->render('Frontend/login.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function loginAction($request){
        $username = $request->getRequest()->get('username');
        $password = $request->getRequest()->get('password');

        return $this->redirect('/admin');
    }
}