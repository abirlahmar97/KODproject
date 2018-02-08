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

    /**
     * @var UserInfos
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\UserInfos", cascade={"persist"})
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
}
