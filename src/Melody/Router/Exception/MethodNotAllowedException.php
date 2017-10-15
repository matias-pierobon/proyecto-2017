<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 8:04 PM
 */

namespace Melody\Router\Exception;


use Melody\Http\Response;

class MethodNotAllowedException extends RouterException
{
    /**
     * @var array
     */
    protected $allowedMethods = array();

    /**
     * @param array $allowedMethods
     * @param mixed $message
     * @param \Exception $previous
     */
    public function __construct($allowedMethods, $message = null, $previous = null)
    {
        $this->allowedMethods = array_map('strtoupper', $allowedMethods);
        parent::__construct($message, Response::HTTP_METHOD_NOT_ALLOWED, $previous);
    }

    /**
     * Gets the allowed HTTP methods.
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return $this->allowedMethods;
    }
}