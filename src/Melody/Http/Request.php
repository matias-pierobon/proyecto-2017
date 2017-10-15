<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 12:28 AM
 */

namespace Melody\Http;


use Melody\Http\Bag\Bag;
use Melody\Http\Bag\FileBag;
use Melody\Http\Bag\HeaderBag;
use Melody\Http\Bag\ServerBag;

class Request {

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var string[]
     */
    protected static $trustedProxies = array();

    /* @var Bag $attributes */
    protected $attributes;

    /* @var Bag $request */
    protected $request;

    /* @var Bag $query */
    protected $query;

    /* @var ServerBag $server */
    protected $server;

    /* @var FileBag $files */
    protected $files;

    /* @var Bag $cookies */
    protected $cookies;

    /* @var HeaderBag $headers */
    protected $headers;

    /**
     * @var string
     */
    protected $content;

    protected $session;

    /**
     * @param array           $query      The GET parameters
     * @param array           $request    The POST parameters
     * @param array           $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array           $cookies    The COOKIE parameters
     * @param array           $files      The FILES parameters
     * @param array           $server     The SERVER parameters
     * @param string|resource $content    The raw body data
     */
    public function __construct($query = array(), $request = array(), $attributes = array(), $cookies = array(), $files = array(), $server = array(), $content = null)
    {
        $this->request = new Bag($request);
        $this->query = new Bag($query);
        $this->attributes = new Bag($attributes);
        $this->cookies = new Bag($cookies);
        $this->files = new FileBag($files);
        $this->server = new ServerBag($server);
        $this->headers = new HeaderBag($this->server->getHeaders());
        $this->content = $content;
    }

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return self
     */
    public static function createFromGlobals()
    {
        return new self($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);
    }

    public function getMethod()
    {
        return strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
    }

    /**
     * Gets the request's scheme.
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->isSecure() ? 'https' : 'http';
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        $https = $this->server->get('HTTPS');
        return !empty($https) && 'off' !== strtolower($https);
    }

    public function getRequestUri()
    {
        return $requestUri = $this->server->get('REQUEST_URI', '');

    }

    public function getPathInfo()
    {
        if ($this->server->has('PATH_INFO')) {
            return $this->server->get('PATH_INFO', '/');
        }

        if (null === ($requestUri = $this->getRequestUri())) {
            return '/';
        }

        // Remove the query string from REQUEST_URI
        if ($pos = strpos($requestUri, '?')) {
            $requestUri = substr($requestUri, 0, $pos);
        }

        return (string) $requestUri;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return Bag
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Bag
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return Bag
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return FileBag
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return HeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return ServerBag
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

}