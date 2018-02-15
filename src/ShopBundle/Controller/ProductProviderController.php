<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Product;
use ShopBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductProviderController extends Controller
{
    public function createProductAction(Request $request)
    {
        $product = new Product();
        $form=$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("show_product");
        }
        return $this->render('ShopBundle:Provider/Products:create.html.twig', array(
            "form"=>$form->createView()
        ));
    }

    public function updateProductAction(Request $request , $id)
    {
        $em=$this->getDoctrine()->getManager();
        $product=$em->getRepository("ShopBundle:Product")->find($id);
        $Form=$this->createForm(ProductType::class,$product);
        $Form->handleRequest($request);
        if ($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('show_product');
        }
        return $this->render('@Shop/Provider/Products/update_product.html.twig', array(
           'form'=>$Form->createView()
        ));
    }

    public function showProductAction()
    {

        $em= $this->getDoctrine()->getManager();
        $products=$em->getRepository("ShopBundle:Product")->findAll();
        return $this->render('ShopBundle:Provider/Products:list.html.twig', array("products"=>$products
            // ...
        ));
    }

    public function deleteProductAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $product=$em->getRepository("ShopBundle:Product")->find($id);
        $em->remove($product);
        $em->flush();
        return $this->redirecttoRoute("show_product");

    }

    public function deleteProductBulkAction(Request $request){
        $products = $request->get('products');
        $products = explode(',', $products);
        $em = $this->getDoctrine()->getManager();
        foreach ($products as $id){
            $product = $em->getRepository('ShopBundle:Product')->find($id);
            $em->remove($product);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "Les produits sélectionnées on été supprimés avec succes");
        return $this->redirectToRoute('show_product');
    }

}
