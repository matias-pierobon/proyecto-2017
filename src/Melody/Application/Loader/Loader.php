<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 7:32 PM
 */

namespace Melody\Application\Loader;

use Melody\Application\Container;

interface Loader
{
    /* @param Container $container */
    public function load($container);

}