<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="MediaBundle\Repository\RatingRepository")
 */
class Rating
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
     * @var int
     *
     * @ORM\Column(name="nb_stars", type="integer")
     */
    private $nb_stars;
    /**
    /**
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $parent;
    /**
    /**
    /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;

    /**
     * Rating constructor.
     */
    public function __construct()
    {
        $this->nb_stars=0;
    }

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
     * Set parent
     *
     * @param \UserBundle\Entity\User $parent
     *
     * @return Rating
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
     * Set article
     *
     * @param \MediaBundle\Entity\Article $article
     *
     * @return Rating
     */
    public function setArticle(\MediaBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \MediaBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set nbStars
     *
     * @param integer $nbStars
     *
     * @return Rating
     */
    public function setNbStars($nbStars)
    {
        $this->nb_stars = $nbStars;

        return $this;
    }

    /**
     * Get nbStars
     *
     * @return integer
     */
    public function getNbStars()
    {
        return $this->nb_stars;
    }
}
