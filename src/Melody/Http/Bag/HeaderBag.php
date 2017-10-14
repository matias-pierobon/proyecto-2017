<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 12:54 AM
 */

namespace Melody\Http\Bag;


class HeaderBag extends Bag
{
    /* @param array $headers */
    public function __construct($headers = array())
    {
        parent::__construct();
        $this->add($headers);
    }

    /* @return string */
    public function __toString()
    {
        if (!$headers = $this->all()) {
            return '';
        }
        ksort($headers);
        $max = max(array_map('strlen', array_keys($headers))) + 1;
        $content = '';
        foreach ($headers as $name => $values) {
            $name = ucwords($name, '-');
            foreach ($values as $value) {
                $content .= sprintf("%-{$max}s %s\r\n", $name.':', $value);
            }
        }
        return $content;
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param bool   $first
     *
     * @return string|array
     */
    public function get($key, $default = null, $first = true)
    {
        $key = str_replace('_', '-', strtolower($key));
        $headers = $this->all();
        if (!array_key_exists($key, $headers)) {
            if (null === $default) {
                return $first ? null : array();
            }
            return $first ? $default : array($default);
        }
        if ($first) {
            return count($headers[$key]) ? $headers[$key][0] : $default;
        }
        return $headers[$key];
    }

    /**
     * @param string       $key
     * @param string|array $values
     * @param bool         $replace
     */
    public function set($key, $values, $replace = true)
    {
        $key = str_replace('_', '-', strtolower($key));
        $values = array_values((array) $values);
        $headers = $this->all();
        if (true === $replace || !isset($headers[$key])) {
            parent::set($key, $values);
        } else {
            parent::set($key, array_merge($headers[$key], $values));
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return parent::has(str_replace('_', '-', strtolower($key)));
    }

    /**
     * Returns true if the given HTTP header contains the given value.
     *
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function contains($key, $value)
    {
        return in_array($value, $this->get($key, null, false));
    }

    /* @param string $key */
    public function remove($key)
    {
        $key = str_replace('_', '-', strtolower($key));
        parent::remove($key);
    }




}