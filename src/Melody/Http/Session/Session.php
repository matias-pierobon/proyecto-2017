<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 3:11 AM
 */

namespace Melody\Http\Session;


class Session implements \IteratorAggregate, \Countable {

    private $started;

    /* AttributeBag[] */
    private $bags;

    public function __construct()
    {
        $this->registerBag( new AttributeBag() );
        $this->registerBag( new FlashBag() );
    }

    public function start()
    {
        if ($this->started) {
            return true;
        }
        if (\PHP_SESSION_ACTIVE === session_status()) {
            throw new \RuntimeException('Failed to start the session: already started by PHP.');
        }

        // ok to try and start the session
        if (!session_start()) {
            throw new \RuntimeException('Failed to start the session');
        }

        $this->loadSession();
        return true;
    }

    protected function loadSession(&$session = null)
    {
        if (null === $session) {
            $session = &$_SESSION;
        }
        $bags = $this->bags;

        /* @var AttributeBag $bag*/
        foreach ($bags as $bag) {
            $key = $bag->getName();
            $session[$key] = (isset($session[$key]) && $session[$key])  ? $session[$key] : array();
            $bag->initialize($session[$key]);
        }
        $this->started = true;
    }

    public function getId()
    {
        return session_id();
    }

    public function getName()
    {
        return session_name();
    }

    public function clear()
    {
        /* @var AttributeBag $bag */
        foreach ($this->bags as $bag) {
            $bag->clear();
        }
        // clear out the session
        $_SESSION = array();
        // reconnect the bags to the session
        $this->loadSession();
    }

    public function has($name)
    {
        return $this->getAttributeBag()->has($name);
    }

    public function get($name, $default = null)
    {
        return $this->getAttributeBag()->get($name, $default);
    }

    public function set($name, $value)
    {
        $this->getAttributeBag()->set($name, $value);
    }

    public function all()
    {
        return $this->getAttributeBag()->all();
    }

    public function count()
    {
        return $this->getAttributeBag()->count();
    }

    public function getIterator()
    {
        return $this->getAttributeBag()->getIterator();
    }

    public function registerBag(AttributeBag $bag)
    {
        if ($this->started) {
            throw new \LogicException('Cannot register a bag when the session is already started.');
        }
        $this->bags[$bag->getName()] = $bag;
    }

    /* @return AttributeBag */
    public function getBag($name){
        if (!isset($this->bags[$name])) {
            throw new \InvalidArgumentException(sprintf('The Bag %s is not registered.', $name));
        }

        if (!$this->isStarted() && \PHP_SESSION_ACTIVE === session_status()) {
            $this->loadSession();
        } elseif (!$this->isStarted()) {
            $this->start();
        }

        return $this->bags[$name];
    }

    /* @return FlashBag */
    public function getFlashBag()
    {
        return $this->getBag('flashes');
    }

    /* @return AttributeBag */
    private function getAttributeBag()
    {
        return $this->getBag('attributes');
    }

    public function isStarted()
    {
        return $this->started;
    }


}