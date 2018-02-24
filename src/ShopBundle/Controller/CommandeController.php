<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CommandeController extends Controller
{


    public function facture(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;

        $facturation = $em->getRepository('ShopBundle:UtilisateursAdresses')->find($adresse['facturation']);
        $livraison = $em->getRepository('ShopBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $produits = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('panier')));

        foreach ($produits as $produit) {
            $prixHT = ($produit->getPrice() * $panier[$produit->getId()]);
            $totalHT += $prixHT;

            $commande['produit'][$produit->getId()] = array('reference' => $produit->getName(),
                'quantite' => $panier[$produit->getId()],
                'prixHT' => round($produit->getPrice(), 2));

        }

        $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
            'nom' => $livraison->getNom(),
            'telephone' => $livraison->getTelephone(),
            'adresse' => $livraison->getAdresse(),
            'cp' => $livraison->getCp(),
            'region' => $livraison->getRegion());

        $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
            'nom' => $facturation->getNom(),
            'telephone' => $facturation->getTelephone(),
            'adresse' => $facturation->getAdresse(),
            'cp' => $facturation->getCp(),
            'region' => $facturation->getRegion());

        $commande['prixHT'] = round($totalHT, 2);
        $commande['token'] = "sjdldjfgsdkmfk";

        return $commande;
    }


    public function prepareCommandeAction(SessionInterface $session)
    {

        $em = $this->getDoctrine()->getManager();
        if (!$session->has('commande'))
            $commande = new Commande();
        else
            $commande = $em->getRepository('ShopBundle:Commande')->find($session->get('commande')->getId());

        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->getUser());
        $commande->setValider(0);
        $commande->setReference(0);
        $commande->setCommande($this->facture($session));

        if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande', $commande);
        }

        $em->flush();
        return new Response($commande->getId());
    }

    public function validationCommandeAction($id, SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('ShopBundle:Commande')->find($id);

        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');

        $commande->setValider(1);
        $commande->setReference($this->container->get('setNewReference')->reference());
        $em->flush();


        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');

        $this->get('session')->getFlashBag()->add('success', 'Votre commande est validé avec succès');
        return $this->redirect($this->generateUrl('factures'));
    }

}
