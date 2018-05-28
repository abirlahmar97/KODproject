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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float")
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float")
     */
    private $lng;



    /**
     * @var int
     *
     * @ORM\Column(name="schoolphone", type="integer")
     */
    private $phone;

    /**
     * @var float
     *
     * @ORM\Column(name="mail", type="string")
     */
    private $mail;


    /**
     * Get id
     *
     * @return float
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
     * @return School
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
     * Set phone
     *
     * @param integer $phone
     *
     * @return School
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * Set latitude
     *
     * @param float $lat
     *
     * @return School
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set longitude
     *
     * @param float $lng
     *
     * @return School
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
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
