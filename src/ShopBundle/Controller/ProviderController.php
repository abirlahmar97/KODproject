<?php

namespace ShopBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use ShopBundle\Entity\Product;
use ShopBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProviderController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('ShopBundle:ProductOrder')->findProfit($this->getUser()->getId());
        $piedata = [];
        $piedata[] = ['Date', 'Produits vendus'];
        foreach ($data as $item){
            $piedata[] = [date_format($item['date'], 'F d, Y') , intval($item['products'])];
        }
//        $v = 0;
//        foreach ($produit1 as $product) {
//                $v = $v + 1;
//        }
//        $produit2 = $em->getRepository('ShopBundle:Product')->findByCategory(6);
//        $v = 0;
//        $cat2 = array();
//        $c = 0;
//        foreach ($produit2 as $prod2) {
//
//                $c = $c + 1;
//            }
//
//        $produit3 =  $em->getRepository('ShopBundle:Product')->findByCategory(5);
//        $cat3 = array();
//        $s = 0;
//        foreach ($produit3 as $prod3) {
//
//                $s = $s + 1;
//
//        }
//        $produit4 =  $em->getRepository('ShopBundle:Product')->findByCategory(7);
//        $cat4 = array();
//        $p = 0;
//        foreach ($produit4 as $prod4) {
//
//
//                $p = $p + 1;
//            }


        $pieChart = new ColumnChart();
        $pieChart->getData()->setArrayToDataTable($piedata);
//        $pieChart->getData()->setArrayToDataTable(
//            [
//                ['categorie', 'nombre de produit'],
//                ['clothes', $v],
//                ['accessoires', $c],
//                ['schooluniform', $s],
//                ['Jouets', $p],
//            ]
//        );

        $pieChart->getOptions()->setTitle('Nombre des produits selon les catégories');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        return $this->render('@Shop/Provider/Home/index.html.twig', array('pieChart' => $pieChart));

    }

    public function createProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product->setUser($this->getUser());
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("list_products");
        }
        return $this->render('ShopBundle:Provider/Products:create.html.twig', array(
            "form" => $form->createView()
        ));
    }

    public function updateProductAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("ShopBundle:Product")->find($id);
        $Form = $this->createForm(ProductType::class, $product);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('list_products');
        }
        return $this->render('@Shop/Provider/Products/update_product.html.twig', array(
            'form' => $Form->createView()
        ));
    }

    public function listProductsAction()
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("ShopBundle:Product")->findforProvider($this->getUser()->getId());
        return $this->render('ShopBundle:Provider/Products:list.html.twig', array(
            "products" => $products
        ));
    }

    public function deleteProductAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("ShopBundle:Product")->find($id);
        $em->remove($product);
        $em->flush();
        return $this->redirecttoRoute("list_products");
    }

    public function deleteProductBulkAction(Request $request)
    {
        $products = $request->get('products');
        $products = explode(',', $products);
        $em = $this->getDoctrine()->getManager();
        foreach ($products as $id) {
            $product = $em->getRepository('ShopBundle:Product')->find($id);
            $em->remove($product);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "Les produits sélectionnées on été supprimés avec succes");
        return $this->redirectToRoute('list_products');
    }

    public function ordersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('ShopBundle:Order')->findAll();
        return $this->render('ShopBundle:Provider/Products:orders.html.twig', array(
            'commandes' => $commandes
        ));
    }

}