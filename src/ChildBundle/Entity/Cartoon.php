<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cartoon
 *
 * @ORM\Table(name="cartoon")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\CartoonRepository")
 */
class Cartoon
{

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
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var int
     *
     * @ORM\Column(name="episodesCnt", type="integer")
     */
    private $episodesCnt;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * Set summary
     *
     * @param string $summary
     *
     * @return Cartoon
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set episodesCnt
     *
     * @param integer $episodesCnt
     *
     * @return Cartoon
     */
    public function setEpisodesCnt($episodesCnt)
    {
        $this->episodesCnt = $episodesCnt;

        return $this;
    }

    /**
     * Get episodesCnt
     *
     * @return int
     */
    public function getEpisodesCnt()
    {
        return $this->episodesCnt;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Cartoon
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
     * Set photo
     *
     * @param \MediaBundle\Entity\Photo $photo
     *
     * @return Cartoon
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
     * Set age
     *
     * @param integer $age
     *
     * @return Cartoon
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
     * @param integer $gender
     *
     * @return Cartoon
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
}
