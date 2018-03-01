<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    public function billsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bills = $em->getRepository('ShopBundle:Order')->byFacture($this->getUser());

        return $this->render('UserBundle:Default:bill.html.twig', array(
            'bills' => $bills
        ));
    }
}
