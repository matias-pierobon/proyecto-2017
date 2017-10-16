<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 3:23 AM
 */

namespace Melody\Http\Session;


class FlashBag extends AttributeBag
{
    public function getName()
    {
        return 'flashes';
    }

    public function set($type, $messages)
    {
        parent::set($type, (array) $messages);
    }

    public function peekAll(){
        return parent::all();
    }

    public function all()
    {
        $return = $this->peekAll();
        $this->elements = array();
        return $return;
    }

    public function addMessage($type, $message)
    {
        if (!$this->has($type))
            $this->set($type, array());

        $this->elements[$type][] = $message;
    }

    public function get($type, $default = array())
    {
        $result = $this->peek($type, $default);
        $this->remove($type);
        return $result;
    }

    public function peek($type, $default = array())
    {
        return parent::get($type, $default);
    }

    public function clear()
    {
        return $this->all();
    }
}