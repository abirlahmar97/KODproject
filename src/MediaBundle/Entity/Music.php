<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Music
 *
 * @ORM\Table(name="music")
 * @ORM\Entity(repositoryClass="MediaBundle\Repository\MusicRepository")
 */
class Music
{

    /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Photo", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $photo;

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="singer", type="string", length=255)
     */
    private $singer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Music
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->title;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     *
     * @return Music
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
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @var UploadedFile
     */

    private $file;

    private $tempFilename;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
//        if ($this->url !== null) {
//            $this->tempFilename = $this->url;
//            $this->url = null;
//            $this->alt = null;
//        }
    }


    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        $name = $this->file->getClientOriginalName();
        $this->file->move($this->getUploadRootDir(), str_replace(' ', '', $this->title) . '.mp3');
        $this->url = $name;
        $this->alt = $name;
    }

    public function getUploadDir()
    {
        return 'uploads/music';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }


    /**
     * Set singer
     *
     * @param string $singer
     *
     * @return Music
     */
    public function setSinger($singer)
    {
        $this->singer = $singer;

        return $this;
    }

    /**
     * Get singer
     *
     * @return string
     */
    public function getSinger()
    {
        return $this->singer;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Music
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Set photo
     *
     * @param \MediaBundle\Entity\Photo $photo
     *
     * @return Music
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
}
