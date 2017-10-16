<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 12:04 AM
 */

namespace Hospital\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="roles")
 */
class Role {
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
     * Many Roles have Many Permissions.
     * @var Permission[]
     * @ORM\ManyToMany(targetEntity="Permission", mappedBy="roles")
     */
    private $permissions;

    /**
     * Many Roles have Many Users.
     * @var User[]
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    private $users;


    public function __toString()
    {
        return $this->name;
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function isGranted($attribute){
        foreach ($this->permissions as $permission) {
            if($permission->getName() == $attribute)
                return true;
        }

        return false;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permissions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Role
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
     * Add permission
     *
     * @param \Hospital\Model\Permission $permission
     *
     * @return Role
     */
    public function addPermission(\Hospital\Model\Permission $permission)
    {
        $this->permissions[] = $permission;

        return $this;
    }

    /**
     * Remove permission
     *
     * @param \Hospital\Model\Permission $permission
     */
    public function removePermission(\Hospital\Model\Permission $permission)
    {
        $this->permissions->removeElement($permission);
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Add user
     *
     * @param \Hospital\Model\User $user
     *
     * @return Role
     */
    public function addUser(\Hospital\Model\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Hospital\Model\User $user
     */
    public function removeUser(\Hospital\Model\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
