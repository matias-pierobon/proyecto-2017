<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/16/17
 * Time: 12:21 AM
 */

namespace Hospital\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="demographic_data")
 */
class DemographicData
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $refrigerator;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $electricity;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pet;

    /**
     * Many DemographicData have One HouseType.
     * @var HouseType|null
     * @ORM\ManyToOne(targetEntity="HouseType")
     * @ORM\JoinColumn(name="house_type_id", referencedColumnName="id")
     */
    private $houseType;

    /**
     * Many DemographicData have One WaterType.
     * @var WaterType|null
     * @ORM\ManyToOne(targetEntity="WaterType")
     * @ORM\JoinColumn(name="water_type_id", referencedColumnName="id")
     */
    private $waterType;

    /**
     * Many DemographicData have One HeatingType.
     * @var HeatingType|null
     * @ORM\ManyToOne(targetEntity="HeatingType")
     * @ORM\JoinColumn(name="heating_type_id", referencedColumnName="id")
     */
    private $heatingType;

    /**
     * One DemographicData has Many Patients.
     * @var Patient[]
     * @ORM\OneToMany(targetEntity="Patient", mappedBy="demographicData")
     */
    private $patients;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->patients = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set refrigerator
     *
     * @param boolean $refrigerator
     *
     * @return DemographicData
     */
    public function setRefrigerator($refrigerator)
    {
        $this->refrigerator = $refrigerator;

        return $this;
    }

    /**
     * Get refrigerator
     *
     * @return boolean
     */
    public function getRefrigerator()
    {
        return $this->refrigerator;
    }

    /**
     * Set electricity
     *
     * @param boolean $electricity
     *
     * @return DemographicData
     */
    public function setElectricity($electricity)
    {
        $this->electricity = $electricity;

        return $this;
    }

    /**
     * Get electricity
     *
     * @return boolean
     */
    public function getElectricity()
    {
        return $this->electricity;
    }

    /**
     * Set pet
     *
     * @param boolean $pet
     *
     * @return DemographicData
     */
    public function setPet($pet)
    {
        $this->pet = $pet;

        return $this;
    }

    /**
     * Get pet
     *
     * @return boolean
     */
    public function getPet()
    {
        return $this->pet;
    }

    /**
     * Set houseType
     *
     * @param \Hospital\Model\HouseType $houseType
     *
     * @return DemographicData
     */
    public function setHouseType(\Hospital\Model\HouseType $houseType = null)
    {
        $this->houseType = $houseType;

        return $this;
    }

    /**
     * Get houseType
     *
     * @return \Hospital\Model\HouseType
     */
    public function getHouseType()
    {
        return $this->houseType;
    }

    /**
     * Set waterType
     *
     * @param \Hospital\Model\WaterType $waterType
     *
     * @return DemographicData
     */
    public function setWaterType(\Hospital\Model\WaterType $waterType = null)
    {
        $this->waterType = $waterType;

        return $this;
    }

    /**
     * Get waterType
     *
     * @return \Hospital\Model\WaterType
     */
    public function getWaterType()
    {
        return $this->waterType;
    }

    /**
     * Set heatingType
     *
     * @param \Hospital\Model\HeatingType $heatingType
     *
     * @return DemographicData
     */
    public function setHeatingType(\Hospital\Model\HeatingType $heatingType = null)
    {
        $this->heatingType = $heatingType;

        return $this;
    }

    /**
     * Get heatingType
     *
     * @return \Hospital\Model\HeatingType
     */
    public function getHeatingType()
    {
        return $this->heatingType;
    }

    /**
     * Add patient
     *
     * @param \Hospital\Model\Patient $patient
     *
     * @return DemographicData
     */
    public function addPatient(\Hospital\Model\Patient $patient)
    {
        $this->patients[] = $patient;

        return $this;
    }

    /**
     * Remove patient
     *
     * @param \Hospital\Model\Patient $patient
     */
    public function removePatient(\Hospital\Model\Patient $patient)
    {
        $this->patients->removeElement($patient);
    }

    /**
     * Get patients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPatients()
    {
        return $this->patients;
    }
}
