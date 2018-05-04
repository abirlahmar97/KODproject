<?php

namespace ParentingBundle\Controller;

use ParentingBundle\Entity\Teacher;
use ParentingBundle\Form\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends Controller
{
    public function readteachersAction()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("ParentingBundle:Teacher")->findAll();
        return $this->render('@Parenting/teachers/readteacher.html.twig', array(
            "teachers"=>$teachers
        ));
    }


    public function readteachers1Action()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("ParentingBundle:Teacher")->findAll();
        return $this->render('@Parenting/teachers/deleteteacher.twig', array(
            "teachers"=>$teachers
        ));
    }
    public function createAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $teachers = new Teacher();
        $form = $this->createForm(TeacherType::class, $teachers);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teachers);
            $em->flush();
            return $this->redirectToRoute("teacher_add");
        }
        return $this->render('@Parenting/teachers/addteacher.html.twig', array(
            "form" => $form->createView()
        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $teaccher= $em->getRepository(Teacher::class)->find($id);
        $em->remove($teaccher);
        $em->flush();
        return $this->redirectToRoute("read_teachers1");
    }

    public function updateteacherAction ($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $teacher=$em->getRepository("ParentingBundle:Teacher")->find($id);
        $form=$this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute("update_teacher");
        }
        return $this->render('ParentingBundle:teachers:updateteacher.html.twig', array(
            "form"=>$form->createView()
        ));
    }

    public function readteachersapiAction()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("ParentingBundle:Teacher")->findAll();
        $data=$this->get("jms_serializer")->serialize($teachers,'json');
        return new Response($data);
    }
    public function moreApiteacherAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $teachers= $em->getRepository("ParentingBundle:Teacher")->find($id);
        $data= $this->get("jms_serializer")->serialize($teachers,'json');
        return new \Symfony\Component\HttpFoundation\Response($data);
    }
    }
