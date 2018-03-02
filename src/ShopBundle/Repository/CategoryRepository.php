<?php

namespace ShopBundle\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function findArticle()
    {
        $q=$this->createQueryBuilder('c')
            ->where("c.type='Article'");
        return $q->getQuery()->getResult();
    }

    public function findAddress()
    {
        $q=$this->createQueryBuilder('c')

            ->where("c.type='Adresse'");

        ;
        return $q->getQuery()->getResult();
    }


    public function findTypeProduct(){
        $q=$this->createQueryBuilder('c')
            ->where("c.type='Produits'");
        return $q->getQuery()->getResult();
    }

}
