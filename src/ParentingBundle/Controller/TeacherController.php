<?php

namespace ParentingBundle\Controller;

use ParentingBundle\Entity\Teacher;
use ParentingBundle\Form\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeacherController extends Controller
{
    public function createAction(Request $request)
    {
        $Teachers = new Teacher();
        $form = $this->createForm(TeacherType::class, $Teachers);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Teachers);
            $em->flush();
            return $this->redirectToRoute("teacher_add");
        }
        return $this->render('@Parenting/Teachers/addteacher.html.twig', array(
            "form" => $form->createView()
        ));
    }
    public function readteachersAction()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("ParentingBundle:Teacher")->findAll();
        return $this->render('@Parenting/Teachers/readteacher.html.twig', array(
            "teachers"=>$teachers
        ));
    }
    public function readteachers1Action()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("ParentingBundle:Teacher")->findAll();
        return $this->render('@Parenting/Teachers/deleteteacher.html.twig', array(
            "teachers"=>$teachers
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
            return $this->redirectToRoute("read_teachers1");
        }
        return $this->render('ParentingBundle:Teachers:updateteacher.html.twig', array(
            "form"=>$form->createView()
        ));
    }

    public function aboutAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $teacher=$em->getRepository("ParentingBundle:Teacher")->find($id);
            return $this->render('@Parenting/Teachers/aboutteacher.html.twig',array('teacher'=>$teacher));
    }


}
