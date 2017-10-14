<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 11:25 PM
 */

namespace Hospital;


use Melody\Application\RouterBuilder\RouterBuilder;
use Melody\Application\RouterBuilder\LazyDefinition;

class Router
{
    /* @param RouterBuilder $builder */
    public function register($builder){
        $this->registerFrontend($builder->define('/'));
        $this->registerAdmin($builder->define('/admin'));
    }

    /* @param LazyDefinition $definition */
    public function registerAdmin($definition){
        $this->crud($definition->define('/user'), 'User');
        $this->crud($definition->define('/role'), 'Role');
        $this->crud($definition->define('/permission'), 'Permission');
        $this->crud($definition->define('/patient'), 'Patient');
    }

    /* @param LazyDefinition $definition */
    public function registerFrontend($definition){
        $definition
            ->setController('Frontend')
            ->define('/login')
                ->get('signIn')->end()
                ->post('login')->end()
            ->end()
            ->get('index');
    }

    /* @param LazyDefinition $definition */
    protected function crud($definition, $controller){
        $definition
            ->setController($controller)
            ->define('/')
                ->define('(?P<id>\d+)')
                    ->define('/edit')
                        ->get('edit')->end()
                        ->post('update')->end()
                    ->end()
                    ->define('/delete')
                        ->get('delete')->end()
                    ->end()
                    ->get('show')->end()
                ->end()
                ->define('new')
                    ->get('new')->end()
                    ->post('create')->end()
                ->end()
                ->get('index');
    }
}