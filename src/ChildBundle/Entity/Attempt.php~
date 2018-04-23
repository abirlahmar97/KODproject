<?php

namespace ChildBundle\Entity;

use ChildBundle\Entity\Child;
use Doctrine\ORM\Mapping as ORM;

/**
 * Attempt
 *
 * @ORM\Table(name="attempt")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\AttemptRepository")
 */
class Attempt
{
    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Child", cascade={"persist"})
     */
    private $child;

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Quiz", cascade={"persist"})
     */
    private $quiz;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Attempt
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quiz = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Attempt
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set child
     *
     * @param Child $child
     *
     * @return Attempt
     */
    public function setChild(Child $child = null)
    {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return Child
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set quiz
     *
     * @param \ChildBundle\Entity\Quiz $quiz
     *
     * @return Attempt
     */
    public function setQuiz(\ChildBundle\Entity\Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \ChildBundle\Entity\Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
}
