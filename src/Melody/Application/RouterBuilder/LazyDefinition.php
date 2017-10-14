<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 9:22 PM
 */

namespace Melody\Application\RouterBuilder;


class LazyDefinition extends Definition
{

    public function get($action){
        return $this->create($action, 'get');
    }

    /* @return ConcreteDefinition */
    public function post($action){
        return $this->create($action, 'post');
    }

    /* @return ConcreteDefinition */
    public function put($action){
        return $this->create($action, 'put');
    }

    /* @return ConcreteDefinition */
    public function delete($action){
        return $this->create($action, 'delete');
    }

    /* @return ConcreteDefinition */
    private function create($action, $method){
        return new ConcreteDefinition($this, $action, $method);
    }

}