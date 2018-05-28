<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MediaBundle\Entity\Video;

/**
 * ChilGame
 *
 * @ORM\Table(name="child_quiz")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\ChildQuizRepository")
 */
class ChildQuiz
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
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time")
     */
    private $duration;


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
     * @return ChildQuiz
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
     * Set duration
     *
     * @param \DateTime $duration
     *
     * @return ChildQuiz
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set child
     *
     * @param \ChildBundle\Entity\Child $child
     *
     * @return ChildQuiz
     */
    public function setChild(\ChildBundle\Entity\Child $child = null)
    {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return \ChildBundle\Entity\Child
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set game
     *
     * @param Video $quiz
     *
     * @return ChildQuiz
     */
    public function setQuiz(Video $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get game
     *
     * @return Video
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
}
