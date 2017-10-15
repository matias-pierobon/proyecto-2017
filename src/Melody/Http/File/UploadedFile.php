<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 12:21 PM
 */

namespace Melody\Http\File;


use Melody\Http\File\Exception\FileException;

class UploadedFile extends File
{
    /**
     * The original name of the uploaded file.
     *
     * @var string
     */
    private $originalName;
    /**
     * The mime type provided by the uploader.
     *
     * @var string
     */
    private $mimeType;
    /**
     * The file size provided by the uploader.
     *
     * @var int|null
     */
    private $size;
    /**
     * The UPLOAD_ERR_XXX constant provided by the uploader.
     *
     * @var int
     */
    private $error;

    /**
     * @param string      $path
     * @param string      $originalName
     * @param string|null $mimeType
     * @param int|null    $size
     * @param int|null    $error
     *
     * @throws FileException         If file_uploads is disabled
     * @throws FileNotFoundException If the file does not exist
     */
    public function __construct($path, $originalName, $mimeType = null, $size = null, $error = null)
    {
        $this->originalName = $this->getName($originalName);
        $this->mimeType = $mimeType ?: 'application/octet-stream';
        $this->size = $size;
        $this->error = $error ?: UPLOAD_ERR_OK;
        parent::__construct($path, UPLOAD_ERR_OK === $this->error);
    }

    public function getClientOriginalName()
    {
        return $this->originalName;
    }

    public function getClientSize()
    {
        return $this->size;
    }

    public function getError()
    {
        return $this->error;
    }

    public function isValid()
    {
        $isOk = UPLOAD_ERR_OK === $this->error;
        return $isOk && is_uploaded_file($this->getPathname());
    }

    /**
     * {@inheritdoc}
     **/
    public function move($directory, $name = null)
    {
        if ($this->isValid()) {

            $target = $this->getTargetFile($directory, $name);
            if (!@move_uploaded_file($this->getPathname(), $target)) {
                $error = error_get_last();
                throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error['message'])));
            }
            @chmod($target, 0666 & ~umask());
            return $target;
        }
        throw new FileException($this->getErrorMessage());
    }

    public static function getMaxFilesize()
    {
        $iniMax = strtolower(ini_get('upload_max_filesize'));
        if ('' === $iniMax) {
            return PHP_INT_MAX;
        }
        $max = ltrim($iniMax, '+');
        if (0 === strpos($max, '0x')) {
            $max = intval($max, 16);
        } elseif (0 === strpos($max, '0')) {
            $max = intval($max, 8);
        } else {
            $max = (int) $max;
        }
        switch (substr($iniMax, -1)) {
            case 't': $max *= 1024;
            // no break
            case 'g': $max *= 1024;
            // no break
            case 'm': $max *= 1024;
            // no break
            case 'k': $max *= 1024;
        }
        return $max;
    }

    public function getErrorMessage()
    {
        static $errors = array(
            UPLOAD_ERR_INI_SIZE => 'The file "%s" exceeds your upload_max_filesize ini directive (limit is %d KiB).',
            UPLOAD_ERR_FORM_SIZE => 'The file "%s" exceeds the upload limit defined in your form.',
            UPLOAD_ERR_PARTIAL => 'The file "%s" was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_CANT_WRITE => 'The file "%s" could not be written on disk.',
            UPLOAD_ERR_NO_TMP_DIR => 'File could not be uploaded: missing temporary directory.',
            UPLOAD_ERR_EXTENSION => 'File upload was stopped by a PHP extension.',
        );
        $errorCode = $this->error;
        $maxFilesize = UPLOAD_ERR_INI_SIZE === $errorCode ? self::getMaxFilesize() / 1024 : 0;
        $message = isset($errors[$errorCode]) ? $errors[$errorCode] : 'The file "%s" was not uploaded due to an unknown error.';
        return sprintf($message, $this->getClientOriginalName(), $maxFilesize);
    }
}