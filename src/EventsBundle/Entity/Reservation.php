<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="EventsBundle\Repository\ReservationRepository")
 */
class Reservation
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
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     **/
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="EventsBundle\Entity\Event", cascade={"persist"}, inversedBy="reservations")
     */
    private $event;

    /**
     * @var int
     *
     * @ORM\Column(name="participants", type="integer")
     */
    private $participants;




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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Reservation
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set events
     *
     * @param \EventsBundle\Entity\Events $events
     *
     * @return Reservation
     */
    public function setEvents(\EventsBundle\Entity\Events $events = null)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * Get events
     *
     * @return \EventsBundle\Entity\Events
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set event
     *
     * @param \EventsBundle\Entity\Event $event
     *
     * @return Reservation
     */
    public function setEvent(\EventsBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \EventsBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set participants
     *
     * @param integer $participants
     *
     * @return Reservation
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;

        return $this;
    }

    /**
     * Get participants
     *
     * @return integer
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}
