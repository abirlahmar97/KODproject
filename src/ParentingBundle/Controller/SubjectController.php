<?php

namespace ParentingBundle\Controller;

use ParentingBundle\Entity\Subject;
use ParentingBundle\Form\SubjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SubjectController extends Controller
{
    public function createAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $Subjects = new Subject();
        $form = $this->createForm(SubjectType::class, $Subjects);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Subjects);
            $em->flush();
            return $this->redirectToRoute("subject_add");
        }
        return $this->render('ParentingBundle:Subjects:addSubject.html.twig', array(
            "form" => $form->createView()
        ));
    }
}
