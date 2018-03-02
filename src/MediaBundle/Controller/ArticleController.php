<?php

namespace MediaBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use MediaBundle\Entity\Article;
use MediaBundle\Entity\Rating;
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

            dump($articles);
            return $this->render('@Media/Article/read.html.twig', array( "articles" => $articles

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
            $rating= new Rating();
            $rating->setParent($this->getUser());
            $rating->setArticle($article);


            //incrémenter le nombre de vues
            $article->setViews($article->getViews()+1);
            $em->persist($article);
            $em->flush();
            //Chercher l'article le plus vu
            $max=$em->getRepository('MediaBundle:Article')->findPlusVu();
            //Afficher les catégories d'articles disponibles
            $categories=$em->getRepository("ShopBundle:Category")->findArticle();
        return $this->render('@Media/Article/more.html.twig', array( "article" => $article,"categories"=>$categories,'max'=>$max,'user' => $this->getUser()
        ));



    }
    public function statAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('MediaBundle:Article')->findAide();
        $titles= array();
        $views= array();
        foreach ($articles as $article)
        {
            array_push($titles, $article->getTitle());
            array_push($views, $article->getViews());
        }
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable([
            $titles,$views        ]);
        $bar->getOptions()->setTitle('Nombre de vues');
        $bar->getOptions()->getHAxis()->setTitle('Ids');
//        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('Vues');
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(500);

        return $this->render('@Media/Article/stat.html.twig',array('barchart' => $bar));
    }
    public function RechercheAction(Request $request)
    {
        $search=$request->get('article');
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository("MediaBundle:Article")->findTitle($search);
        $nombre= sizeof($article);
        dump($nombre);
        return $this->render("@Media/Article/front_read.html.twig",array(
            'articles' => $article ,'nombre' => $nombre ,'search' => $search
        ));
    }

    public function indexAction()
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("MediaBundle:Article")->findAide();
        $barStat=array(array("nom","views"));

        foreach ($articles as $article)
        {
            dump($article);

            array_push($barStat,array($article->getTitle(),$article->getViews()));






        }
        dump($barStat);
        var_dump($barStat);

        $bar=new BarChart();
        $bar->getData()->setArrayToDataTable($barStat);
        $bar->getOptions()->setTitle('Avis sur les articles');
        $bar->getOptions()->getVAxis()->setTitle('Noms des articles');
        $bar->getOptions()->getHAxis()->setTitle('Vues');

        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(600);
        dump($bar);
        return $this->render('@Media/Article/stat.html.twig', array('barStat' =>$bar));
    }





}
