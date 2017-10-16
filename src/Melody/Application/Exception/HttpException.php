<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 4:02 AM
 */

namespace Melody\Application\Exception;


class HttpException extends \RuntimeException
{
    private $statusCode;
    public function __construct($statusCode, $message = null, \Exception $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}