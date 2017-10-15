<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 12:42 AM
 */

namespace Melody\Http\Bag;

use IteratorAggregate;
use Countable;
use ArrayIterator;

class Bag implements IteratorAggregate, Countable
{
    /* @var array */
    protected $elements;

    /* @param array $elements */
    public function __construct($elements = array())
    {
        $this->elements = $elements;
    }

    /* @return array  */
    public function all()
    {
        return $this->elements;
    }

    /* @return array */
    public function keys()
    {
        return array_keys($this->all());
    }

    /* @param array $elements */
    public function add($elements = array())
    {
        foreach ($elements as $key => $element) {
            $this->set($key, $element);
        }
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->elements) ? $this->elements[$key] : $default;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->elements);
    }

    /* @param string $key */
    public function remove($key)
    {
        unset($this->elements[$key]);
    }

    /*  @return ArrayIterator */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /* @return int */
    public function count()
    {
        return count($this->elements);
    }


}