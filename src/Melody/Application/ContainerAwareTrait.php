<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 12:38 PM
 */

namespace Melody\Application;


trait ContainerAwareTrait
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function setContainer($container = null)
    {
        $this->container = $container;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}