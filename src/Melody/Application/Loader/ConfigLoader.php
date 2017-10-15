<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 3:59 PM
 */

namespace Melody\Application\Loader;


use Melody\Application\Container;

class ConfigLoader extends Loader
{

    /**
     * @param Container $container
     */
    public function load($container)
    {
        $filename = $container->getParameter('paths.config') . '/config.json';
        $content = file_get_contents($filename);
        $config = json_decode($content, true);

        $this->loadParameters($container, $config['parameters']);
    }

    /**
     * @param Container $container
     * @param array $parameters
     */
    private function loadParameters($container, $parameters = array()){
        foreach ($parameters as $name => $value) {
           $container->setParameter($name, $value);
        }
    }

}