<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 8:08 PM
 */

namespace Hospital\Controller;


use Hospital\Model\Site;
use Hospital\Model\User;
use Melody\Application\Controller\Controller;
use Melody\Application\Exception\HttpException;
use Melody\Http\Request;
use Melody\Http\Response;

class FrontendController extends Controller
{
    public function indexAction($request)
    {
        /* @var Site $site */
        $site = $this->getRepository(Site::class)->getSite();

        if(!$site->isEnabled())
            throw new HttpException(200, "Sitio en mantenimiento");

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

        $em = $this->getEntityManager();
        $repo = $em->getRepository(User::class);
        /* @var User $user */
        $user = $repo->findOneBy(array('username' => $username));

        if(!$user)
            return $this->render('Frontend/login.html.twig', array(
                'error' => 'Usuario no encontrado',
                'username' => $username
            ));
        
        if(false == password_verify($password, $user->getPassword()))
            return $this->render('Frontend/login.html.twig', array(
                'error' => 'Contraseña incorrecta',
                'username' => $username)
            );

        if(!$user->isEnabled())
            return $this->render('Frontend/login.html.twig', array(
                    'error' => 'Usuario deshabilitado',
                    'username' => '')
            );

        $request->getSession()->set('user', $user);

        return $this->redirect('/admin');
    }

    public function logoutAction($request)
    {
        $request->getSession()->set('user', null);

        return $this->redirect('/');
    }
}