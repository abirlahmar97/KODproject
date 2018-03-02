<?php

namespace MediaBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAide()
    {
        $q=$this->createQueryBuilder('m')
            ->orderBy('m.title')
            ->where("m.type='Aides et services'");
        return $q->getQuery()->getResult();
    }
    public function findCategory($category)
    {
        $q=$this->createQueryBuilder('s')
            ->leftJoin('s.category', 'c')
            ->where("s.type='Aides et services'")
            ->andWhere('c.name = :category')
            ->setParameter(':category',$category);
        return $q->getQuery()->getResult();
    }
    public function findPlusVu()
    {
        $query=$this->getEntityManager()
            ->createQuery(" select m from MediaBundle:Article m WHERE m.views=(select MAX(m1.views) from MediaBundle:Article m1)");
        return $query->getResult();
    }
    public function findTitle($title)
    {
        $q=$this->createQueryBuilder('m')
            ->where('m.title LIKE :title')
            ->setParameter(':title',"%$title%");
        return $q->getQuery()->getResult();
    }



}
