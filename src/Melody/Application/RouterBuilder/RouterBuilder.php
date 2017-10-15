<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 9:11 PM
 */

namespace Melody\Application\RouterBuilder;


use Melody\Router\Router;

class RouterBuilder
{
    private $definitions;

    public function __construct()
    {
        $this->definitions = array();
    }

    public function register($definition){
        $this->definitions[] = $definition;
    }

    /* @return LazyDefinition */
    public function define($pattern){
        return (new NullDefinition($this))->define($pattern);
    }

    /* @param Router $router*/
    public function build($router){
        /* @var ConcreteDefinition $definition */
        foreach ($this->definitions as $definition) {
            $route = $definition->compile();
            $router->add($route);
        }
    }
}