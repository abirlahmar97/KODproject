<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChilGame
 *
 * @ORM\Table(name="child_game")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\ChildGameRepository")
 */
class ChildGame
{

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Child", cascade={"persist"})
     */
    private $child;

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Game", cascade={"persist"})
     */
    private $game;

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
     * @return ChildGame
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
     * @return ChildGame
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
     * @return ChildGame
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
     * @param \ChildBundle\Entity\Game $game
     *
     * @return ChildGame
     */
    public function setGame(\ChildBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \ChildBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }
}
