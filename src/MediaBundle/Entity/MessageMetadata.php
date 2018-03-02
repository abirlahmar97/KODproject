<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\MessageMetadata as BaseMessageMetadata;
/**
 * MessageMetadata
 *
 * @ORM\Table(name="message_metadata")
 * @ORM\Entity(repositoryClass="ParentingBundle\Repository\MessageMetadataRepository")
 */
class MessageMetadata extends BaseMessageMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="MediaBundle\Entity\Message",
     *   inversedBy="metadata"
     * )
     * @var \FOS\MessageBundle\Model\MessageInterface
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $participant;

}