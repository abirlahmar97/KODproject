<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ShopBundle\Entity\Category;
use ShopBundle\Form\CategoryType;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use UserBundle\Entity\UserInfos;
use UserBundle\Form\UserInfosType;

class AdminController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $providers = $em->getRepository('UserBundle:User')->byFournisseur();
        return $this->render('ShopBundle:Admin/Providers:list.html.twig', array(
            "providers" => $providers
        ));
    }

    public function addAction(Request $request)
    {
        $provider = new User();
        $form = $this->createForm(UserType::class, $provider)
            ->remove('roles')
            ->add('infos', UserInfosType::class);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('fos_user.util.user_manipulator')->create(
                $provider->getUsername(),
                $provider->getPassword(),
                $provider->getEmail(),
                true,false
            );
            $this->get('fos_user.util.user_manipulator')->addRole($provider->getUsername(), 'ROLE_PROVIDER');
            $em = $this->getDoctrine()->getManager();
            $newp = $em->getRepository('UserBundle:User')->findOneBy(['username' => $provider->getUsername() ]);
            $newp->setInfos($provider->getInfos());
            $em->persist($newp);
            $em->flush();
            return $this->redirectToRoute("list_providers");
        }
        return $this->render('ShopBundle:Admin/Providers:add.html.twig', array(
            "form" => $form->createView()
        ));
    }
    public function addCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute("show_category");
        }
        return $this->render('ShopBundle:Provider/Categories:add.html.twig', array(
            "form"=>$form->createView()
        ));
    }

    public function showCategoryAction()
    {
        $em= $this->getDoctrine()->getManager();
        $categories=$em->getRepository("ShopBundle:Category")->findAll();
        return $this->render('@Shop/Provider/Categories/list.html.twig', array(
            "categories"=>$categories
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