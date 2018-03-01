<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Entity\UserInfos;
use UserBundle\Form\UserInfosType;

class ProvidersController extends Controller
{


    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $providers = $em->getRepository('UserBundle:User')->byFournisseur();
        return $this->render('ShopBundle:Admin/Providers:list.html.twig', array(
            "providers" => $providers
        ));
    }

    public function addAction(Request $request)
    {
        $provider = new User();
        $form = $this->createForm(UserInfosType::class, $provider);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();
            return $this->redirectToRoute("list_providers");
        }
        return $this->render('ShopBundle:Admin/Providers:add.html.twig', array(
            "form" => $form->createView()
        ));
    }

}