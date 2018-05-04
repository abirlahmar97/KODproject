<?php

namespace ParentingBundle\Controller;

use ParentingBundle\Entity\School;
use ParentingBundle\Form\SchoolType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SchoolController extends Controller
{
    public function createSchoolAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $School = new School();
        $form = $this->createForm(SchoolType::class, $School);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($School);
            $em->flush();
            return $this->redirectToRoute("school_add");
        }
        return $this->render('ParentingBundle:school:addschool.html.twig', array(
            "form" => $form->createView()
        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $modele= $em->getRepository(School::class)->find($id);
        $em->remove($modele);
        $em->flush();
        return $this->redirectToRoute("school_add");
    }
    public function readschool1Action()
    {
        $em= $this->getDoctrine()->getManager();
        $schools=$em->getRepository("ParentingBundle:School")->findAll();
        return $this->render('ParentingBundle:school:deleteschool.html.twig', array(
            "schools"=>$schools
        ));
    }
    public function mapAction()
    {
        $name = 'name';
        $em=$this->getDoctrine()->getManager();

        $school=$em->getRepository('ParentingBundle:School')->findAll();

        return $this->render('@Parenting/school/index.html.twig',array('name'=>$name,'school'=>$school));
    }

    public function RechercheAction(Request $request)
    {
        $search =$request->query->get('schoolname');
        $en = $this->getDoctrine()->getManager();
        $schoolname=$en->getRepository("ParentingBundle:School")->findMarque($search);
        return $this->render("ParentingBundle:school:search.html.twig",array(
            'schoolnames' => $schoolname
        ));
    }
    public function mapapiAction()
    {
        $em=$this->getDoctrine()->getManager();

        $school=$em->getRepository('ParentingBundle:School')->findAll();
        $data=$this->get("jms_serializer")->serialize($school,'json');
        return new Response($data);
    }



}
