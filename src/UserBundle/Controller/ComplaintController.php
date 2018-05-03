<?php

namespace UserBundle\Controller;

use ShopBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Complaint;
use UserBundle\Entity\Notification;
use UserBundle\Form\ComplaintType;

class ComplaintController extends Controller
{
    public function createAction(Request $request)
    {
        $complaint = new Complaint();
        $form = $this->createForm(ComplaintType::class, $complaint);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $complaint->setParent($this->getUser());
            $complaint->setState('non_traitee');
            $em->persist($complaint);
            $em->flush();
            return $this->redirectToRoute("front_read_complaint");
        }
        return $this->render('@User/Complaint/create.html.twig', array(
            "form" => $form->createView(), 'user' => $this->getUser()
        ));
    }

    public function readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $complaints = $em->getRepository("UserBundle:Complaint")->findAll();
        return $this->render('@User/Complaint/read.html.twig', array("complaints" => $complaints

        ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $complaints = $em->getRepository("UserBundle:Complaint")->findAll();
        $complaint = $em->getRepository("UserBundle:Complaint")->find($id);
        $complaint->setState('traitee');
        $notification= new Notification(false,"Votre réclamation a été traitée avec succès",$this->getUser());
        $em->persist($notification);
        $em->flush();
        return $this->render("@User/Complaint/read.html.twig", array('complaints' => $complaints));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $complaint = $em->getRepository('UserBundle:Complaint')->find($id);
        $em->remove($complaint);
        $em->flush();
        return $this->redirectToRoute('read_complaint');
    }

    public function front_readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $complaints = $em->getRepository("UserBundle:Complaint")->findAll();
        return $this->render('@User/Complaint/front_read.html.twig', array("complaints" => $complaints, 'user' => $this->getUser()

        ));
    }


    public function api_readAction()
    {

        $em = $this->getDoctrine()->getManager();
        $complaints = $em->getRepository("UserBundle:Complaint")->findAll();
        $data= $this->get("jms_serializer")->serialize($complaints,'json');
        return new Response($data);


    }


    public function api_createAction(Request $request)
    {   $data = $request->getContent();
        $em = $this->getDoctrine()->getManager();

        $pos = $this->get("jms_serializer")->deserialize($data, "UserBundle\Entity\Complaint", "json");

        $complaint = new Complaint();

            $em = $this->getDoctrine()->getManager();

            $complaint->setParent($this->getUser());
            $complaint->setDate($pos->getDate());
            $complaint->setState($pos->getState());
            $category= $em->getRepository("ShopBundle:Category")->find($pos->getCategory()->getId());
            $complaint->setCategory($category);
            $complaint->setSubject($pos->getSubject());
            $complaint->setDescription($pos->getDescription());



            $em->persist($complaint);
            $em->flush();


       return new Response();


    }

    public function api_categoryAction()
    {
        $em=$this->getDoctrine()->getManager();
        $categories= $em->getRepository("ShopBundle:Category")->findComplaint();
        $data= $this->get("jms_serializer")->serialize($categories,'json');
        return new Response($data);

    }}



