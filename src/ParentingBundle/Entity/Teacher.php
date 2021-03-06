<?php

namespace ParentingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 *
 * @ORM\Table(name="teacher")
 * @ORM\Entity(repositoryClass="ParentingBundle\Repository\TeacherRepository")
 */
class Teacher
{
    /**
     * @ORM\ManyToOne(targetEntity="ParentingBundle\Entity\Subject")
     */
    protected $Subject;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */

    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="degree", type="string", length=255)
     */
    private $degree;

    /**
     * @var string
     *
     * @ORM\Column(name="experience", type="integer")
     */
    private $experience;

    /**
     * @var string
     *
     * @ORM\Column(name="account", type="string", length=255, nullable=true)
     */
    private $linefb;

    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="integer")
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity="MediaBundle\Entity\Photo", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $photo;

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
     * Set price
     *
     * @param float $price
     *
     * @return Teacher
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Subjects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subject
     *
     * @param \ParentingBundle\Entity\Subject $subject
     *
     * @return Teacher
     */
    public function addSubject(\ParentingBundle\Entity\Subject $subject)
    {
        $this->Subjects[] = $subject;

        return $this;
    }

    /**
     * Remove subject
     *
     * @param \ParentingBundle\Entity\Subject $subject
     */
    public function removeSubject(\ParentingBundle\Entity\Subject $subject)
    {
        $this->Subjects->removeElement($subject);
    }

    /**
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubjects()
    {
        return $this->Subjects;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Teacher
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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Teacher
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set photo
     *
     * @param \MediaBundle\Entity\Photo $photo
     *
     * @return Teacher
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
     * Set linefb
     *
     * @param string $linefb
     *
     * @return Teacher
     */
    public function setLinefb($linefb)
    {
        $this->linefb = $linefb;

        return $this;
    }

    /**
     * Get linefb
     *
     * @return string
     */
    public function getLinefb()
    {
        return $this->linefb;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Teacher
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set subject
     *
     * @param \ParentingBundle\Entity\Subject $subject
     *
     * @return Teacher
     */
    public function setSubject(\ParentingBundle\Entity\Subject $subject = null)
    {
        $this->Subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \ParentingBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->Subject;
    }

    /**
     * Set degree.
     *
     * @param string $degree
     *
     * @return Teacher
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree.
     *
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set experience.
     *
     * @param string $experience
     *
     * @return Teacher
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience.
     *
     * @return string
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set hobbies.
     *
     * @param string $hobbies
     *
     * @return Teacher
     */
    public function setHobbies($hobbies)
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    /**
     * Get hobbies.
     *
     * @return string
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }
}
