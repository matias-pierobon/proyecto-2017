<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 9:30 PM
 */

namespace Melody\Application\RouterBuilder;


abstract class AbstractDefinition {


    public function define($pattern){
        return new LazyDefinition($this, $pattern);
    }

    public abstract function end();

    /* @return RouterBuilder */
    public abstract function getBuilder();

    /* @return string */
    public abstract function getPattern();

    public abstract function getController();
}