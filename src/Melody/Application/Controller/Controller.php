<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:38 PM
 */

namespace Melody\Application\Controller;


use Melody\Http\RedirectResponse;

abstract class Controller implements DoctrineControllerInterface, RenderControllerInterface
{
    use ContainerControllerTrait, DoctrineControllerTrait, RenderControllerTrait;

    protected function redirect($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }
}