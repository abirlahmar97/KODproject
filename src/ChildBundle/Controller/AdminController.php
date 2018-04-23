<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\Cartoon;
use ChildBundle\Entity\Game;
use ChildBundle\Form\CartoonType;
use ChildBundle\Form\GameType;
use MediaBundle\Entity\Video;
use MediaBundle\Form\videoType;
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
            return $this->redirectToRoute('games_list');
        }
        return $this->render('ChildBundle:Admin/Games:form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un jeu',
            'btn' => 'Ajouter'
        ]);
    }

    public function editGamesAction($id, Request $request){
        $game = $this->getDoctrine()->getRepository('ChildBundle:Game')->find($id);
        $form = $this->createForm(GameType::class, $game);
        if($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
            return $this->redirectToRoute('games_list');
        }
        return $this->render('ChildBundle:Admin/Games:form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier un jeu',
            'btn' => 'Sauvegarder'
        ]);
    }

    public function listGamesAction(){
        $games = $this->getDoctrine()->getRepository("ChildBundle:Game")->findAll();
        return $this->render("ChildBundle:Admin/Games:list.html.twig", [
            'games' => $games
        ]);
    }

    public function sendMailAction(){
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                "Test Mailer",
                'text/html'
            );
        // or, you can also fetch the mailer service this way
            $failures = null;
         $this->get('mailer')->send($message, $failures);
        dump($failures);
        return $this->render("UserBundle:Admin/Home:index.html.twig");
    }

    public function addCartoonAction(Request $request){
        $cartoon = new Cartoon();
        $form = $this->createForm(CartoonType::class, $cartoon);
        if($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cartoon);
            $em->flush();
            return $this->redirectToRoute("episodes_add", [ "id" => $cartoon->getId() ]);
        }
        return $this->render('ChildBundle:Admin/Cartoon:form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un dessin animé',
            'btn' => 'Ajouter'
        ]);
    }

    public function addEpisodesAction(Request $request, $id){

        $episode = new Video();
        $action = $request->get('action');
        $cartoon = $this->getDoctrine()->getRepository("ChildBundle:Cartoon")->find($id);
        $category = $this->getDoctrine()
            ->getRepository("ShopBundle:Category")
            ->findOneBy(['name' => 'Cartoon']);
        $episode->setCartoon($cartoon);
        $episode->setCategory($category);
        $form = $this->createForm(videoType::class, $episode);
        $form->remove('subject')->remove('type')->add('name');
        if($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($episode);
            $em->flush();
            if($action == "stay")
                return $this->redirectToRoute('episodes_add');
            else
                return $this->redirectToRoute('episodes_list', $id);
        }
        return $this->render('ChildBundle:Admin/Episodes:form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un dessin animé'
        ]);
    }

    public function listCartoonAction(){
        $cartoons = $this->getDoctrine()->getRepository("ChildBundle:Cartoon")->findAll();
        return $this->render("ChildBundle:Admin/Cartoon:list.html.twig", [
            'cartoons' => $cartoons
        ]);
    }


    public function listQuizesAction($id, Request $request){
        $quizes = $this->getDoctrine()->getRepository("ChildBundle:Quiz")->findAll();
        return $this->render("ChildBundle:Admin/quizes:list.html.twig", [
            'quizes' => $quizes
        ]);
    }
}
