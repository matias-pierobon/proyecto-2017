<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:53 PM
 */

namespace Melody\Application\Controller;


use Melody\Http\Response;

interface RenderControllerInterface
{
    /**
     * @param string $template
     * @param array $context
     * @param Response|null $response
     *
     * @return Response
     */
    public function render($template, $context = array(), $response = null);

    /* @return \Twig_Environment */
    public function getTwig();
}