<?php

namespace ChildBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChildController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Child/Child/index.html.twig');
    }
}
