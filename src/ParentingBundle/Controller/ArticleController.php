<?php

namespace ParentingBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use GuzzleHttp\Message\Response;
use ParentingBundle\Entity\Article;
use ParentingBundle\Entity\Rating;
use ParentingBundle\Form\ArticleType;
use ParentingBundle\Form\recherche;
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

        return $this->render('@Parenting/Article/create.html.twig', array(
            "form"=>$form->createView()
        ));


    }

    public function readAction()
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("ParentingBundle:Article")->findAll();
        return $this->render('@Parenting/Article/read.html.twig', array(
            "articles" => $articles
        ));
    }

    public function showbyCategoryAction($category)
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("ParentingBundle:Article")->findCategory($category);
        return $this->render('@Parenting/Article/readCa.html.twig', array(
            "articles" => $articles
        ));
    }


    public function updateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository("ParentingBundle:Article")->find($id);
        $Form=$this->createForm(ArticleType::class,$article);
        $Form->handleRequest($request);
        if ($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->render("ParentingBundle:Article:update.html.twig", array(
            'form'=>$Form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository("ParentingBundle:Article")->find($id);
        $em->remove($article);
        $em->flush();
        return $this->redirecttoRoute("read");
    }

    public function frontReadAction()
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("ParentingBundle:Article")->findAll();
        return $this->render('@Parenting/Article/front_read.html.twig', array(
            "articles" => $articles
        ));
    }

    public function frontReadApiAction()
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("ParentingBundle:Article")->findAll();
        $data= $this->get("jms_serializer")->serialize($articles,'json');
        return new \Symfony\Component\HttpFoundation\Response($data);

    }


    public function moreApiAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $article=$em->getRepository("ParentingBundle:Article")->find($id);

        //incrémenter le nombre de vues
        $article->setViews($article->getViews()+1);
        $em->persist($article);
        $em->flush();
        //Chercher l'article le plus vu
        $max=$em->getRepository('ParentingBundle:Article')->findPlusVu();
        //Afficher les catégories d'articles disponibles
        $categories=$em->getRepository("ShopBundle:Category")->findBy(['type' => 'Articles']);
        $data= $this->get("jms_serializer")->serialize($article,'json');

        return new \Symfony\Component\HttpFoundation\Response($data);


    }

    public function statAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository('ParentingBundle:Article')->findAide();
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

        return $this->render('@Parenting/Article/stat.html.twig',array(
            'barchart' => $bar
        ));
    }

    public function searchAction(Request $request)
    {
        $search=$request->get('article');
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository("ParentingBundle:Article")->findTitle($search);
        $nombre= sizeof($article);
        return $this->render("@Parenting/Article/front_read.html.twig",array(
            'articles' => $article ,
            'nombre' => $nombre ,
            'search' => $search
        ));
    }

    public function indexAction()
    {
        $em= $this->getDoctrine()->getManager();
        $articles=$em->getRepository("ParentingBundle:Article")->findAide();
        $barStat=array(array("nom","views"));

        foreach ($articles as $article)
        {
            array_push($barStat,array(
                $article>getTitle(),
                $produit->getValeur()
            ));
        }

        $bar=new BarChart();
        $bar->getData()->setArrayToDataTable($barStat);
        $bar->getOptions()->setTitle('Avis sur les produits');
        $bar->getOptions()->getVAxis()->setTitle('Noms des produits');
        $bar->getOptions()->getHAxis()->setTitle('Vues');

        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(600);
        return $this->render('CupCakesBundle:Patisserie/Produit:stat.html.twig', array(
            'barchart' =>$bar
        ));
    }





}
