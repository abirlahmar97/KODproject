<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FournisseurController extends Controller
{
    public function readFournisseurAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fournisseurs= $em->getRepository('UserBundle:User')->byFournisseur($role);
        return $this->render('ShopBundle:Fournisseur:read_fournisseur.html.twig', array("fournisseurs"=>$fournisseurs
        ));
    }

}
