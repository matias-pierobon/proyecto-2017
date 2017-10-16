<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 2:08 PM
 */

namespace Melody\Application\Controller;


use Doctrine\ORM\EntityRepository;
use Melody\Http\Request;
use Melody\Http\Response;

abstract class CrudController extends Controller
{

    /* @return string */
    public abstract function getEntityName();

    public abstract function createEntity();

    /* @return string */
    public function getViewPath(){
        return ucfirst(strtolower($this->getEntityName()));
    }

    /* @return string */
    public function getRoutePrefix(){
        return "/" . strtolower($this->getEntityName());
    }

    /* @return EntityRepository */
    public function getEntityRepository(){
        return $this->getRepository($this->getEntityName());
    }

    public function getViewFor($action){
        return $this->getViewPath() . "/" . $action . ".html.twig";
    }

    public function getEntityById($id){
        return $this->getEntityRepository()->find($id);
    }

    protected function redirectTo($uri){
        $url = $this->getRoutePrefix() . '/' . $uri;
        return $this->redirect($url);
    }

    /**
     * @param Request $request
     * @param $entity
     */
    public function processRequest($request, $entity){
        foreach ($request->getRequest() as $name => $value) {
            try {
                $selector = "set" . ucfirst($name);
                $entity->$selector($value);
            }catch (\Exception $e){
                continue;
            }
        }
    }

    /**
     * @param Request $request
     * @param $entity
     */
    public function processNewRequest($request, $entity){
        $this->processRequest($request, $entity);
    }

    /**
     * @param Request $request
     * @param $entity
     */
    public function processEditRequest($request, $entity){
        $this->processRequest($request, $entity);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getEntityByRequest($request){
        return $this->getEntityById($request->getParameters()->get('id'));
    }

    /* @return array */
    public function getAllEntities(){
        return $this->getEntityRepository()->findAll();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction($request){
        $entities = $this->getAllEntities();
        return $this->render(
            $this->getViewFor('index'),
            array($this->twigEntitiesVar() => $entities)
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function newAction($request){
        return $this->render($this->getViewFor('new'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction($request){
        $entity = $this->createEntity();

        $this->processNewRequest($request, $entity);

        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirectTo('/' . $entity->getId());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function showAction($request){
        $entity = $this->getEntityByRequest($request);

        return $this->render(
            $this->getViewFor('show'),
            array($this->twigEntityVar() => $entity)
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editAction($request){
        $entity = $this->getEntityByRequest($request);

        return $this->render(
            $this->getViewFor('edit'),
            array($this->twigEntityVar() => $entity)
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateAction($request){
        $entity = $this->getEntityByRequest($request);
        $this->processEditRequest($request, $entity);

        return $this->redirectTo('/' . $entity->getId());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteAction($request){
        $entity = $this->getEntityByRequest($request);
        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        return $this->redirectTo('/');
    }

    public function twigEntityVar()
    {
        return 'entity';
    }

    public function twigEntitiesVar()
    {
        return 'entities';
    }
}