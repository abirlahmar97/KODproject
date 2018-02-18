<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Entity\Category;

/**
 * Complaint
 *
 * @ORM\Table(name="complaint")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ComplaintRepository")
 */
class Complaint
{
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;
    /**
    /**
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $parent;
    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Category")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

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
     * Set description
     *
     * @param string $description
     *
     * @return Complaint
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set parent
     *
     * @param \UserBundle\Entity\User $parent
     *
     * @return Complaint
     */
    public function setParent(\UserBundle\Entity\User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \UserBundle\Entity\User
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Complaint
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }



    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Complaint
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
     * Set state
     *
     * @param string $state
     *
     * @return Complaint
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set category
     *
     * @param \ShopBundle\Entity\Category $category
     *
     * @return Complaint
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ShopBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
