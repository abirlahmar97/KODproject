<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function billsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('ShopBundle:Order')->byFacture($this->getUser());

        return $this->render('UserBundle:Home:bill.html.twig', array(
            'orders' => $orders
        ));
    }

    public function getUserAction()
    {
        $user = $this->get("jms_serializer")->serialize($this->getUser(), 'json');
        return new Response($user);
    }
}
