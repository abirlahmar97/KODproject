<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\ChildGame;
use ChildBundle\Entity\ChildVideo;
use ChildBundle\Entity\ChildMusic;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChildController extends Controller
{

    public function activityAction(Request $request, $id){
        $plays = $this->getDoctrine()->getRepository("ChildBundle:ChildGame")->findForChild($id);
        $listenings = $this->getDoctrine()->getRepository("ChildBundle:ChildMusic")->findForChild($id);

//        $playTime = $this->getDoctrine()->getRepository("ChildBundle:ChildGame")->playTime($id);
//        $musicTime = $this->getDoctrine()->getRepository("ChildBundle:ChildMusic")->musicTime($id);
//        $videoTime = $this->getDoctrine()->getRepository("ChildBundle:ChildVideo")->videoTime($id);
//        $quizTime = $this->getDoctrine()->getRepository("ChildBundle:ChildQuiz")->quizTime($id);
//        $total = $playTime + $musicTime + $videoTime + $quizTime;
//        $pieChart->getData()->setArrayToDataTable(
//            [
//                ['Pac Man', 'Percentage'],
//                ['Jeux', $playTime[0]['played_time']],
//                ['Dessins animés', $videoTime[0]['played_time'] ],
//                ['Quizes', $quizTime[0]['played_time'] ],
//                ['Musique', $musicTime[0]['played_time']]
//            ]
//        );
        $child = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($id);
        return $this->render("@Child/Child/activity.html.twig", [
            'child' => $child,
            'listenings' => $listenings,
            'plays' => $plays,
//            'pieChart' => $pieChart
        ]);
    }

    public function activityApiAction($id)
    {
        $plays = $this->getDoctrine()->getRepository("ChildBundle:ChildGame")->findForChild($id);
        $listenings = $this->getDoctrine()->getRepository("ChildBundle:ChildMusic")->findForChild($id);
        $child = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($id);
        $data = [
            'plays' => $plays,
            'listenings' => $listenings,
            'child' => $child
        ];
        $data_json = $this->get('jms_serializer')->serialize($data, 'json');
        return new Response($data_json);
    }

    public function spaceAction($id){
        $kid = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($id);
        $games = $this->getDoctrine()->getRepository("ChildBundle:Game")->findAllowed($kid->getBlockedG());
        $songs = $this->getDoctrine()->getRepository("MediaBundle:Music")->findAllowed($kid->getBlockedM());
        $played = $this->getDoctrine()->getRepository('ChildBundle:ChildGame')
            ->playedToday($id);
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
        $bundle = ($activity == "Music" || $activity == "Video") ? 'Media' : 'Child';
        $childGame = new $childActivity();
        $child = $request->get('cid');
        $duration = $request->get('duration');
        $activity_id = $request->get('aid');
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $childGame->setChild($em->getRepository('ChildBundle:Child')->find($child));
            $setActivity = 'set' . $activity;
            $childGame->$setActivity($em->getRepository($bundle .'Bundle:' . $activity)->find($activity_id));
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
