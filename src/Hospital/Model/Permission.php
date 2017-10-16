<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 12:06 AM
 */

namespace Hospital\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="permissions")
 */
class Permission{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=140, unique=true)
     */
    private $name;

    /**
     * Many Permissions have Many Roles.
     * @var Role[]
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="permissions", cascade={"persist"})
     * @ORM\JoinTable(name="permissions_roles")
     */
    private $roles;


    public function __toString()
    {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Permission
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add role
     *
     * @param \Hospital\Model\Role $role
     *
     * @return Permission
     */
    public function addRole(\Hospital\Model\Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \Hospital\Model\Role $role
     */
    public function removeRole(\Hospital\Model\Role $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
