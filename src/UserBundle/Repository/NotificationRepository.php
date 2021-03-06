<?php

namespace UserBundle\Repository;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByUser($user)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.user = :user')
            ->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }
}
