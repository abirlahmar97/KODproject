<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\UtilisateursAdresses;
use ShopBundle\Form\UtilisateursAdressesType;
use ShopBundle\ShopBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\UserInfos;
use UserBundle\Form\UserInfosType;
use Symfony\Component\HttpFoundation\Response;

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
    public function menuAction(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ShopBundle:Product')->findAll();
        if (!$session->has('panier'))
            $articles =0;
        else
            $articles = count($session->get('panier'));

        return $this->render('ShopBundle:panier:panierhaut.html.twig', array('articles' => $articles ,'produits' => $produits));
    }

    public function livraisonAction(Request $request)
    {

        $utilisateur= $this->getUser();

            $entity = new UtilisateursAdresses();



        $form = $this->createForm(UtilisateursAdressesType::class, $entity);
        if ($request->isMethod('POST') )
        {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUtilisateur($utilisateur);
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('livraison'));
            }
        }

        return $this->render('ShopBundle:panier:livraison.html.twig', array('utilisateur' => $utilisateur,
            'form' => $form->createView()));
    }

    public function setLivraisonOnSession(SessionInterface $session,Request $request)
    {
        if (!$session->has('adresse')) $session->set('adresse',array());
            $adresse = $session->get('adresse');

        if ($request->get('livraison') != null && $request->get('facturation') != null)
        {
            $adresse['livraison'] = $request->get('livraison');
            $adresse['facturation'] = $request->get('facturation');
        } else {
            return $this->redirect($this->generateUrl('validation'));
        }
        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }


    public function validationAction(Request $request, SessionInterface $session)
    {
        if ($request->isMethod('POST') )
            $this->setLivraisonOnSession($session,$request);

        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('ShopBundle:Commande:prepareCommande');
        $commande = $em->getRepository('ShopBundle:Commande')->find($prepareCommande->getContent());
        dump($commande);
        return $this->render('ShopBundle:panier:validation.html.twig', array('commande' => $commande));
    }


}

