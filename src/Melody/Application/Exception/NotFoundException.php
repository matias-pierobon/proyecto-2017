<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 4:04 AM
 */

namespace Melody\Application\Exception;


class NotFoundException extends HttpException
{
    public function __construct($message = null, \Exception $previous = null)
    {
        parent::__construct(404, $message, $previous);
    }
}