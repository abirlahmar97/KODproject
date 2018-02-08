<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\UserInfos;
use UserBundle\Form\UserInfosType;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Home:index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    public function editProfileAction(Request $request)
    {
        $user = $this->getUser();
        if ($user->getInfos() == null)
            $infos = new UserInfos();
        else {
            $infos = $user->getInfos();
        }
        $form = $this->createForm(UserInfosType::class, $infos);
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid() ){
            $user->setInfos($infos);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
        return $this->render('@User/Home/editprofile.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

}
