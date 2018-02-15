<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryFrontController extends Controller
{
    public function readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ShopBundle:Category')->findAll();
        return $this->render('ShopBundle:Default/Categories:menu.html.twig', array('categories' => $categories));
    }

}
