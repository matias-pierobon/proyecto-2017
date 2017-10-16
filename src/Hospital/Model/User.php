<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 4:18 PM
 */

namespace Hospital\Model;
use Doctrine\ORM\Mapping as ORM;
use Melody\Application\Security\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
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
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * One User has One Person.
     * @var Person
     * @ORM\OneToOne(targetEntity="Person", inversedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * Many Users have Many Roles.
     * @var Role[]
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles")
     */
    private $roles;


    public function isEnabled()
    {
        return $this->enabled;
    }

    public function __toString()
    {
        return $this->username;
    }

    public function setRawPassword($password)
    {
        $this->setPassword(password_hash($password, PASSWORD_BCRYPT));
    }

    public function setEmail($email)
    {
        $this->getPerson()->setEmail($email);
    }

    public function setFirstName($firstName)
    {
        $this->getPerson()->setFirstName($firstName);
    }

    public function getFirstName()
    {
        return $this->getPerson()->getFirstName();
    }

    public function setLastName($lastName)
    {
        $this->getPerson()->setLastName($lastName);
    }

    public function getLastName()
    {
        return $this->getPerson()->getLastName();
    }

    /**
     * {@inheritdoc}
     */
    public function isGranted($attribute)
    {
        foreach ($this->roles as $role) {
            if($role->isGranted($attribute))
                return true;
        }

        return false;
    }

    public function getEmail()
    {
        return $this->getPerson()->getEmail();
    }

    public function getFullName()
    {
        return $this->getPerson()->getFullName();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set person
     *
     * @param \Hospital\Model\Person $person
     *
     * @return User
     */
    public function setPerson(\Hospital\Model\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Hospital\Model\Person
     */
    public function getPerson()
    {
        if(!$this->person)
            $this->setPerson(new Person());

        return $this->person;
    }

    /**
     * Add role
     *
     * @param \Hospital\Model\Role $role
     *
     * @return User
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
