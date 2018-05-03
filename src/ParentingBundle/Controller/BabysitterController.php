<?php

namespace ParentingBundle\Controller;

use ParentingBundle\Entity\Babysitter;
use ParentingBundle\Form\BabysitterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BabysitterController extends Controller
{

    public function createAction(Request $request)
    {
        $babysitter = new Babysitter();
        $form = $this->createForm(BabysitterType::class, $babysitter);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($babysitter);
            $em->flush();
            return $this->redirectToRoute("read_babysitter");
        }
        return $this->render('@Parenting/Babysitter/create.html.twig', array(
            "form" => $form->createView()
        ));
    }

    public function readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $babysitters = $em->getRepository("ParentingBundle:Babysitter")->findAll();
        return $this->render('@Parenting/Babysitter/read.html.twig', array("babysitters" => $babysitters

        ));
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $babysitter = $em->getRepository("ParentingBundle:Babysitter")->find($id);
        $Form = $this->createForm(BabysitterType::class, $babysitter);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($babysitter);
            $em->flush();
            return $this->redirectToRoute('read_babysitter');
        }
        return $this->render("@Parenting/Babysitter/update.html.twig", array('form' => $Form->createView()));


    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $babysitter = $em->getRepository("ParentingBundle:Babysitter")->find($id);
        if ($babysitter->getState() == 'Libre') {
            $em->remove($babysitter);
            $em->flush();
        }

        return $this->redirecttoRoute("read_babysitter");
    }

    public function front_readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $babysitters = $em->getRepository("ParentingBundle:Babysitter")->findAll();
        return $this->render('@Parenting/Babysitter/frontread.html.twig', array(
            "babysitters" => $babysitters, 'user' => $this->getUser()
        ));
    }

    public function contactAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $babysitter = $em->getRepository("ParentingBundle:Babysitter")->find($id);
        if (!$babysitter->getState()) {
            return $this->render('@Parenting/Babysitter/warning.html.twig', array(
                'babysitter' => $babysitter,
                'user' => $this->getUser()
            ));
        }

        return $this->redirectToRoute('fos_message_inbox');
    }

    public function api_front_readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $babysitters = $em->getRepository("ParentingBundle:Babysitter")->findAll();
        $data= $this->get("jms_serializer")->serialize($babysitters,'json');
        return new Response($data);

    }
    public function api_updateAction(Request $request)
    {

        $data = $request->getContent();
        $pos = $this->get("jms_serializer")->deserialize($data, "ParentingBundle\Entity\Babysitter", "json");
        $em = $this->getDoctrine()->getManager();
        $babysitter = $em->getRepository("ParentingBundle:Babysitter")->find($pos->getId());
        $babysitter->setState(false);
        $em->persist($babysitter);
        $em->flush();


        return new Response();
    }
}

