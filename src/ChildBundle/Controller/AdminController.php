<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\Game;
use ChildBundle\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function addGamesAction(Request $request){
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        if($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()){
            $devices = implode(',', $game->getDevice());
            $game->setDevice($devices);
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
        }
        return $this->render('ChildBundle:Admin/Games:form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un jeu',
            'btn' => 'Ajouter'
        ]);
    }

    public function listGamesAction(){
        $games = $this->getDoctrine()->getRepository("ChildBundle:Game")->findAll();
        return $this->render("ChildBundle:Admin/Games:list.html.twig", [
            'games' => $games
        ]);
    }
}
