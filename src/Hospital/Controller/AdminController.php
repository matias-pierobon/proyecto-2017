<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 10:08 PM
 */

namespace Hospital\Controller;


use Hospital\Model\Site;
use Melody\Application\Controller\Controller;
use Melody\Http\Request;
use Melody\Http\Response;

class AdminController extends Controller
{
    public function indexAction($request)
    {
        $this->denyAccessUnlessGranted('admin_dashboard');
        return $this->render('Admin/index.html.twig');
    }

    public function editSieAction($request)
    {
        $this->denyAccessUnlessGranted('config_show');
        $site = $this->getRepository(Site::class)->getSite();

        return $this->render('Admin/site.html.twig', array('site' => $site));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateSiteAction($request)
    {
        $this->denyAccessUnlessGranted('config_update');
        /* @var Site $site */
        $site = $this->getRepository(Site::class)->getSite();

        $site->setTitle($request->getRequest()->get('title', $site->getTitle()));
        $site->setContact($request->getRequest()->get('contact', $site->getContact()));
        $site->setDescription($request->getRequest()->get('description', $site->getDescription()));
        $site->setMaxElements($request->getRequest()->get('maxElements', $site->getMaxElements()));

        $enabled = $request->getRequest()->get('enabled', 'off') == 'on';
        $site->setEnabled($enabled);

        $this->getEntityManager()->flush();

        return $this->redirect('/admin/config');
    }
}