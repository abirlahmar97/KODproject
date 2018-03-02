<?php

namespace UserBundle\Repository;

/**
 * ComplaintRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ComplaintRepository extends \Doctrine\ORM\EntityRepository
{
    public function findUser($user)
    {
        $q=$this->createQueryBuilder('m')
            ->where("m.parent=:user")
            ->setParameter(':user',$user);
        return $q->getQuery()->getResult();
    }
}
