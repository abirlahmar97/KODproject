<?php

namespace MediaBundle\Controller;

use MediaBundle\Entity\video;
use MediaBundle\Form\videoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class videoController extends Controller
{
    public function createvideoAction(\Symfony\Component\HttpFoundation\Request $request)
    {

        $videos = new video();
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
        $videos=$em->getRepository("MediaBundle:video")->findAll();
        return $this->render('@Media/video/readvideo.html.twig', array(
            "videos"=>$videos
        ));
    }
}
