<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\CommentRepository")
 */
class Comment extends BaseComment implements SignedCommentInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Thread")
     * @ORM\JoinColumn(name="idP",referencedColumnName="id")
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     *
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id")
     */
    protected $idUser;

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
     * Sets the author of the Comment
     *
     * @param UserInterface $idUser
     */
    public function setAuthor(UserInterface $idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * Gets the author of the Comment
     *
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->idUser;
    }

    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
    }


    /**
     * Set idUser
     *
     * @param \UserBundle\Entity\User $idUser
     *
     * @return Comment
     */
    public function setIdUser(\UserBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
