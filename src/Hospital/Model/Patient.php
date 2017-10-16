<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 12:08 AM
 */

namespace Hospital\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="patients")
 */
class Patient
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
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(type="string", length=140, nullable=true)
     */
    private $phone;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sex;

    /**
     * @var int
     * @ORM\Column(type="integer", unique=true)
     */
    private $dni;

    /**
     * Many Patients have One DNI Type.
     * DniType
     * @ORM\ManyToOne(targetEntity="DniType", inversedBy="patients")
     * @ORM\JoinColumn(name="dni_type_id", referencedColumnName="id")
     */
    private $dniType;

    /**
     * Many Patients have One Medical Insurance.
     * @var MedicalInsurance|null
     * @ORM\ManyToOne(targetEntity="MedicalInsurance", inversedBy="patients")
     * @ORM\JoinColumn(name="insurance_id", referencedColumnName="id")
     */
    private $medicalInsurance;

    /**
     * Many Patients have One Demographic Data.
     * @var DemographicData|null
     * @ORM\ManyToOne(targetEntity="DemographicData", inversedBy="patients")
     * @ORM\JoinColumn(name="demographic_id", referencedColumnName="id")
     */
    private $demographicData;

    /**
     * One Patient has One Person.
     * @var Person
     * @ORM\OneToOne(targetEntity="Person", cascade={"persist"})
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;


    public function __toString()
    {
        return $this->getFullName();
    }

    public function getFullName()
    {
        return $this->getPerson()->getFullName();
    }

    public function getSexText()
    {
        return $this->sex ? 'Masculino' : 'Femenino';
    }

    public function setEmail($email)
    {
        $this->getPerson()->setEmail($email);
    }

    public function getEmail()
    {
        return $this->getPerson()->getEmail();
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Patient
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Patient
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Patient
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set sex
     *
     * @param boolean $sex
     *
     * @return Patient
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return boolean
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     *
     * @return Patient
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return integer
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set dniType
     *
     * @param \Hospital\Model\DniType $dniType
     *
     * @return Patient
     */
    public function setDniType(\Hospital\Model\DniType $dniType = null)
    {
        $this->dniType = $dniType;

        return $this;
    }

    /**
     * Get dniType
     *
     * @return \Hospital\Model\DniType
     */
    public function getDniType()
    {
        return $this->dniType;
    }

    /**
     * Set medicalInsurance
     *
     * @param \Hospital\Model\MedicalInsurance $medicalInsurance
     *
     * @return Patient
     */
    public function setMedicalInsurance(\Hospital\Model\MedicalInsurance $medicalInsurance = null)
    {
        $this->medicalInsurance = $medicalInsurance;

        return $this;
    }

    /**
     * Get medicalInsurance
     *
     * @return \Hospital\Model\MedicalInsurance
     */
    public function getMedicalInsurance()
    {
        return $this->medicalInsurance;
    }

    /**
     * Set demographicData
     *
     * @param \Hospital\Model\DemographicData $demographicData
     *
     * @return Patient
     */
    public function setDemographicData(\Hospital\Model\DemographicData $demographicData = null)
    {
        $this->demographicData = $demographicData;

        return $this;
    }

    /**
     * Get demographicData
     *
     * @return \Hospital\Model\DemographicData
     */
    public function getDemographicData()
    {
        return $this->demographicData;
    }

    /**
     * Set person
     *
     * @param \Hospital\Model\Person $person
     *
     * @return Patient
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
}
