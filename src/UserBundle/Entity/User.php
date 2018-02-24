<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", nullable=true)
     */
    private $phone;


    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Commande", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\UtilisateursAdresses", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresses;


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
     * Set phone
     *
     * @param integer $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set infos
     *
     * @param \UserBundle\Entity\UserInfos $infos
     *
     * @return User
     */
    public function setInfos(\UserBundle\Entity\UserInfos $infos = null)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return \UserBundle\Entity\UserInfos
     */
    public function getInfos()
    {
        return $this->infos;
    }

    public function getFullname(){
        return $this->infos->getFirstname() . ' ' . $this->infos->getLastname();
    }



    /**
     * Add commande
     *
     * @param \ShopBundle\Entity\Commande $commande
     *
     * @return User
     */
    public function addCommande(\ShopBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \ShopBundle\Entity\Commande $commande
     */
    public function removeCommande(\ShopBundle\Entity\Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }




    /**
     * Add adress
     *
     * @param \ShopBundle\Entity\UtilisateursAdresses $adress
     *
     * @return User
     */
    public function addAdress(\ShopBundle\Entity\UtilisateursAdresses $adress)
    {
        $this->adresses[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \ShopBundle\Entity\UtilisateursAdresses $adress
     */
    public function removeAdress(\ShopBundle\Entity\UtilisateursAdresses $adress)
    {
        $this->adresses->removeElement($adress);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}
