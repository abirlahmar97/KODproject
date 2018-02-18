<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function categorieAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $produits= $em->getRepository('ShopBundle:Product')->byCategorie($category);
        return $this->render('ShopBundle:Default/Produits:showProduits.html.twig', array("produits"=>$produits
        ));

    }
    public function infoProduitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ShopBundle:Product')->find($id);
        return $this->render('ShopBundle:Default/Produits:infoProduit.html.twig', array("produit"=>$produit
        ));
    }

    public function listCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ShopBundle:Category')->findTypeProduct();
        return $this->render('ShopBundle:Default/Categories:menu.html.twig', array(
            'categories' => $categories
        ));
    }












}
