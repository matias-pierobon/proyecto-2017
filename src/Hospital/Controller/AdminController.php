<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 10:08 PM
 */

namespace Hospital\Controller;


use Melody\Application\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction($request)
    {
        $this->denyAccessUnlessGranted('admin_dashboard');
        return $this->render('Admin/index.html.twig');
    }
}