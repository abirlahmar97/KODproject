<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MediaBundle\Entity\Photo;
use ShopBundle\Entity\Category;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\GameRepository")
 */
class Game
{

    /**
     * @ORM\OneToOne(targetEntity="MediaBundle\Entity\Photo", cascade={"persist"})
     */
    private $icon;

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Category", cascade={"persist"})
     */
    private $category;

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var int
     *
     * @ORM\Column(name="gender", type="integer")
     */
    private $gender;

    /**
     * @var array
     *
     * @ORM\Column(name="device", type="array")
     */
    private $devices;

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
     * @return Game
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
     * Set url
     *
     * @param string $url
     *
     * @return Game
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Game
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set icon
     *
     * @param Photo $icon
     *
     * @return Game
     */
    public function setIcon(Photo $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return Photo
     */
    public function getIcon()
    {
        return $this->icon;
    }


    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Game
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Game
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set devices
     *
     * @param array $devices
     *
     * @return Game
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;

        return $this;
    }

    /**
     * Get devices
     *
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }
}
