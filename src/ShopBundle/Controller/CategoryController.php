<?php

namespace ShopBundle\Controller;


use ShopBundle\Entity\Category;
use ShopBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function addCategoryAction(Request $request)
    {
        $category = new Category();
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute("show_category");
        }
        return $this->render('@Shop/Provider/Categories/add.html.twig', array("form"=>$form->createView()

        ));
    }

    public function showCategoryAction()
    {

        $em= $this->getDoctrine()->getManager();
        $categories=$em->getRepository("ShopBundle:Category")->findAll();
        return $this->render('@Shop/Provider/Category/showcategory.html.twig', array("categories"=>$categories
        ));
    }
    public function deletCategoryBulkAction(Request $request){
        $categories = $request->get('categories');
        $categories = explode(',', $categories);
        $em = $this->getDoctrine()->getManager();
        foreach ($categories as $id){
            $category = $em->getRepository('ShopBundle:Category')->find($id);
            $em->remove($category);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "Les cateogries sélectionnées on été supprimés avec succes");
        return $this->redirectToRoute('show_category');
    }

    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ShopBundle:Category')->findAll();
        return $this->render('ShopBundle:Default/Categories:menu.html.twig', array(
            'categories' => $categories
        ));
    }

}
