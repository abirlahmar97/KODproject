<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use ShopBundle\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProductController extends Controller
{
    public function categorieAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ShopBundle:Product')->byCategorie($category);
        return $this->render('ShopBundle:Default/Produits:showProduits.html.twig', array("produits" => $produits
        ));

    }

    public function infoProduitAction(Request $request, $id, SessionInterface $session)
    {
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());
            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }
        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ShopBundle:Product')->find($id);
        if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        return $this->render('ShopBundle:Default/Produits:infoProduit.html.twig', array("produit" => $produit, 'panier' => $panier,
            'comments' => $comments,
            'thread' => $thread
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

    public function produitsAction(Category $categorie = null, SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();

        if ($categorie != null)
            $produits = $em->getRepository('ShopBundle:Product')->byCategorie($categorie);
        else
            $produits = $em->getRepository('ShopBundle:Product')->findBy(array('available' => 1));

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;

        return $this->render('ShopBundle:Default/Produits:showProduits.html.twig', array('produits' => $produits,
            'panier' => $panier));
    }

    public function relatedcategorieAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ShopBundle:Product')->byCategorie($category);
        dump($produits);
        return $this->render('ShopBundle:Default/Produits:relatedproduit.html.twig', array(
            "produits" => $produits
        ));

    }


}
