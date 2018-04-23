<?php

namespace ChildBundle\Repository;

/**
 * ChildRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChildRepository extends \Doctrine\ORM\EntityRepository
{

    public function findMyKids($id){
        $qb = $this->createQueryBuilder('c');

        $qb->leftJoin('c.parent', 'p')
            ->where('p.id = :id')
            ->setParameter(':id', $id);
        return $qb->getQuery()->getResult();
    }

}
