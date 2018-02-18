<?php

namespace MediaBundle\Controller;

use MediaBundle\Entity\Article;
use MediaBundle\Form\ArticleType;
use MediaBundle\Form\recherche;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    public function createAction(Request $request)
    {
        $article = new Article();
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("read");
        }
        return $this->render('@Media/Article/create.html.twig', array(
            "form"=>$form->createView()
        ));


    }

    public function readAction()
    {
            $em= $this->getDoctrine()->getManager();
            $articles=$em->getRepository("MediaBundle:Article")->findAll();
            return $this->render('@Media/Article/read.html.twig', array( "articles" => $articles

            ));
        }

    public function rechercheAction(Request $request)
    {
        $search =$request->query->get('recherche');
        $en = $this->getDoctrine()->getManager();
        $articles=$en->getRepository("MediaBundle:Article")->findSubject($search);
        return $this->render("@Media/Article/recherche_front.html.twig",array(
            'articles' => $articles,'user' => $this->getUser()
        ));

    }

    public function showbyCategoryAction($category)
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("MediaBundle:Article")->findCategory($category);
        dump($articles);
        return $this->render('@Media/Article/readCa.html.twig', array( "articles" => $articles,'user' => $this->getUser()

        ));
    }


    public function updateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository("MediaBundle:Article")->find($id);
        $Form=$this->createForm(ArticleType::class,$article);
        $Form->handleRequest($request);
        if ($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->render("MediaBundle:Article:update.html.twig",array('form'=>$Form->createView()));



    }
    public function deleteAction($id)

        {
            $em=$this->getDoctrine()->getManager();
            $article=$em->getRepository("MediaBundle:Article")->find($id);
            $em->remove($article);
            $em->flush();
            return $this->redirecttoRoute("read");
        }

    public function front_readAction()
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("MediaBundle:Article")->findAide();
        return $this->render('@Media/Article/front_read.html.twig', array(
            "articles" => $articles,'user' => $this->getUser()

        ));
    }

    public function moreAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $article=$em->getRepository("MediaBundle:Article")->find($id);
        $categories=$em->getRepository("ShopBundle:Category")->findArticle();

        return $this->render('@Media/Article/more.html.twig', array( "article" => $article,"categories"=>$categories,'user' => $this->getUser()
        ));
    }



}
