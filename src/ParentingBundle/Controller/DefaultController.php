<?php

namespace ParentingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ParentingBundle:Default:index.html.twig');
    }

}
