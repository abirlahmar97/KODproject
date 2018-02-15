<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{

    public function ajouterpanierAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');

        } else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;

        }
        $session->set('panier',$panier);
     return $this->redirect($this->generateUrl("panier"));
    }

    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) $session->set('panier', array());
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('panier')));

        return $this->render('ShopBundle:panier:panier.html.twig', array('produits' => $produits,
            'panier' => $session->get('panier')));
    }


}
