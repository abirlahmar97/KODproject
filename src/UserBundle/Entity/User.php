<?php

namespace UserBundle\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use ShopBundle\Entity\Order;
use ShopBundle\Entity\UserAddress;
use UserBundle\Entity\UserInfos;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser implements ParticipantInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @var UserInfos
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\UserInfos", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $infos;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Order", mappedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\UserAddress", mappedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $addresses;


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
     * Set infos
     *
     * @param UserInfos $infos
     *
     * @return User
     */
    public function setInfos(UserInfos $infos = null)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return UserInfos
     */
    public function getInfos()
    {
        return $this->infos;
    }

    public function getFullname(){
        return $this->infos->getFirstname() . ' ' . $this->infos->getLastname();
    }

    /**
     * Add order
     *
     * @param Order $order
     *
     * @return User
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param Order $order
     */
    public function removeOrder(Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }




    /**
     * Add adress
     *
     * @param UserAddress $address
     *
     * @return User
     */
    public function addAddress(UserAddress $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param UserAddress $address
     */
    public function removeAddress(UserAddress $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}
