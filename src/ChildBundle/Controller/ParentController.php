<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\Child;
use ChildBundle\Form\ChildType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ParentController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function addKidAction(Request $request)
    {
        $child = new Child();
        $form = $this->createForm(ChildType::class, $child);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid() ){
            $em = $this->getDoctrine()->getManager();
            $child->setParent($this->getUser());
            $em->persist($child);
            $em->flush();
        }
        return $this->render('ChildBundle:Parent:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function listKidsAction()
    {
        $kids = $this->getDoctrine()->getRepository("ChildBundle:Child")
            ->findMyKids($this->getUser()->getId());

        return $this->render('ChildBundle:Parent:kids.html.twig', [
            'kids' => $kids
        ]);
    }

}
