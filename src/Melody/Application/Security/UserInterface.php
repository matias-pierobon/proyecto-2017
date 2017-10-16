<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 4:10 AM
 */

namespace Melody\Application\Security;


interface UserInterface
{
    /* @return string */
    public function getUsername();

    /* @return string */
    public function getPassword();

    /* @return bool */
    public function isEnabled();

    /**
     * @param string $attribute
     * @return bool
     */
    public function isGranted($attribute);
}