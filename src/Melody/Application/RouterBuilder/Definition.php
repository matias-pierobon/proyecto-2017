<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 9:18 PM
 */

namespace Melody\Application\RouterBuilder;


abstract class Definition extends AbstractDefinition {

    protected $controller;
    protected $pattern;

    /* @var AbstractDefinition $parent */
    protected $parent;

    public function __construct($parent, $pattern, $controller=null){
        $this->parent = $parent;
        $this->pattern = $pattern;
        $this->controller = $controller;
    }

    public  function getBuilder()
    {
        return $this->getParent()->getBuilder();
    }

    public  function getPattern()
    {
        return $this->getParentPattern() . $this->pattern;
    }

    /* @return string || null */
    public function getController(){
        return $this->controller || $this->getParentController();
    }

    /* @return self */
    public function setController($controller){
        $this->controller = $controller;
        return $this;
    }

    /* @return AbstractDefinition */
    public function getParent(){
        return $this->parent;
    }

    /* @return string || null */
    public function getParentController(){
        return $this->getParent()->getController();
    }

    /* @return string */
    public function getParentPattern(){
        return $this->getParent()->getPattern();
    }

    /* @return LazyDefinition */
    public function end(){
        return $this->getParent();
    }
}