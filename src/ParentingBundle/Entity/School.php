<?php

namespace ParentingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="school")
 * @ORM\Entity(repositoryClass="ParentingBundle\Repository\SchoolRepository")
 */
class School
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="schoolname", type="string", length=255)
     */
    private $schoolname;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="Xschool", type="float")
     */
    private $Xschool;
    /**
     * @var int
     *
     * @ORM\Column(name="Yschool", type="float")
     */
    private $Yschool;



    /**
     * @var int
     *
     * @ORM\Column(name="schoolphone", type="integer")
     */
    private $schoolphone;

    /**
     * @var int
     *
     * @ORM\Column(name="schoolmail", type="string")
     */
    private $mail;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set schoolname
     *
     * @param string $schoolname
     *
     * @return School
     */
    public function setSchoolname($schoolname)
    {
        $this->schoolname = $schoolname;

        return $this;
    }
    /**
     * Get schoolname
     *
     * @return string
     */
    public function getSchoolname()
    {
        return $this->schoolname;
    }
    /**
     * Set address
     *
     * @param string $address
     *
     * @return School
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
     * Set schoolphone
     *
     * @param integer $schoolphone
     *
     * @return School
     */
    public function setSchoolphone($schoolphone)
    {
        $this->schoolphone = $schoolphone;

        return $this;
    }

    /**
     * Get schoolphone
     *
     * @return int
     */
    public function getSchoolphone()
    {
        return $this->schoolphone;
    }


    /**
     * Set xschool
     *
     * @param integer $xschool
     *
     * @return School
     */
    public function setXschool($xschool)
    {
        $this->Xschool = $xschool;

        return $this;
    }

    /**
     * Get xschool
     *
     * @return integer
     */
    public function getXschool()
    {
        return $this->Xschool;
    }

    /**
     * Set yschool
     *
     * @param integer $yschool
     *
     * @return School
     */
    public function setYschool($yschool)
    {
        $this->Yschool = $yschool;

        return $this;
    }

    /**
     * Get yschool
     *
     * @return integer
     */
    public function getYschool()
    {
        return $this->Yschool;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return School
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }
}
