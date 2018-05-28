<?php

namespace ChildBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MediaBundle\Entity\Music;
use MediaBundle\Entity\Video;

/**
 * ChilGame
 *
 * @ORM\Table(name="child_music")
 * @ORM\Entity(repositoryClass="ChildBundle\Repository\ChildMusicRepository")
 */
class ChildMusic
{

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Child", cascade={"persist"})
     */
    private $child;

    /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Music", cascade={"persist"})
     */
    private $music;

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
     * @return ChildVideo
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
     * @return ChildVideo
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
     * @return ChildVideo
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
     * @param Music $music
     *
     * @return ChildVideo
     */
    public function setMusic(Music $music = null)
    {
        $this->music = $music;

        return $this;
    }

    /**
     * Get game
     *
     * @return Video
     */
    public function getMusic()
    {
        return $this->music;
    }
}
