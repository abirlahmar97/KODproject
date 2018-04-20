<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="MediaBundle\Repository\VideoRepository")
 */
class video
{
    /**
     *@var int
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
     * @var string
     *
     * @ORM\Column(name="url", type="string",length=255)
     */
    private $url;
    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;


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
     * Set type
     *
     * @param integer $type
     *
     * @return video
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Set views
     *
     * @param integer $views
     *
     * @return video
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return video
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
     * Set date1
     *
     * @param \DateTime $date1
     *
     * @return video
     */
    public function setDate1($date1)
    {
        $this->date1 = $date1;

        return $this;
    }

    /**
     * Get date1
     *
     * @return \DateTime
     */
    public function getDate1()
    {
        return $this->date1;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return video
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
     * Set subject
     *
     * @param \ParentingBundle\Entity\Subject $subject
     *
     * @return video
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
}
