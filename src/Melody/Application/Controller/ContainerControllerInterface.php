<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:54 PM
 */

namespace Melody\Application\Controller;


use Melody\Application\ContainerAwareInterface;

interface ContainerControllerInterface extends ContainerAwareInterface
{
    /**
     * @param string $service
     * @return mixed
     */
    function get($service);

    /**
     * @param string $name
     * @return mixed
     */
    function getParameter($name);
}