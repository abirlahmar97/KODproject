<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GuzzleHttp\Collection;
use FOS\MessageBundle\Entity\Thread as BaseThread;
/**
 * Thread
 *
 * @ORM\Table(name="mthread")
 * @ORM\Entity(repositoryClass="MediaBundle\Repository\MThreadRepository")
 */
class MThread extends BaseThread
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $createdBy;

    /**
     * @ORM\OneToMany(
     *   targetEntity="MediaBundle\Entity\Message",
     *   mappedBy="thread"
     * )
     * @var Message[]|Collection
     */
    protected $messages;

    /**
     * @ORM\OneToMany(
     *   targetEntity="MediaBundle\Entity\MThreadMetadata",
     *   mappedBy="thread",
     *   cascade={"all"}
     * )
     * @var MThreadMetadata[]|Collection
     */
    protected $metadata;

}