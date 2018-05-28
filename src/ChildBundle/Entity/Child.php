<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Child
 *
 * @ORM\Table(name="child")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\ChildRepository")
 */
class Child
{

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     */
    private $parent;

    /**
     * @ORM\OneToOne(targetEntity="MediaBundle\Entity\Photo", cascade={"persist"})
     */
    private $photo;

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
     * @var integer
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @ORM\Column(name="blocked_g", type="simple_array", nullable=true)
     */
    private $blockedG;

    /**
     * @ORM\Column(name="blocked_m", type="simple_array", nullable=true)
     */
    private $blockedM;

    /**
     * @var bool
     *
     * @ORM\Column(name="gender", type="boolean")
     */
    private $gender;


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
     * Set name
     *
     * @param string $name
     *
     * @return Child
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
     * Set age
     *
     * @param integer $age
     *
     * @return Child
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     *
     * @return Child
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return bool
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set parent
     *
     * @param \UserBundle\Entity\User $parent
     *
     * @return Child
     */
    public function setParent(\UserBundle\Entity\User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \UserBundle\Entity\User
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set photo
     *
     * @param \MediaBundle\Entity\Photo $photo
     *
     * @return Child
     */
    public function setPhoto(\MediaBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \MediaBundle\Entity\Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set blockedG
     *
     * @param array $blockedG
     *
     * @return Child
     */
    public function setBlockedG($blockedG)
    {
        $this->blockedG = $blockedG;

        return $this;
    }

    /**
     * Get blockedG
     *
     * @return array
     */
    public function getBlockedG()
    {
        return $this->blockedG;
    }

    /**
     * Set blockedM
     *
     * @param array $blockedM
     *
     * @return Child
     */
    public function setBlockedM($blockedM)
    {
        $this->blockedM = $blockedM;

        return $this;
    }

    /**
     * Get blockedM
     *
     * @return array
     */
    public function getBlockedM()
    {
        return $this->blockedM;
    }
}
