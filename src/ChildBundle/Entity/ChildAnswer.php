<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChildAnswer
 *
 * @ORM\Table(name="child_answer")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\ChildAnswerRepository")
 */
class ChildAnswer
{

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Child", cascade={"persist"})
     */
    private $child;

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Answer", cascade={"persist"})
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Attempt", cascade={"persist"})
     */
    private $attempt;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * Set child
     *
     * @param \ChildBundle\Entity\Child $child
     *
     * @return ChildAnswer
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
     * Set answer
     *
     * @param \ChildBundle\Entity\Answer $answer
     *
     * @return ChildAnswer
     */
    public function setAnswer(\ChildBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \ChildBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set attempt
     *
     * @param \ChildBundle\Entity\Attempt $attempt
     *
     * @return ChildAnswer
     */
    public function setAttempt(\ChildBundle\Entity\Attempt $attempt = null)
    {
        $this->attempt = $attempt;

        return $this;
    }

    /**
     * Get attempt
     *
     * @return \ChildBundle\Entity\Attempt
     */
    public function getAttempt()
    {
        return $this->attempt;
    }
}
