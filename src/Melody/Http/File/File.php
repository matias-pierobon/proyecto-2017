<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 12:17 PM
 */

namespace Melody\Http\File;


use Melody\Http\File\Exception\FileException;
use Melody\Http\File\Exception\FileNotFoundException;

class File extends \SplFileInfo
{
    /**
     * @param string $path
     * @param bool $check
     *
     * @throws FileNotFoundException
     */
    public function __construct($path, $check = true)
    {
        if ($check && !is_file($path)) {
            throw new FileNotFoundException($path);
        }
        parent::__construct($path);
    }

    /**
     * @param string $directory
     * @param string $name
     *
     * @return self
     *
     * @throws FileException
     */
    public function move($directory, $name = null)
    {
        $target = $this->getTargetFile($directory, $name);
        if (!@rename($this->getPathname(), $target)) {
            $error = error_get_last();
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error['message'])));
        }
        @chmod($target, 0666 & ~umask());
        return $target;
    }

    protected function getTargetFile($directory, $name = null)
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory', $directory));
        }
        $target = rtrim($directory, '/\\').DIRECTORY_SEPARATOR.(null === $name ? $this->getBasename() : $this->getName($name));
        return new self($target, false);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function getName($name)
    {
        $originalName = str_replace('\\', '/', $name);
        $pos = strrpos($originalName, '/');
        $originalName = false === $pos ? $originalName : substr($originalName, $pos + 1);
        return $originalName;
    }


}