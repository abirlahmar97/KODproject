<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use ShopBundle\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProductsController extends Controller
{
    public function categoryAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ShopBundle:Product')->byCategory($category);
        return $this->render('ShopBundle:Products:list.html.twig', array(
            "products" => $products
        ));

    }

    public function detailsAction(Request $request, $id, SessionInterface $session)
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
        $product = $em->getRepository('ShopBundle:Product')->find($id);
        if (!$product) throw $this->createNotFoundException('La page n\'existe pas.');

        if ($session->has('cart'))
            $cart = $session->get('cart');
        else
            $cart = false;
        
        return $this->render('ShopBundle:Products:details.html.twig', array(
            "product" => $product,
            'cart' => $cart,
            'comments' => $comments,
            'thread' => $thread
        ));
    }

    public function searchAction(Request $request){
        $data = $request->get('filters');
        $filters = json_decode($data);
        $gender = $filters[0]->value;
        $age = $filters[1]->value;
        $price = explode(';', $filters[2]->value);
        $pricemin = $price[0];
        $pricemax = $price[1];
        $products = $this->getDoctrine()->getRepository("ShopBundle:Product")->search($age,$gender,$pricemin,$pricemax);
        return $this->render('ShopBundle:Products:search.html.twig', [
            'products' => $products
        ]);
    }

    public function listCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ShopBundle:Category')->findTypeProduct();
        return $this->render('ShopBundle:Default/Categories:menu.html.twig', array(
            'categories' => $categories
        ));
    }

    public function productsAction(Category $category = null, SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();

        if ($category != null)
            $products = $em->getRepository('ShopBundle:Product')->byCategory($category);
        else
            $products = $em->getRepository('ShopBundle:Product')->findBy(array('available' => 1));

        if ($session->has('cart'))
            $cart = $session->get('cart');
        else
            $cart = false;

        return $this->render('ShopBundle:Products:list.html.twig', array(
            'products' => $products,
            'cart' => $cart));
    }

    public function relatedAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ShopBundle:Product')->byCategory($category);
        return $this->render('ShopBundle:Products:related.html.twig', array(
            "products" => $products
        ));

    }


}
