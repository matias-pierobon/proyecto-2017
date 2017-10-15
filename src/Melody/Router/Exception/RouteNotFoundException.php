<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 8:09 PM
 */

namespace Melody\Router\Exception;


use Melody\Http\Response;
use Throwable;

class RouteNotFoundException extends RouterException
{
    public function __construct($message = "", $previous = null)
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND, $previous);
    }
}