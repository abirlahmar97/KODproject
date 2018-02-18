<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends Controller
{

    public function ajouterpanierAction($id, Request $request, SessionInterface $session)
    {
        if (!$session->has('panier')) $session->set('panier', array());
        $panier = $session->get('panier');


        if (is_array($panier) && array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
            $this->get('session')->getFlashBag()->add('success', 'Quantité modifié avec succès');
        } else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;

            $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('panier');

    }

    public function panierAction(Request $request, SessionInterface $session)
    {

        if (!$session->has('panier')) $session->set('panier', array());
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('panier')));

        return $this->render('ShopBundle:panier:panier.html.twig', array(
            'produits' => $produits,
            'panier' => $session->get('panier')));
    }

    public function supprimerpanierAction($id, Request $request, SessionInterface $session)
    {
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            unset($panier[$id]);
            $session->set('panier', $panier);
            $this->get('session')->getFlashBag()->add('success', 'Article supprimé avec succès');
        }

        return $this->redirectToRoute('panier');
    }

}
