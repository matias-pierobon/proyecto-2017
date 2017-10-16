<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 4:05 AM
 */

namespace Melody\Application\Exception;


class AccessDeniedException extends HttpException
{
    public function __construct($message = null, \Exception $previous = null)
    {
        parent::__construct(403, $message, $previous);
    }
}