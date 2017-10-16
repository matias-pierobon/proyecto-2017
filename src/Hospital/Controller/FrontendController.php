<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 8:08 PM
 */

namespace Hospital\Controller;


use Melody\Application\Controller\Controller;

class FrontendController extends Controller
{
    public function indexAction($request)
    {
        return $this->render('Frontend/index.html.twig');
    }
}