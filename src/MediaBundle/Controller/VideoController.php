<?php

namespace MediaBundle\Controller;

use MediaBundle\Entity\Video;
use MediaBundle\Form\VideoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    public function createvideoAction(Request $request)
    {

        $videos = new Video();
        $form = $this->createForm(videoType::class, $videos);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($videos);
            $em->flush();
            return $this->redirectToRoute("video_add");
        }
        return $this->render('@Media/video/create.html.twig', array(
            "form" => $form->createView()
        ));
    }
    public function readvidAction()
    {
        $em= $this->getDoctrine()->getManager();
        $videos=$em->getRepository("MediaBundle:Video")->findCourses();
        $subjects = $em->getRepository("ParentingBundle:Subject")->findAll();
        return $this->render('@Media/video/readvideo.html.twig', array(
            "videos" => $videos,
            "subjects" => $subjects
        ));
    }

    public function readvideoapiAction()
    {
        $em= $this->getDoctrine()->getManager();
        $teachers=$em->getRepository("MediaBundle:Video")->findAll();
        $data=$this->get("jms_serializer")->serialize($teachers,'json');
        return new Response($data);
    }
}
