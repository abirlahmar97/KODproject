<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Complaint;
use UserBundle\Form\ComplaintType;

class ComplaintController extends Controller
{
    public function createAction(Request $request)
    {
        $complaint = new Complaint();
        $form=$this->createForm(ComplaintType::class,$complaint);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $complaint->setParent($this->getUser());
            $complaint->setState('non_traitee');
            $em->persist($complaint);
            $em->flush();
            return $this->redirectToRoute("create_complaint");
        }
        return $this->render('@User/Complaint/create.html.twig', array(
            "form"=>$form->createView(),'user' => $this->getUser()
        ));
    }

    public function readAction()
    {
        $em= $this->getDoctrine()->getManager();
        $complaints=$em->getRepository("UserBundle:Complaint")->findAll();
        return $this->render('@User/Complaint/read.html.twig', array( "complaints" => $complaints

        ));
    }

    public function updateAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $complaints=$em->getRepository("UserBundle:Complaint")->findAll();
        $complaint=$em->getRepository("UserBundle:Complaint")->find($id);
        $complaint->setState('traitee');

        return $this->render("@User/Complaint/read.html.twig",array('complaints'=>$complaints));
    }

    public function deleteAction($id)
    {
            $em = $this->getDoctrine()->getManager();
            $complaint= $em->getRepository('UserBundle:Complaint')->find($id);
            $em->remove($complaint);
            $em->flush();
            return $this->redirectToRoute('read_complaint');
    }

    public function front_readAction()
    {
        $em= $this->getDoctrine()->getManager();
        $complaints=$em->getRepository("UserBundle:Complaint")->findAll();
        return $this->render('@User/Complaint/front_read.html.twig', array( "complaints" => $complaints,'user' => $this->getUser()

        ));
    }



}
