<?php

namespace ParentingBundle\Controller;

use parentiingBundle\Entity\Teacher;
use parentiingBundle\Form\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeacherController extends Controller
{
    public function readteachersAction()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("parentiingBundle:Teacher")->findAll();
        return $this->render('@parentiing/teachers/readteachers.html.twig', array(
            "teachers"=>$teachers
        ));
    }
    public function readteachers1Action()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("parentiingBundle:Teacher")->findAll();
        return $this->render('@parentiing/teachers/deleteteacher.twig', array(
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
        return $this->render('@parentiing/teachers/addteacher.html.twig', array(
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
        $teacher=$em->getRepository("parentiingBundle:Teacher")->find($id);
        $form=$this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute("update_teacher");
        }
        return $this->render('parentiingBundle:teachers:updateteacher.html.twig', array(
            "form"=>$form->createView()
        ));
    }

}
