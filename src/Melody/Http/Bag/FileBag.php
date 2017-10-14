<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/14/17
 * Time: 1:17 AM
 */

namespace Melody\Http\Bag;


class FileBag extends Bag
{
    private static $fileKeys = array('error', 'name', 'size', 'tmp_name', 'type');

    public function __construct($files = array())
    {
        parent::__construct();
        $this->add($files);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        if (!is_array($value) && !$value instanceof UploadedFile) {
            throw new \InvalidArgumentException('An uploaded file must be an array or an instance of UploadedFile.');
        }
        parent::set($key, $this->convertFileInformation($value));
    }

    /**
     * @param array|UploadedFile $file
     *
     * @return UploadedFile[]|UploadedFile|null
     */
    protected function convertFileInformation($file)
    {
        if ($file instanceof UploadedFile) {
            return $file;
        }
        $file = $this->fixPhpFilesArray($file);
        if (is_array($file)) {
            $keys = array_keys($file);
            sort($keys);
            if ($keys == self::$fileKeys) {
                if (UPLOAD_ERR_NO_FILE == $file['error']) {
                    $file = null;
                } else {
                    $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['size'], $file['error']);
                }
            } else {
                $file = array_filter(array_map(array($this, 'convertFileInformation'), $file));
            }
        }
        return $file;
    }

    /**
     * Fixes a malformed PHP $_FILES array.
     *
     * @param array $data
     *
     * @return array
     */
    protected function fixPhpFilesArray($data)
    {
        if (!is_array($data)) {
            return $data;
        }
        $keys = array_keys($data);
        sort($keys);
        if (self::$fileKeys != $keys || !isset($data['name']) || !is_array($data['name'])) {
            return $data;
        }
        $files = $data;
        foreach (self::$fileKeys as $k) {
            unset($files[$k]);
        }
        foreach ($data['name'] as $key => $name) {
            $files[$key] = $this->fixPhpFilesArray(array(
                'error' => $data['error'][$key],
                'name' => $name,
                'type' => $data['type'][$key],
                'tmp_name' => $data['tmp_name'][$key],
                'size' => $data['size'][$key],
            ));
        }
        return $files;
    }
}