<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 5:13 PM
 */

namespace Melody\Collection;

use SplObjectStorage;

class Set extends Collection
{
    /* @var SplObjectStorage $elements*/
    private $elements;

    public function __construct()
    {
        $this->elements = new SplObjectStorage();
    }

    public function add($element)
    {
        $this->elements->attach($element);
        return $element;
    }

    public function contains($element)
    {
        return $this->elements->contains($element);
    }
}