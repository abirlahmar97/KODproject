<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="Video")
 * @ORM\Entity(repositoryClass="MediaBundle\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\ManyToOne(targetEntity="ParentingBundle\Entity\Subject")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="ChildBundle\Entity\Cartoon")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cartoon;

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
     * @var string
     *
     * @ORM\Column(name="titre", type="string",length=50)
     */
    private $titre;


    /**
     * @var string
     *
     * @ORM\Column(name="urlyout", type="string",length=255)
     */
    private $urlyout;

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
     * @return Video
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
     * @return Video
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
     * Set Urlyout
     *
     * @param string $Urlyout
     *
     * @return Video
     */
    public function setUrlyout($Urlyout)
    {
        $this->Urlyout = $Urlyout;

        return $this;
    }

    /**
     * Get Urlyout
     *
     * @return string
     */
    public function getUrlyout()
    {
        return $this->Urlyout;
    }
    /**
     * Set url
     *
     * @param string $url
     *
     * @return Video
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Video
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
     * @return Video
     */




    ////
    ///
    ///
    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Video
     */
    public function settitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function gettitre()
    {
        return $this->titre;
    }
    public function setSubject(\ParentingBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \ParentingBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set cartoon.
     *
     * @param \ChildBundle\Entity\Cartoon|null $cartoon
     *
     * @return Video
     */
    public function setCartoon(\ChildBundle\Entity\Cartoon $cartoon = null)
    {
        $this->cartoon = $cartoon;

        return $this;
    }

    /**
     * Get cartoon.
     *
     * @return \ChildBundle\Entity\Cartoon|null
     */
    public function getCartoon()
    {
        return $this->cartoon;
    }
}
