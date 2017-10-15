<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:52 PM
 */

namespace Melody\Application\Controller;

use Melody\Http\Response;
use Twig_Environment;

trait RenderControllerTrait
{
    use ContainerControllerTrait;

    /**
     * @param string $template
     * @param array $context
     * @param Response|null $response
     *
     * @return Response
     */
    public function render($template, $context = array(), $response = null){
        if(!$response)
            $response = new Response();

        $response->setContent($this->getTwig()->render($template, $context));

        return $response;
    }

    /* @return Twig_Environment */
    public function getTwig(){
        return $this->get('twig');
    }
}