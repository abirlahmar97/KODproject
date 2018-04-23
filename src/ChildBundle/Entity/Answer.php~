<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Question", inversedBy="answers")
     */
    private $question;

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
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="correct", type="boolean")
     */
    private $correct;


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
     * Set content
     *
     * @param string $content
     *
     * @return Answer
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set correct
     *
     * @param boolean $correct
     *
     * @return Answer
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * Get correct
     *
     * @return bool
     */
    public function getCorrect()
    {
        return $this->correct;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kids = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add kid
     *
     * @param \ChildBundle\Entity\Child $kid
     *
     * @return Answer
     */
    public function addKid(\ChildBundle\Entity\Child $kid)
    {
        $this->kids[] = $kid;

        return $this;
    }

    /**
     * Remove kid
     *
     * @param \ChildBundle\Entity\Child $kid
     */
    public function removeKid(\ChildBundle\Entity\Child $kid)
    {
        $this->kids->removeElement($kid);
    }

    /**
     * Get kids
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKids()
    {
        return $this->kids;
    }

    /**
     * Set question
     *
     * @param \ChildBundle\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\ChildBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \ChildBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
