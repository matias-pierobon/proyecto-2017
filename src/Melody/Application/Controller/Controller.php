<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:38 PM
 */

namespace Melody\Application\Controller;


use Melody\Application\Exception\NotFoundException;
use Melody\Http\RedirectResponse;
use Melody\Http\Request;

abstract class Controller implements DoctrineControllerInterface, RenderControllerInterface
{
    use ContainerControllerTrait, DoctrineControllerTrait, RenderControllerTrait, SecurityContainerTrait;

    protected function redirect($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }

    protected function createNotFoundException($message = 'Not Found', \Exception $previous = null)
    {
        return new NotFoundException($message, $previous);
    }

    /* @return Request */
    protected function getRequest(){
        return $this->get('request');
    }
}