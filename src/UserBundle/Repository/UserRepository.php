<?php

namespace UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function byfournisseur($role)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('role like :roles')
            ->orderBy('u.id')
            ->setParameter('roles', $role);
        return $qb->getQuery()->getResult();
    }
}
