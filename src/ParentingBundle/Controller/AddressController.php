<?php

namespace ParentingBundle\Controller;

use ParentingBundle\Entity\Address;
use ParentingBundle\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddressController extends Controller
{
    public function createAction(Request $request)
    {
        $address = new Address();
        $form=$this->createForm(AddressType::class,$address);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute("read_address");
        }
        return $this->render('@Parenting/Address/create.html.twig', array(
            "form"=>$form->createView()
        ));


    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $address=$em->getRepository("ParentingBundle:Address")->find($id);
        $em->remove($address);
        $em->flush();
        return $this->redirecttoRoute("read_address");
    }

    public function readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $addresses = $em->getRepository("ParentingBundle:Address")->findAll();
        return $this->render('@Parenting/Address/read.html.twig', array(
            "addresses" => $addresses

        ));

    }

    public function updateAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $address=$em->getRepository("ParentingBundle:Address")->find($id);
        $Form=$this->createForm(AddressType::class,$address);
        $Form->handleRequest($request);
        if ($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute('read_address');
        }
        return $this->render("@Parenting/Address/update.html.twig",array(
            'form'=>$Form->createView()
        ));
    }

    public function mapAction()
    {
       return $this->render('@Parenting/Address/map.html.twig');
    }

    public function map2Action($id)
    {   $em=$this->getDoctrine()->getManager();
        $address=$em->getRepository('ParentingBundle:Address')->find($id);
        $Latitudes= $address->getLat();
        $Longitudes=$address->getLng();

        return $this->render('@Parenting/Address/map2.html.twig',array('Latitudes'=>$Latitudes,'Longitudes'=>$Longitudes));
    }

    public function front_readAction()
    {
        $em= $this->getDoctrine()->getManager();
        $addresses=$em->getRepository("ParentingBundle:Address")->findAlphabet();
        dump($addresses);
        return $this->render('@Parenting/Address/front_read.html.twig', array(
            "addresses" => $addresses,'user' => $this->getUser()

        ));
    }

    public function moreAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository("ParentingBundle:Address")->find($id);
        $em->persist($address);
        $em->flush();
        $categories=$em->getRepository("ShopBundle:Category")->findBy(['type' => 'adresses']);
        $Latitudes= $address->getLat();
        $Longitudes=$address->getLng();
        return $this->render('@Parenting/Address/more.html.twig', array(
            'address'=>$address,
            'categories'=>$categories,
            'Latitudes'=>$Latitudes,
            'Longitudes'=>$Longitudes
        ));
    }

    public function showbyCategoryAction($category)
    {
        $em= $this->getDoctrine()->getManager();
        $addresses=$em->getRepository("ParentingBundle:Address")->findCategory($category);
        return $this->render('@Parenting/Address/readCa.html.twig', array(
            "addresses" => $addresses
        ));
    }
}
