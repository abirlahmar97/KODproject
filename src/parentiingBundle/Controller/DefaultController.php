<?php

namespace parentiingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('parentiingBundle:Default:index.html.twig');
    }
}
