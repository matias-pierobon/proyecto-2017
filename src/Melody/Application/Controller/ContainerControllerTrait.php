<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 1:54 PM
 */

namespace Melody\Application\Controller;


use Melody\Application\ContainerAwareTrait;

trait ContainerControllerTrait
{
    use ContainerAwareTrait;

    /**
     * @param string $service
     * @return mixed
     */
    public function get($service)
    {
        return $this->getContainer()->get($service);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter($name)
    {
        return $this->getContainer()->getParameter($name);
    }
}