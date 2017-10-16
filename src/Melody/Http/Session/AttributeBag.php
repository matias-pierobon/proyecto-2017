<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 3:21 AM
 */

namespace Melody\Http\Session;


use Melody\Http\Bag\Bag;

class AttributeBag extends Bag
{
    public function __construct()
    {
        parent::__construct(array());
    }

    public function initialize(array &$attributes)
    {
        $this->elements = &$attributes;
    }

    public function getName()
    {
        return 'attributes';
    }

    public function clear()
    {
        $return = $this->elements;
        $this->elements = array();
        return $return;
    }
}