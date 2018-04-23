<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\QuestionRepository")
 */
class Question
{

    /**
     * @ORM\OneToMany(targetEntity="ChildBundle\Entity\Answer", mappedBy="question")
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Quiz", inversedBy="questions", cascade={"persist"})
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
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;


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
     * @return Question
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
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add answer
     *
     * @param \ChildBundle\Entity\Answer $answer
     *
     * @return Question
     */
    public function addAnswer(\ChildBundle\Entity\Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \ChildBundle\Entity\Answer $answer
     */
    public function removeAnswer(\ChildBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set quiz
     *
     * @param \ChildBundle\Entity\Quiz $quiz
     *
     * @return Question
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
