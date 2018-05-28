<?php

namespace ChildBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartoonController extends Controller
{
    public function listEpisodesAction($id, Request $request){
        $cartoon = $this->getDoctrine()->getRepository('ChildBundle:Cartoon')->find($id);
        $episodes = $this->getDoctrine()->getRepository("MediaBundle:Video")->findCartoon($id);
        if($request->isXmlHttpRequest())
            return $this->render("ChildBundle:Cartoon:details.html.twig", [
                'episodes' => $episodes,
                'cartoon' => $cartoon
            ]);
        return $this->render("ChildBundle:Admin/Episodes:list.html.twig", [
            'episodes' => $episodes,
            'cartoon' => $cartoon
        ]);
    }

    public function episodeWatchAction(Request $request){
        if($request->get('id')){
            $id = $request->get('id');
            $episode = $this->getDoctrine()->getRepository('MediaBundle:Video')->find($id);
            $data = $this->get('jms_serializer')->serialize($episode, 'json');
            return new Response($data, 200);
        }
        return new Response("Episode introuvable", 400);
    }
}
