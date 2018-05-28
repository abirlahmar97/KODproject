<?php

namespace ChildBundle\Repository;


/**
 * ChilGameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChildVideoRepository extends \Doctrine\ORM\EntityRepository
{

    public function findForChild($id){
        $qb = $this->createQueryBuilder('cm')
            ->leftJoin("cm.child", 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }


    public function videoTime($child){
        $em = $this->getEntityManager();
        $conn = $em->getConnection();
        $query = $conn->prepare("SELECT SUM(Time_TO_SEC(cv.duration)) as played_time " .
            "FROM child_video cv WHERE child_id = :id");
        $query->bindValue('id', $child );
        $query->execute();
        return $query->fetchAll();
    }

//    public function playedToday($child){
//        $em = $this->getEntityManager();
//        $conn = $em->getConnection();
//        $query = $conn->prepare("SELECT SUM(Time_TO_SEC(cg.duration)) as played_time " .
//            "FROM child_game cg WHERE child_id = :id");
//        $query->bindValue('id', $child );
//        $query->execute();
//        return $query->fetchAll();
//    }

    public function recentGames($id){
        $qb = $this->createQueryBuilder('cg')
            ->leftJoin('cg.child', 'c')
            ->where('c.id = :id')
            ->orderBy('cg.date', 'DESC')
            ->setMaxResults(10)
            ->groupBy('cg.game')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }
}
