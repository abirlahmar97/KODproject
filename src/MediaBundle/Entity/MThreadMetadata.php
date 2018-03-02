<?php

namespace MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\ThreadMetadata as BaseThreadMetadata;
/**
 * ThreadMetadata
 *
 * @ORM\Table(name="thread_metadata")
 * @ORM\Entity(repositoryClass="MediaBundle\Repository\MThreadMetadataRepository")
 */
class MThreadMetadata extends BaseThreadMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="MediaBundle\Entity\MThread",
     *   inversedBy="metadata"
     * )
     * @var \FOS\MessageBundle\Model\ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $participant;

}