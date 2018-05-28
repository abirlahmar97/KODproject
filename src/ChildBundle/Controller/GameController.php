<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{
    public function bulkAddAction(Request $request){
        $data = $request->getContent();
        $games = json_decode($data)->games;
        $em = $this->getDoctrine()->getManager();
        foreach ($games as $game){
            $newGame = new Game();
            $newGame->setName($game->title);
            $category = $em->getRepository("ShopBundle:Category")
                ->findOneBy(['name' => 'Any']);
            $newGame->setCategory($category);
            $newGame->setDevice([1,2,3]);
            $newGame->setAge(2);
            $newGame->setGender(2);
            $newGame->setUrl($game->url);
            $em->persist($newGame);
        }
        $em->flush();
        return new Response();
    }

    public function listGamesAPIAction()
    {
        $games = $this->getDoctrine()->getRepository("ChildBundle:Game")->findBy([], null,20);
        $data = $this->get("jms_serializer")->serialize($games, "json");
        return new Response($data);
    }

    public function recentGamesAction(Request $request){
        $kid = $request->get('id');
        $games = $this->getDoctrine()->getRepository('ChildBundle:ChildGame')->recentGames($kid);
//        $data = $this->get('jms_serializer')->serialize($games, 'json');
        return $this->render('@Child/Admin/Games/recent.html.twig', [
            'games' => $games
        ]);
    }

    public function relatedGamesAction(Request $request){
        $category = $request->get('category');
        $games = $this->getDoctrine()->getRepository('ChildBundle:Game')
            ->findRelated($category);
//        $data = $this->get('jms_serializer')->serialize($games, 'json');
        return $this->render('ChildBundle:Child:related.html.twig', [
            'games' => $games
        ]);
    }

    public function blockGameAction($cid, $gid)
    {
        $child = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($cid);
        $blockedg = $child->getBlockedG();
        if(($key = array_search($gid, $blockedg))!== false)
            unset($blockedg[$key]);
        else
            $blockedg[] = $gid;
        $child->setBlockedG($blockedg);
        $em = $this->getDoctrine()->getManager();
        $em->persist($child);
        $em->flush();
        return $this->redirectToRoute('kid_activity', ['id'=> $cid]);
    }

    public function blockGameApiAction(Request $request)
    {
        $cid = $request->get("child");
        $gid = $request->get("game");
        $child = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($cid);
        if ($child == null)
            return new Response("Child not found",400);
        $game = $this->getDoctrine()->getRepository("ChildBundle:Game")->find($gid);
        if ($game == null)
            return new Response("Game not found",400);
        $blockedg = $child->getBlockedG();
        if(($key = array_search($gid, $blockedg)))
            unset($blockedg[$key]);
        else
            $blockedg[] = $gid;
        $child->setBlockedG($blockedg);
        $em = $this->getDoctrine()->getManager();
        $em->persist($child);
        $em->flush();
        return new Response("");
    }
}
