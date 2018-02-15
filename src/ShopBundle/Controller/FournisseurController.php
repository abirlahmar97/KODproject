<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FournisseurController extends Controller
{
    public function readFournisseurAction($roles)
    {
        $em = $this->getDoctrine()->getManager();
        $fournisseurs= $em->getRepository('UserBundle:User')->byFournisseur($roles);
        return $this->render('ShopBundle:Admin/Fournisseur:read_fournisseur.html.twig', array("fournisseurs"=>$fournisseurs
        ));
    }

}
