<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Entity\UserInfos;
use UserBundle\Form\UserInfosType;

class FournisseurController extends Controller
{


    public function readFournisseurAction()
    {
        $em = $this->getDoctrine()->getManager();
        $providers = $em->getRepository('UserBundle:User')->byFournisseur();
        return $this->render('ShopBundle:Admin/Fournisseur:read_fournisseur.html.twig', array(
            "providers" => $providers
        ));
    }

    public function createFournisseurAction(Request $request)
    {
        $fournisseur = new UserInfos();
        $form = $this->createForm(UserInfosType::class, $fournisseur);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fournisseur);
            $em->flush();
            return $this->redirectToRoute("read_fournisseur", ['roles' => 'ROLE_PROVIDER']);
        }
        return $this->render('ShopBundle:Admin/Fournisseur:createFournissuer.html.twig', array(
            "form" => $form->createView()
        ));
    }

}