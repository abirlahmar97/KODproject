<?php
namespace ShopBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class SetNewReference
{
    private $securityContext;
    private $em;

    public function __construct(AuthorizationChecker $securityContext, EntityManager $entityManager)
    {
        $this->securityContext = $securityContext;
        $this->em = $entityManager;
    }

    public function reference()
    {
        $reference = $this->em->getRepository("ShopBundle:Order")
            ->findOneBy(array('confirmed' => 1), array('id' => 'DESC'));

        if (!$reference)
            return 1;
        else
            return $reference->getReference() + 1;
    }
}