<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 3:37 PM
 */

namespace Hospital\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Site
 * @package Hospital\Model
 * @ORM\Entity(repositoryClass="Hospital\Repository\SiteRepository")
 * @ORM\Table(name="site")
 */
class Site
{

    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var
     * @ORM\Column(type="string", length=140)
     */
    private $title;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var
     * @ORM\Column(type="string", length=255)
     */
    private $contact;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $maxElements;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return int
     */
    public function getMaxElements()
    {
        return $this->maxElements;
    }

    /**
     * @param int $maxElements
     */
    public function setMaxElements($maxElements)
    {
        $this->maxElements = $maxElements;
    }

}