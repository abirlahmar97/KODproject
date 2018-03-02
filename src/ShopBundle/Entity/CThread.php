<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * Thread
 *
 * @ORM\Table(name="cthread")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ThreadRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class CThread extends BaseThread
{
    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
