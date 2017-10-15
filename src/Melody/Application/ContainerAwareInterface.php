<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 12:43 PM
 */

namespace Melody\Application;


interface ContainerAwareInterface
{
    /**
     * @param Container $container
     */
    public function setContainer($container = null);

    /**
     * @return Container
     */
    public function getContainer();
}