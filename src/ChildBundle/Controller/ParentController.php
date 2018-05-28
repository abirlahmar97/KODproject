<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\Child;
use ChildBundle\Form\ChildType;
use MediaBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ParentController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function createSpaceAction(Request $request)
    {
        $child = new Child();
        $form = $this->createForm(ChildType::class, $child);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid() ){
            $em = $this->getDoctrine()->getManager();
            $child->setParent($this->getUser());
            $em->persist($child);
            $em->flush();
            return $this->redirectToRoute("kids_list");
        }
        return $this->render('ChildBundle:Parent:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function createSpaceApidAction(Request $request)
    {
        $child = new Child();
        $child->setName($request->get("name"));
        $child->setAge($request->get("age"));
        $photo = new Photo();
        $photo->setFile($request->files->get('file'));
        $child->setPhoto($photo);
        $child->setGender($request->get("gender"));
            $em = $this->getDoctrine()->getManager();
            $child->setParent($this->getUser());
            $em->persist($child);
            $em->flush();
        return new Response();
    }

    public function listKidsAction()
    {
        $kids = $this->getDoctrine()->getRepository("ChildBundle:Child")
            ->findMyKids($this->getUser()->getId());

        return $this->render('ChildBundle:Parent:kids.html.twig', [
            'kids' => $kids
        ]);
    }

    public function listKidsApiAction()
    {
        $kids = $this->getDoctrine()->getRepository("ChildBundle:Child")
            ->findMyKids($this->getUser());

        $data = $this->get("jms_serializer")->serialize($kids, 'json');
        return new Response($data);
    }

    public function blockGameAction($cid, $gid)
    {
        $child = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($cid);
        $blockedg = $child->getBlockedG();
        if(($key = array_search($gid, $blockedg))!== false)
            unset($blockedg[$key]);
        else
            $blockedg[] = $gid;
        $child->setBlockedG($blockedg);
        $em = $this->getDoctrine()->getManager();
        $em->persist($child);
        $em->flush();
        return $this->redirectToRoute('kid_activity', ['id'=> $cid]);
    }

    public function blockSongAction($cid, $mid)
    {
        $child = $this->getDoctrine()->getRepository("ChildBundle:Child")->find($cid);
        $blockedm = $child->getBlockedM();
        if(($key = array_search($mid, $blockedm))!== false)
            unset($blockedm[$key]);
        else
            $blockedm[] = $mid;
        $child->setBlockedM($blockedm);
        dump($child);
        $em = $this->getDoctrine()->getManager();
        $em->persist($child);
        $em->flush();
        return $this->redirectToRoute('kid_activity', ['id'=> $cid]);
    }

}
