<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 9:30 PM
 */

namespace Melody\Application\RouterBuilder;


class NullDefinition extends AbstractDefinition
{
    /* @var RouterBuilder $builder */
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /* @return RouterBuilder */
    public function end(){
        return $this->builder;
    }

    /**
     * @return RouterBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    public function getPattern()
    {
        return "";
    }

    public function getController()
    {
        return null;
    }

}