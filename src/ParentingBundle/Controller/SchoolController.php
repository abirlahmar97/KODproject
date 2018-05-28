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
    public function createSchoolAction(Request $request)
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
        return $this->render('ParentingBundle:school:form.html.twig', array(
            "form" => $form->createView(),
            'title' => 'Ajouter'
        ));
    }

    public function updateSchoolAction($id,Request $request)
    {
        $school = $this->getDoctrine()->getRepository("ParentingBundle:School")->find($id);
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($school);
            $em->flush();
            return $this->redirectToRoute("read_school");
        }
        return $this->render('ParentingBundle:school:form.html.twig', array(
            "form" => $form->createView(),
            'title' => 'Modifier'
        ));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $school= $em->getRepository(School::class)->find($id);
        $em->remove($school);
        $em->flush();
        return $this->redirectToRoute("read_school");
    }
    public function listSchoolAction()
    {
        $em= $this->getDoctrine()->getManager();
        $schools=$em->getRepository("ParentingBundle:School")->findAll();
        return $this->render('ParentingBundle:school:listschool.html.twig', array(
            "schools"=>$schools
        ));
    }
    public function mapAction()
    {
        $name = 'name';
        $em=$this->getDoctrine()->getManager();

        $school=$em->getRepository('ParentingBundle:School')->findAll();

        return $this->render('@Parenting/school/index.html.twig', array(
            'name'=>$name,
            'school'=>$school
        ));
    }

    public function RechercheAction(Request $request)
    {
        $lat =$request->query->get('lat');
        $lng =$request->query->get('lng');
        $em = $this->getDoctrine()->getManager();
        $schools= $em->getRepository("ParentingBundle:School")->findClosest($lat, $lng);
        dump($schools);
        return $this->render("ParentingBundle:school:search.html.twig",array(
            'schools' => $schools
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
