<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\ChildGame;
use ChildBundle\Entity\ChildVideo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChildController extends Controller
{

    public function activityAction(Request $request, $id){
        $plays = $this->getDoctrine()->getRepository("ChildBundle:ChildGame")->findForChild($id);
        $child = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($id);
        return $this->render("@Child/Child/activity.html.twig", [
            'child' => $child,
            'plays' => $plays
        ]);
    }

    public function spaceAction($id){
        $games = $this->getDoctrine()->getRepository("ChildBundle:Game")->findAll();
        $songs = $this->getDoctrine()->getRepository("MediaBundle:Music")->findAll();
        $played = $this->getDoctrine()->getRepository('ChildBundle:ChildGame')
            ->playedToday($id);
        $kid = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($id);
        $cartoons = $this->getDoctrine()->getRepository('ChildBundle:Cartoon')->findMatch(
            $kid->getGender(),
            $kid->getAge()
        );
        $allowed_time = 0;
        if($kid->getAge() < 2)
            $allowed_time = 60*45;
        elseif($kid->getAge() < 5)
            $allowed_time = 3600 + 60*30;
        elseif($kid->getAge() < 8)
            $allowed_time = 3600 * 3;
        elseif($kid->getAge() < 12)
            $allowed_time = 3600 * 5;

        return $this->render('ChildBundle:Child:index.html.twig', [
            'child' => $kid,
            'games' => $games,
            'songs' => $songs,
            'cartoons' => $cartoons,
            'allowed' => $allowed_time - $played[0]['played_time']
        ]);
    }

    public function saveActivityAction(Request $request, $activity)
    {
        $childActivity = 'ChildBundle\Entity\Child'.$activity;
        $childGame = new $childActivity();
        $child = $request->get('cid');
        $duration = $request->get('duration');
        $activity_id = $request->get('aid');
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $childGame->setChild($em->getRepository('ChildBundle:Child')->find($child));
            $setActivity = 'set' . $activity;
            $childGame->$setActivity($em->getRepository('ChildBundle:' . $activity)->find($activity_id));
            $date = new \DateTime();
            $date->setTime(0,0, (integer) $duration);
            $childGame->setDuration($date);
            $childGame->setDate(new \DateTime());
            $em->persist($childGame);
            $em->flush();
        }
        return new Response();
    }

}
