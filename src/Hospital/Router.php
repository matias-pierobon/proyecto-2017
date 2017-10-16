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
        $definition
            ->get('index')
            ->setController('Admin');
        $this->crud($definition->define('/user'), 'User');
        $this->crud($definition->define('/patient'), 'Patient');
    }

    /* @param LazyDefinition $definition */
    public function registerFrontend($definition){
        $definition
            ->setController('Frontend')
            ->define('login')
                ->get('signIn')->end()
                ->post('login')->end()
            ->end()
            ->define('logout')
                ->get('logout')->end()
            ->end()
            ->get('index');
    }

    /* @param LazyDefinition $definition */
    protected function crud($definition, $controller){
        $definition->setController($controller);

        $root = $definition->define('/');
        $root->get('index');

        $new = $root->define('new');
        $new->get('new');
        $new->post('create');

        $partial = $root->define("(?P<id>\\d+)");
        $partial->get('show');

        $edit = $partial->define('/edit');
        $edit->get('edit');
        $edit->post('update');

        $delete = $partial->define('/delete');
        $delete->get('delete');

        /*
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
        */
    }
}