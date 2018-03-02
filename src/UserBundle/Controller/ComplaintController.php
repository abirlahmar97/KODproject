<?php

namespace UserBundle\Controller;

use ShopBundle\Entity\Category;
use ShopBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Complaint;
use UserBundle\Form\ComplaintType;

class ComplaintController extends Controller
{
    public function createAction(Request $request)
    {
        if (! $this->isGranted('ROLE_ADMIN')) {
            $complaint = new Complaint();
            $form = $this->createForm(ComplaintType::class, $complaint);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $complaint->setParent($this->getUser());
                $complaint->setState('non_traitee');
                $complaint->setDate(new \DateTime());
                $em->persist($complaint);
                $em->flush();
                return $this->redirectToRoute("front_read_complaint");
            }


        }
        return $this->render('@User/Complaint/create.html.twig', array(
            "form" => $form->createView(), 'user' => $this->getUser()
        ));

    }

    public function readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $complaints = $em->getRepository("UserBundle:Complaint")->findAll();
        dump($complaints);
        return $this->render('@User/Complaint/read.html.twig', array("complaints" => $complaints

        ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $complaints = $em->getRepository("UserBundle:Complaint")->findAll();
        $complaint = $em->getRepository("UserBundle:Complaint")->find($id);

            if ($complaint->getState() !== 'traitee')
            {
                $complaint->setState('traitee');
                $em->persist($complaint);
                $em->flush();

            }

        return $this->redirectToRoute('read_complaint');


    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $complaint = $em->getRepository('UserBundle:Complaint')->find($id);
        if ($complaint->getState()=='traitee')
        {
            $em->remove($complaint);
            $em->flush();

        }
        return $this->redirectToRoute('read_complaint');


    }

    public function front_readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $complaints = $em->getRepository("UserBundle:Complaint")->findUser($this->getUser());
        return $this->render('@User/Complaint/front_read.html.twig', array("complaints" => $complaints, 'user' => $this->getUser()

        ));
    }
    public function pdfAction()
    {
        $em=$this->getDoctrine()->getManager();
        $complaints=$em->getRepository("UserBundle:Complaint")->findUser($this->getUser());
        $snappy = $this->get('knp_snappy.pdf');
        $html = $this->renderView('@User/Complaint/pdf.html.twig', array(
            'complaints' => $complaints,'user'=> $this->getUser()
        ));

        $filename = 'Historique des réclamations';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }


}
