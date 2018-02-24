<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UtilisateurController extends Controller
{
    public function facturesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('ShopBundle:Commande')->byFacture($this->getUser());

        return $this->render('UserBundle:Default:facture.html.twig', array('factures' => $factures));
    }
}
