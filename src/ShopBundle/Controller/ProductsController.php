<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use ShopBundle\Entity\Product;
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
            "products" => $products,
            'category' => $category
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
        $category = $request->get('category');
        if($request->get('filters')){
            $data = $request->get('filters');
            $filters = json_decode($data);
            $gender = $filters[0]->value;
            $age = $filters[1]->value;
            $price = explode(';', $filters[2]->value);
            $pricemin = $price[0];
            $pricemax = $price[1];
            $products = $this->getDoctrine()->getRepository("ShopBundle:Product")->search($category,$age,$gender,$pricemin,$pricemax);
        } else {
            $data = $request->get('name');
            $products = $this->getDoctrine()->getRepository("ShopBundle:Product")->searchProduct($data, $category);
        }
        return $this->render('ShopBundle:Products:search.html.twig', [
            'products' => $products
        ]);
    }

    public function listCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ShopBundle:Category')->findTypeProduct();
        return $this->render('ShopBundle:Categories:menu.html.twig', array(
            'categories' => $categories
        ));
    }

    public function productsAction(Category $category = null, SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();

        if ($category != null)
            $products = $em->getRepository('ShopBundle:Product')->byCategory($category);
        else
            $products = $em->getRepository('ShopBundle:Product')->findAvailable();

        if ($session->has('cart'))
            $cart = $session->get('cart');
        else
            $cart = false;
        dump($category);
        return $this->render('ShopBundle:Products:list.html.twig', array(
            'products' => $products,
            'category' => $category,
            'cart' => $cart
        ));
    }

    public function relatedAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ShopBundle:Product')->byCategory($category);
        return $this->render('ShopBundle:Products:related.html.twig', array(
            "products" => $products
        ));

    }
    public function listProductsapiAction()
    {
        $products = $this->getDoctrine()->getRepository("ShopBundle:Product")->findAll();
        $data=$this->get("jms_serializer")->serialize($products,'json');
        return new Response($data);
    }

    public function listCategoriesApiAction(){
        $categories = $this->getDoctrine()->getRepository("ShopBundle:Category")->findAll();
        $data = $this->get("jms_serializer")->serialize($categories, 'json');
        return new Response($data);
    }


    public function listCommentapiAction($id){
        $thread = $this->getDoctrine()->getRepository("ShopBundle:Thread")->find($id);
        $commentaires = $this->getDoctrine()->getRepository("ShopBundle:Comment")->findByUserProduct($thread);
        $data = $this->get("jms_serializer")->serialize($commentaires, 'json');
        return new Response($data);
    }


    public function api_createAction(Request $request)
    {   $data = $request->getContent();
        $em = $this->getDoctrine()->getManager();
        $pos = $this->get("jms_serializer")->deserialize($data, "UserBundle\Entity\Complaint", "json");
        $complaint = new Complaint();
        $em = $this->getDoctrine()->getManager();

        $complaint->setParent($this->getUser());
        $complaint->setDate($pos->getDate());
        $complaint->setState($pos->getState());
        $category= $em->getRepository("ShopBundle:Category")->find($pos->getCategory()->getId());
        $complaint->setCategory($category);
        $complaint->setSubject($pos->getSubject());
        $complaint->setDescription($pos->getDescription());

        $em->persist($complaint);
        $em->flush();

        return new Response();


    }

    public function countCommentairesApiAction($id){
        $product= $this->getDoctrine()->getRepository("ShopBundle:Product")->find($id);
        $nbre = $this->getDoctrine()->getRepository("ShopBundle:Thread")->find($product);
        $data = $this->get("jms_serializer")->serialize($nbre, 'json');
        return new Response($data);
    }


}
